<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $table = 'reports';

    public $fillable = [
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

    protected $casts = [
        'employee_name' => 'string',
        'lead_name' => 'string',
        'client_name' => 'string',
        'lead_date' => 'date',
        'client_date' => 'date',
        'order_date' => 'date',
        'order_status' => 'string',
        'interaction_type' => 'string',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public static array $rules = [
        'employee_id' => 'required',
        'employee_name' => 'required|string|max:255',
        'lead_name' => 'nullable|string|max:255',
        'client_name' => 'nullable|string|max:255',
        'lead_date' => 'nullable',
        'client_date' => 'nullable',
        'product_id' => 'nullable',
        'quantity_ordered' => 'nullable',
        'order_date' => 'nullable',
        'order_status' => 'nullable|string|max:50',
        'interaction_type' => 'required|string|max:250',
        'start_date' => 'required',
        'end_date' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required'
    ];

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }
}
