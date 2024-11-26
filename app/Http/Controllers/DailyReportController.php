<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\DailyReport;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function create()
    {
        // Pass all employees to the view
        $employees = Employee::all();
        return view('daily_reports.create', compact('employees'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'monday_report' => 'required|string',
            'tuesday_report' => 'required|string',
            'wednesday_report' => 'required|string',
            'thursday_report' => 'required|string',
            'friday_report' => 'required|string',
        ]);

        // Create the daily report
        DailyReport::create([
            'employee_id' => $request->employee_id,
            'monday_report' => $request->monday_report,
            'tuesday_report' => $request->tuesday_report,
            'wednesday_report' => $request->wednesday_report,
            'thursday_report' => $request->thursday_report,
            'friday_report' => $request->friday_report,
        ]);

        return redirect()->route('employees.index')->with('success', 'Report saved successfully.');
    }
}
