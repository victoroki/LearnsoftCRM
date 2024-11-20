<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Repositories\ClientRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LeadRepository;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Carbon\Carbon;
use Flash;

class LeadController extends AppBaseController
{
    /** @var LeadRepository $leadRepository*/
    private $leadRepository;

    private $clientRepository;

    public function __construct(LeadRepository $leadRepo, ClientRepository $clientRepo)
    {
        $this->leadRepository = $leadRepo;
        $this->clientRepository = $clientRepo; // Inject the ClientRepository
    }

    /**
     * Display a listing of the Lead.
     */
    public function index(Request $request)
    {
        // Get search query from the request
        $search = $request->input('search');
        
        // Query leads with employee relationships and apply search if a term is provided
        $leads = Lead::with(['employee', 'product']) // Eager load product and employee
            ->when($search, function ($query) use ($search) {
                $query->where('full_name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone_number', 'like', '%' . $search . '%') // Added phone number search
                      ->orWhere('source', 'like', '%' . $search . '%') // Added source search
                      ->orWhere('status', 'like', '%' . $search . '%') // Added status search
                      ->orWhere('description', 'like', '%' . $search . '%') // Added description search
                      ->orWhereHas('employee', function ($query) use ($search) {
                          // Search employee's first name, last name, and email
                          $query->where('first_name', 'like', '%' . $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                      })
                      ->orWhereHas('product', function ($query) use ($search) {
                          // Search product related fields, if necessary
                          $query->where('product_name', 'like', '%' . $search . '%')
                                ->orWhere('description', 'like', '%' . $search . '%');
                      });
            })
            ->paginate(10);
    
        return view('leads.index', compact('leads'));
    }
    
    
    /**
     * Show the form for creating a new Lead.
     */
    public function create()
    {
        $employees = Employee::all();  // Get all employees
        $products = Product::all();    // Get all products
        return view('leads.create', compact('employees', 'products'));  // Pass employees and products to the view
    }
    

    /**
     * Store a newly created Lead in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'full_name' => 'nullable|string|max:100',
            'email' => 'required|string|max:30|email',
            'phone_number' => 'nullable|numeric',
            'source' => 'nullable|string|max:30',
            'status' => 'nullable|string|max:30',
            'employee_id' => 'nullable|exists:employees,id',
            'description' => 'nullable|string|max:65535',
            'product_id' => 'nullable|exists:products,id', // Ensure valid product selection
            'created_at' => 'nullable|date', // Validate created_at as a date
        ]);
    
        // Create the lead with the validated data
        $lead = Lead::create($validatedData);
    
        // If a product is selected, associate it (if the relationship exists in the Lead model)
        if ($request->has('product_id') && $request->product_id) {
            $lead->product_id = $request->product_id;
        }
    
        // If a created_at date is provided, update the lead's created_at field
        if ($request->has('created_at') && $request->created_at) {
            $lead->created_at = $request->created_at;
        }
    
        // Save the lead (this is actually redundant since create already does this)
        $lead->save();
    
        // Redirect or show success message
        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }

    /**
     * Display the specified Lead.
     */
    public function show($id)
    {
        $lead = $this->leadRepository->find($id);

        if (empty($lead)) {
            Flash::error('Lead not found');
            return redirect(route('leads.index'));
        }

        return view('leads.show')->with('lead', $lead);
    }

    /**
     * Show the form for editing the specified Lead.
     */
    public function edit($id)
    {
        // Find the lead by ID
        $lead = $this->leadRepository->find($id);
    
        if (empty($lead)) {
            Flash::error('Lead not found');
            return redirect(route('leads.index'));
        }
    
        // Get all employees and products
        $employees = Employee::all();  // Fetch all employees
        $products = Product::all();    // Fetch all products
    
        // Return the edit view
        return view('leads.edit')
            ->with('lead', $lead)
            ->with('employees', $employees)
            ->with('products', $products);
    }

    /**
     * Update the specified Lead in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the lead by ID
        $lead = $this->leadRepository->find($id);
    
        if (empty($lead)) {
            Flash::error('Lead not found');
            return redirect(route('leads.index'));
        }
    
        // Validation rules, including `product_id` and `created_at`
        $rules = [
            'full_name' => 'nullable|string|max:100',
            'email' => 'required|string|max:30',
            'phone_number' => 'nullable|string|max:15',
            'source' => 'nullable|string|max:30',
            'status' => 'nullable|string|max:30',
            'employee_id' => 'nullable|exists:employees,id',
            'product_id' => 'nullable|exists:products,id', // Ensure product_id references an existing product
            'description' => 'nullable|string|max:65535',
            'created_at' => 'nullable|date' // Validate created_at as a date
        ];
    
        // Validate the input
        $validated = $request->validate($rules);
    
        // Update the lead, including product_id and created_at
        $lead = $this->leadRepository->update($validated, $id);
    
        Flash::success('Lead updated successfully.');
    
        return redirect(route('leads.index'));
    }
    
    /**
     * Remove the specified Lead from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $lead = $this->leadRepository->find($id);

        if (empty($lead)) {
            Flash::error('Lead not found');
            return redirect(route('leads.index'));
        }

        $this->leadRepository->delete($id);

        Flash::success('Lead deleted successfully.');

        return redirect(route('leads.index'));
    }

    /**
     * Convert lead to client.
     */
    public function convertToClient($leadId)
    {
        $lead = Lead::find($leadId);
    
        if (!$lead) {
            Flash::error('Lead not found');
            return redirect(route('leads.index'));
        }
    
        // Check if this lead is already a client
        $existingClient = Client::where('lead_id', $lead->id)
            ->orWhere('email_address', $lead->email)
            ->orWhere('phone_number', $lead->phone_number)
            ->first();
    
        if ($existingClient) {
            Flash::warning('This lead is already associated with a client.');
            return redirect(route('leads.index'));
        }
    
        // Assuming certain status indicates conversion
        if ($lead->status !== 'converted') {
            $lead->status = 'converted'; // Set status to converted
            $lead->save();
        }
    
        // Split full name into first and last names if needed
        $nameParts = explode(' ', $lead->full_name);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : null;
    
        // Create a client from the lead data
        $client = Client::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email_address' => $lead->email,
            'phone_number' => $lead->phone_number,
            'lead_id' => $lead->id,
            'location' => 'Unknown', // Adjust based on your application's needs
        ]);
    
        Flash::success('Lead successfully converted to client.');
        return redirect(route('leads.index'));
    }
    
    public function getLeadData(Request $request)
    {
        $interval = $request->get('interval', 'days'); // Default to daily

        $query = DB::table('leads')
            ->select(
                DB::raw('COUNT(id) as total_leads'),
                DB::raw("DATE_FORMAT(created_at, CASE WHEN '$interval' = 'days' THEN '%Y-%m-%d' WHEN '$interval' = 'weeks' THEN '%Y-%u' WHEN '$interval' = 'months' THEN '%Y-%m' END) as date_group")
            )
            ->groupBy('date_group')
            ->orderBy('date_group');

        $data = $query->get();

        return response()->json($data);
    }
}

