<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OrderRepository;
use App\Models\Order;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;

class OrderController extends AppBaseController
{
    /** @var OrderRepository $orderRepository */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the Order.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $orders = Order::with(['product', 'client', 'lead']) // Eager load product, client, and lead
                        ->when($search, function ($query) use ($search) {
                            $query->where(function ($query) use ($search) {
                                $query->whereHas('product', function ($query) use ($search) {
                                    $query->where('product_name', 'like', '%' . $search . '%'); // Search by product name
                                })
                                ->orWhere('status', 'like', '%' . $search . '%') // Search by order status
                                ->orWhereHas('client', function ($query) use ($search) {
                                    // Search by first name or last name of the client
                                    $query->where('first_name', 'like', '%' . $search . '%')
                                          ->orWhere('last_name', 'like', '%' . $search . '%');
                                })
                                ->orWhereDate('order_date', 'like', '%' . $search . '%'); // Search by order date
                            });
                        })
                        ->paginate(10);
        
        return view('orders.index')->with('orders', $orders);
    }
    
    

    /**
     * Show the form for creating a new Order.
     */
    public function create()
    {
        $products = \App\Models\Product::pluck('product_name', 'id')->toArray();
        $clients = \App\Models\Client::pluck('full_name', 'id')->toArray();
        $leads = \App\Models\Lead::pluck('full_name', 'id')->toArray(); // Fetch all leads

        return view('orders.create', compact('products', 'clients', 'leads'));
    }

    /**
     * Store a newly created Order in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->all();
    
        // Handle Lead or Client order creation
        if ($request->has('lead_id') && $request->lead_id) {
            $lead = \App\Models\Lead::find($request->lead_id);
    
            if ($lead) {
                // Promote Lead to Client
                $client = new \App\Models\Client();
                $client->full_name = $lead->full_name;
                $client->email_address = $lead->email;
                $client->phone_number = $lead->phone_number;
                $client->employee = $lead->employee;
    
                $client->save();
    
                // Optionally mark the lead as converted or delete it
                $lead->status = 'Converted to a client';
                $lead->save();
    
                $input['client_id'] = $client->id;
                $input['type'] = 'Client'; // Mark order type as 'Client'
            }
        } elseif ($request->has('client_id') && $request->client_id) {
            $input['client_id'] = $request->client_id;
            $input['type'] = 'Client'; // Mark order type as 'Client'
        }
    
        // Create the order
        $order = $this->orderRepository->create($input);
    
        // Log the interaction for leads
        if ($request->has('lead_id') && $request->lead_id) {
            \App\Models\Interaction::create([
                'lead_id' => $request->lead_id,
                'description' => $lead->full_name . ' made an order for ' . $order->product->product_name,
                'interaction_date' => now(),
            ]);
        }
    
        Flash::success('Order created successfully.');
    
        return redirect(route('orders.index'));
    }
    

    /**
     * Show the form for editing the specified Order.
     */
    public function edit($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');
            return redirect(route('orders.index'));
        }

        $products = \App\Models\Product::pluck('product_name', 'id')->toArray();
        $clients = \App\Models\Client::pluck('full_name', 'id')->toArray();
        $leads = \App\Models\Lead::pluck('full_name', 'id')->toArray(); // Fetch all leads

        return view('orders.edit', compact('order', 'products', 'clients', 'leads'));
    }

    /**
     * Update the specified Order in storage.
     */
    public function update($id, UpdateOrderRequest $request)
{
    $order = $this->orderRepository->find($id);

    if (empty($order)) {
        Flash::error('Order not found');
        return redirect(route('orders.index'));
    }

    $input = $request->all();

    // Handle Lead or Client order update
    if ($request->has('lead_id') && $request->lead_id) {
        $lead = \App\Models\Lead::find($request->lead_id);

        if ($lead) {
            // Promote Lead to Client
            $client = new \App\Models\Client();
            $client->full_name = $lead->full_name;
            $client->email_address = $lead->email_address;
            $client->save();

            // Optionally mark the lead as converted or delete it
            $lead->status = 'Converted to a client';
            $lead->save();

            $input['client_id'] = $client->id;
            $input['type'] = 'Client'; // Mark order type as 'Client'
        }
    } elseif ($request->has('client_id') && $request->client_id) {
        $input['client_id'] = $request->client_id;
        $input['type'] = 'Client'; // Mark order type as 'Client'
    }

    // Update the order
    $order = $this->orderRepository->update($input, $id);

    // Log the interaction for leads
    if ($request->has('lead_id') && $request->lead_id) {
        \App\Models\Interaction::create([
            'lead_id' => $request->lead_id,
            'description' => 'Lead ' . $lead->full_name . ' updated an order for product ' . $order->product->product_name,
            'interaction_date' => now(),
        ]);
    }

    Flash::success('Order updated successfully.');

    return redirect(route('orders.index'));
}

    /**
     * Display the specified Order.
     */
    public function show($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');
            return redirect(route('orders.index'));
        }

        return view('orders.show')->with('order', $order);
    }

    /**
     * Get order data based on a specified interval.
     */
    public function getOrderData(Request $request)
    {
        $interval = $request->get('interval', 'days'); // Default to daily

        $query = DB::table('orders')
            ->select(
                DB::raw('SUM(quantity_ordered) as total_quantity'),
                DB::raw("DATE_FORMAT(order_date, CASE WHEN '$interval' = 'days' THEN '%Y-%m-%d' WHEN '$interval' = 'weeks' THEN '%Y-%u' WHEN '$interval' = 'months' THEN '%Y-%m' END) as date_group")
            )
            ->groupBy('date_group')
            ->orderBy('date_group');

        $data = $query->get();

        return response()->json($data);
    }

    /**
     * Remove the specified Order from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');
            return redirect(route('orders.index'));
        }

        $this->orderRepository->delete($id);

        Flash::success('Order deleted successfully.');

        return redirect(route('orders.index'));
    }
}
