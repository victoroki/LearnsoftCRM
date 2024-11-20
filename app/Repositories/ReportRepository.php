<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\BaseRepository;

class ReportRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'employee_id',
        'employee_name',
        'lead_name',
        'client_name',
        'lead_date',
        'client_date',
        'product_id',
        'quantity_ordered',
        'order_date',
        'order_status',
        'interaction_type',
        'start_date',
        'end_date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Report::class;
    }
    public function query()
    {
        return Report::query(); // Return the query builder
    }
}
