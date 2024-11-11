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
    /** @var OrderRepository $orderRepository*/
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
        // Eager load product and client relationships directly
        $orders = Order::with(['product', 'client'])->paginate(10);
        
        return view('orders.index')->with('orders', $orders);
    }
    
    
    

    /**
     * Show the form for creating a new Order.
     */
    public function create()
    {
        // Fetch all products and clients from the database
        $products = \App\Models\Product::pluck('product_name', 'id')->toArray();
        $clients = \App\Models\Client::pluck('first_name', 'id')->toArray();
    
        // Pass the products and clients data to the view
        return view('orders.create', compact('products', 'clients'));
    }
    

    /**
     * Store a newly created Order in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->all();

        $order = $this->orderRepository->create($input);

        Flash::success('Order saved successfully.');

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
     * Show the form for editing the specified Order.
     */
    public function edit($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        return view('orders.edit')->with('order', $order);
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

        $order = $this->orderRepository->update($request->all(), $id);

        Flash::success('Order updated successfully.');

        return redirect(route('orders.index'));
    }

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
