@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Generate Employee Reports</h2>

    <form id="report-form" class="form-inline mb-3">
        <div class="form-group mr-3">
            <label for="employee_id" class="mr-2">Employee</label>
            <select id="employee_id" name="employee_id" class="form-control" required>
                <option value="">-- Select Employee --</option>
            </select>
        </div>

        <div class="form-group mr-3">
            <label for="start_date" class="mr-2">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group mr-3">
            <label for="end_date" class="mr-2">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" required>
        </div>

        <button id="generate-report" type="button" class="btn btn-primary">Generate Report</button>
    </form>

    <hr>

    <div id="report-data">
        <p>Please select an employee and date range to generate the report.</p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch employees
        fetch('/api/employees')
            .then(response => response.json())
            .then(employees => {
                const employeeSelect = document.getElementById('employee_id');
                employees.forEach(employee => {
                    const option = document.createElement('option');
                    option.value = employee.id;
                    option.textContent = `${employee.first_name} ${employee.last_name}`;
                    employeeSelect.appendChild(option);
                });
            });

        // Generate report
        document.getElementById('generate-report').addEventListener('click', function () {
            const employeeId = document.getElementById('employee_id').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (!employeeId || !startDate || !endDate) {
                alert('Please fill out all fields.');
                return;
            }

            fetch(`/reports/generate?employee_id=${employeeId}&start_date=${startDate}&end_date=${endDate}`)
                .then(response => response.json())
                .then(data => {
                    const reportData = document.getElementById('report-data');
                    if (data.error) {
                        reportData.innerHTML = `<p>${data.error}</p>`;
                    } else {
                        reportData.innerHTML = data.html;
                    }
                });
        });
    });
</script>
@endsection
