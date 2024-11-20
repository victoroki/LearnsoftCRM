<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use App\Models\Employee;
use Illuminate\Http\Request;

class reportController extends Controller
{
    public function index()
    {
        return view('reports.report'); // Ensure this view exists
    }
    
    public function generateReport(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $employeeId = $request->input('employee_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Fetch interactions for the employee within the date range
        $interactions = Interaction::where('employee_id', $employeeId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('client', 'lead') // Load related data
            ->get();

        $employee = Employee::find($employeeId);

        $html = view('reports.table', [
            'interactions' => $interactions,
            'employee' => $employee,
        ])->render();

        return response()->json(['html' => $html]);
    }
}
