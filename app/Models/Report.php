<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $table = 'reports';

    public $fillable = [
        'lead_id',   // Reference to the lead
        'client_id', // Reference to the client
        'lead_date',
        'client_date',
        'product_id',
        'quantity_ordered',
    ];

    protected $casts = [
        'lead_date' => 'date',
        'client_date' => 'date',
    ];

    public static array $rules = [
        'lead_id' => 'nullable|exists:leads,id',  // Ensuring that the lead exists
        'client_id' => 'nullable|exists:clients,id', // Ensuring that the client exists
        'lead_date' => 'nullable|date',
        'client_date' => 'nullable|date',
        'product_id' => 'nullable|exists:products,id',
        'quantity_ordered' => 'nullable|integer',
        'created_at' => 'required',
        'updated_at' => 'required',
    ];

    public function lead()
    {
        return $this->belongsTo(\App\Models\Lead::class, 'lead_id');
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
    public function getLeadDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('m-d-Y');
    }
    public function getClientDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('m-d-Y');
    }
}
