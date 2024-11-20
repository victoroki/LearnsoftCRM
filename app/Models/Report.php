<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $table = 'reports';

    public $fillable = [
        'lead_name',
        'client_name',
        'lead_date',
        'client_date',
        'product_id',
        'quantity_ordered',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'lead_name' => 'string',
        'client_name' => 'string',
        'lead_date' => 'date',
        'client_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public static array $rules = [
        'lead_name' => 'nullable|string|max:255',
        'client_name' => 'nullable|string|max:255',
        'lead_date' => 'nullable',
        'client_date' => 'nullable',
        'product_id' => 'nullable',
        'quantity_ordered' => 'nullable',
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
