@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Generate Reports</h2>

    <form id="report-form" class="form-inline mb-3">
    <div class="form-group mr-3">
        <label for="type" class="mr-2">Report Type</label>
        <select id="type" name="type" class="form-control" required>
            <option value="">-- Select Report Type --</option>
            <option value="clients">Clients</option>
            <option value="leads">Leads</option>
            <option value="orders">Orders</option>
            <option value="interactions">Interactions</option>
        </select>
    </div>

    <div class="form-group mr-3">
        <label for="start_date" class="mr-2">Start Date</label>
        <input type="date" id="start_date" name="start_date" class="form-control">
    </div>

    <div class="form-group mr-3">
        <label for="end_date" class="mr-2">End Date</label>
        <input type="date" id="end_date" name="end_date" class="form-control">
    </div>

    <button id="generate-report" class="btn btn-primary">Generate Report</button>
</form>


    <hr>

    <div id="report-data">
        <p>Please select a report type and generate a report.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
   document.getElementById('generate-report').addEventListener('click', function (e) {
    e.preventDefault();

    const type = document.getElementById('type').value;
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    if (!type) {
        alert('Please select a report type.');
        return;
    }

    axios.get('{{ route('reports.generate') }}', {
        params: { type, start_date: startDate, end_date: endDate }
    })
    .then(response => {
        const { data, columns } = response.data;

        // Update the report-data div with the table
        const reportDataDiv = document.getElementById('report-data');
        reportDataDiv.innerHTML = '';

        // Render the table using the data and columns
        axios.post('{{ route('reports.renderTable') }}', { data, columns })
            .then(renderResponse => {
                reportDataDiv.innerHTML = renderResponse.data;
            })
            .catch(renderError => {
                console.error(renderError);
                alert('Error rendering the table.');
            });
    })
    .catch(error => {
        console.error(error.response || error);
        alert('Failed to fetch report data.');
    });
});

</script>
@endsection
