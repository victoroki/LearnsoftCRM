<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\DailyReport;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function create($employeeId, $dayIndex = 0)
    {
        // Pass all employees to the view
        $employees = Employee::all();
        $employee = Employee::findOrFail($employeeId);
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $currentDay = $days[$dayIndex] ?? 'monday'; // Default to Monday if dayIndex is not provided
    
        return view('daily_reports.create', compact('employee', 'employees', 'dayIndex', 'currentDay'));
    }
    
    

    public function store(Request $request)
{
    // Validate the request based on the day
    $request->validate([
        'employee_id' => 'required|exists:employees,id', // Ensure the employee exists
        'monday_report' => 'nullable|string',
        'tuesday_report' => 'nullable|string',
        'wednesday_report' => 'nullable|string',
        'thursday_report' => 'nullable|string',
        'friday_report' => 'nullable|string',
    ]);

    // Create the daily report
    DailyReport::create([
        'employee_id' => $request->employee_id, // Save the employee_id
        'monday_report' => $request->monday_report,
        'tuesday_report' => $request->tuesday_report,
        'wednesday_report' => $request->wednesday_report,
        'thursday_report' => $request->thursday_report,
        'friday_report' => $request->friday_report,
    ]);

    // Redirect to the employee index after saving the report
    return redirect()->route('employees.index')->with('success', 'Report saved successfully.');
}

public function viewReport($employeeId, $dayIndex)
{
    // Retrieve the employee and the daily report for the specified day
    $employee = Employee::findOrFail($employeeId);
    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    $currentDay = $days[$dayIndex];
    
    // Get the report for the specific employee and day
    $report = DailyReport::where('employee_id', $employeeId)
                         ->first();  // You can adjust this to retrieve reports from any day

    // Pass the data to the view
    return view('daily_reports.view', compact('employee', 'report', 'currentDay'));
}


}
