<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Lead;
use App\Models\Client;
use App\Models\Report;
use Flash;
use App\Models\Order;

class ReportController extends AppBaseController
{
    /** @var ReportRepository $reportRepository*/
    private $reportRepository;

    public function __construct(ReportRepository $reportRepo)
    {
        $this->reportRepository = $reportRepo;
    }

    /**
     * Display a listing of the Report.
     */
    public function index(Request $request)
    {
        $query = Report::query();
    
        // Check if search terms are provided and filter accordingly
        if ($request->has('search')) {
            $search = $request->get('search');
    
            $query->where(function ($q) use ($search) {
                $q->orWhereHas('lead', function($q) use ($search) {
                    $q->where('full_name', 'like', "%$search%");
                })
                ->orWhereHas('client', function($q) use ($search) {
                    $q->where('full_name', 'like', "%$search%");
                })
                ->orWhere('lead_date', 'like', "%$search%")
                ->orWhere('client_date', 'like', "%$search%")
                ->orWhereHas('product', function($q) use ($search) {
                    $q->where('product_name', 'like', "%$search%");
                });
            });
        }
    
        // Get the reports with the necessary relationships (lead, client, product)
        $reports = $query->with(['lead', 'client', 'product'])->paginate(10);
    
        // Fetch the employees and clients for the dropdown
        $employees = Employee::all();
        $clients = Client::all();
    
        // Return the view with reports, employees, and clients
        return view('reports.index', compact('reports', 'employees', 'clients'));
    }
    

    /**
     * Show the form for creating a new Report.
     */
    public function create()
    {
        // Fetch all products, leads, and clients for the dropdowns
        $products = Product::pluck('product_name', 'id');
        $leads = Lead::pluck('full_name', 'id');
        $clients = Client::pluck('full_name', 'id');  // Fetch clients similarly to leads
        
        // Pass the data to the view
        return view('reports.create', compact('products', 'leads', 'clients'));
    }
    

    /**
     * Store a newly created Report in storage.
     */
    public function store(CreateReportRequest $request)
    {
        $input = $request->all();
    
        // Ensure that quantity_ordered is passed and is valid
        $request->validate([
            'quantity_ordered' => 'required|integer|min:1',
        ]);
    
        // Fetch the quantity ordered from orders table
        $totalQuantityOrdered = Order::where('lead_id', $input['lead_id'])
            ->where('client_id', $input['client_id'])
            ->sum('quantity_ordered');
    
        // If quantity_ordered is not set in the request, use the sum from the orders table
        if (!isset($input['quantity_ordered']) || $input['quantity_ordered'] === null) {
            $input['quantity_ordered'] = $totalQuantityOrdered;
        }
    
        // Create the report using the validated data
        $report = Report::create($input);  // Assuming $input is valid
    
        Flash::success('Report saved successfully.');
    
        return redirect(route('reports.index'));
    }
    

    /**
     * Display the specified Report.
     */
    public function show($id)
    {
        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        return view('reports.show')->with('report', $report);
    }

    /**
     * Show the form for editing the specified Report.
     */
    public function edit($id)
    {
        $report = $this->reportRepository->find($id);
    
        if (empty($report)) {
            Flash::error('Report not found');
    
            return redirect(route('reports.index'));
        }
    
        // Fetch the list of products
        $products = Product::pluck('product_name', 'id');
    
        return view('reports.edit', compact('report', 'products'));
    }
    

    /**
     * Update the specified Report in storage.
     */
    public function update($id, UpdateReportRequest $request)
    {
        $report = Report::find($id);
    
        if (empty($report)) {
            Flash::error('Report not found');
            return redirect(route('reports.index'));
        }
    
        // Ensure quantity_ordered is valid
        $request->validate([
            'quantity_ordered' => 'required|integer|min:1',
        ]);
    
        // Fetch the quantity ordered from orders table
        $totalQuantityOrdered = Order::where('lead_id', $report->lead_id)
            ->where('client_id', $report->client_id)
            ->sum('quantity_ordered');
    
        // If quantity_ordered is not provided in the update, use the sum from the orders table
        if (!isset($request['quantity_ordered']) || $request['quantity_ordered'] === null) {
            $request->merge(['quantity_ordered' => $totalQuantityOrdered]);
        }
    
        // Update the report using the validated data
        $report->update($request->all());
    
        Flash::success('Report updated successfully.');
    
        return redirect(route('reports.index'));
    }
    

    /**
     * Remove the specified Report from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $report = $this->reportRepository->find($id);

        if (empty($report)) {
            Flash::error('Report not found');

            return redirect(route('reports.index'));
        }

        $this->reportRepository->delete($id);

        Flash::success('Report deleted successfully.');

        return redirect(route('reports.index'));
    }
    public function syncData()
{
    // Fetch only active leads and clients
    $leads = Lead::where('status', 'active')->get();
    $clients = Client::where('status', 'active')->get();

    // Prepare a list of lead-client pairs that have already been processed
    $processedPairs = [];

    // Loop through each lead
    foreach ($leads as $lead) {
        // Loop through each client, but only if they have a matching lead
        foreach ($clients as $client) {
            // Check if the lead is associated with the client
            if ($lead->client_id == $client->id) {

                // Ensure that the pair has not been processed before
                if (in_array([$lead->id, $client->id], $processedPairs)) {
                    continue; // Skip this combination if it's already been processed
                }

                // Mark this pair as processed to avoid duplicates
                $processedPairs[] = [$lead->id, $client->id];

                // Check if a report already exists for this lead-client pair
                $existingReport = Report::where('lead_id', $lead->id)
                    ->where('client_id', $client->id)
                    ->first();

                // Only create a new report if one doesn't exist yet
                if (!$existingReport) {
                    // Get the total quantity ordered from the orders table
                    $totalQuantityOrdered = Order::where('lead_id', $lead->id)
                        ->where('client_id', $client->id)
                        ->sum('quantity_ordered');

                    // Skip the report creation if the quantity ordered is 0
                    if ($totalQuantityOrdered == 0) {
                        continue; // Skip this lead-client pair
                    }

                    // Get the product associated with the lead (since product is linked to lead_id)
                    $product = Product::where('lead_id', $lead->id)->first(); // Fetch product based on lead_id

                    // Create the report with the quantity ordered and product info
                    Report::create([
                        'lead_id' => $lead->id,
                        'client_id' => $client->id,
                        'lead_date' => $lead->lead_date,
                        'client_date' => $client->client_date,
                        'product_id' => $product ? $product->id : null, // Use the product's ID if found, else null
                        'quantity_ordered' => $totalQuantityOrdered, // Total quantity ordered
                    ]);
                }
            }
        }
    }

    Flash::success('Lead and Client data has been synchronized into reports table with quantities.');
    return redirect(route('reports.index'));
}

}
