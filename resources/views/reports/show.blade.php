@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Report Details</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary" href="{{ route('reports.index') }}">
                        Back to Reports
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Lead Name</dt>
                    <dd class="col-sm-9">{{ $report->lead->full_name }}</dd>

                    <dt class="col-sm-3">Client Name</dt>
                    <dd class="col-sm-9">{{ $report->client->full_name }}</dd>

                    <dt class="col-sm-3">Lead Date</dt>
                    <dd class="col-sm-9">{{ $report->lead_date }}</dd>

                    <dt class="col-sm-3">Client Date</dt>
                    <dd class="col-sm-9">{{ $report->client_date }}</dd>

                    <dt class="col-sm-3">Product</dt>
                    <dd class="col-sm-9">{{ $report->product->product_name ?? 'N/A' }}</dd>

                    <dt class="col-sm-3">Quantity Ordered</dt>
                    <dd class="col-sm-9">{{ $report->quantity_ordered }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
