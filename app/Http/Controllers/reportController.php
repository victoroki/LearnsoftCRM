<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Interaction;

use Illuminate\Http\Request;

class reportController extends Controller
{
    public function index(){
        return view('reports.report');
    }


    public function generateReport(Request $request)
{
    $request->validate([
        'type' => 'required|in:orders,clients,leads,interactions',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ]);

    $columns = [
        'orders' => ['id', 'product_name', 'quantity_ordered', 'total_price', 'status', 'order_date', 'client_name', 'lead_name'],
        'clients' => ['id', 'full_name', 'email_address', 'phone_number', 'created_at'],
        'leads' => ['id', 'full_name', 'email', 'phone_number', 'status', 'created_at'],
        'interactions' => ['id', 'client_name', 'lead_name', 'description', 'created_at'],
    ];

    $type = $request->input('type');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = null;

    switch ($type) {
        case 'orders':
            $query = Order::with(['product:id,name', 'client:id,full_name', 'lead:id,full_name']);
            break;
        case 'clients':
            $query = Client::select($columns['clients']);
            break;
        case 'leads':
            $query = Lead::select($columns['leads']);
            break;
        case 'interactions':
            $query = Interaction::with(['client:id,full_name', 'lead:id,full_name']);
            break;
        default:
            return response()->json(['error' => 'Invalid report type'], 400);
    }

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->whereDate('created_at', $startDate);
    }

    $data = $query->get()->map(function ($item) use ($type) {
        if ($type === 'orders') {
            return [
                'id' => $item->id,
                'product_name' => $item->product->name ?? 'N/A',
                'quantity_ordered' => $item->quantity_ordered,
                'total_price' => $item->total_price,
                'status' => $item->status,
                'order_date' => $item->order_date,
                'client_name' => $item->client->full_name ?? 'N/A',
                'lead_name' => $item->lead->full_name ?? 'N/A',
            ];
        } elseif ($type === 'interactions') {
            return [
                'id' => $item->id,
                'client_name' => $item->client->full_name ?? 'N/A',
                'lead_name' => $item->lead->full_name ?? 'N/A',
                'description' => $item->description,
                'created_at' => $item->created_at,
            ];
        }
        return $item;
    });

    return response()->json([
        'data' => $data,
        'columns' => $columns[$type],
    ]);
}



    
    public function renderTable(Request $request)
    {
        try {
            logger('RenderTable Request:', $request->all());
    
            $data = collect($request->input('data', []));
            $columns = $request->input('columns', []);
            logger('RenderTable Data:', $data->toArray());
            logger('RenderTable Columns:', $columns);
            if ($data->isEmpty() || empty($columns)) {
                return response()->json(['error' => 'No data or columns provided'], 400);
            }
    
            return view('reports.table', compact('data', 'columns'))->render();
        } catch (\Exception $e) {
            logger('RenderTable Exception:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while rendering the table.'], 500);
        }
    }
    

}
