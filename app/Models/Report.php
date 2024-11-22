<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $table = 'reports';

    public $fillable = [
        'lead_id',       // Foreign key to the lead table
        'client_id',     // Foreign key to the client table
        'lead_date',
        'client_date',
        'product_id',
        'quantity_ordered',
    ];

    protected $casts = [
        'lead_date' => 'date',
        'client_date' => 'date',
    ];

    // Validation rules
    public static array $rules = [
        'lead_id' => 'nullable|exists:leads,id',   // Ensuring that the lead exists
        'client_id' => 'nullable|exists:clients,id', // Ensuring that the client exists
        'lead_date' => 'nullable|date',
        'client_date' => 'nullable|date',
        'product_id' => 'nullable|exists:products,id',
        'quantity_ordered' => 'nullable|integer|min:1', // Ensure positive integers
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
    ];

    // Relationships
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Accessors
    public function getLeadDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('m-d-Y');
    }

    public function getClientDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('m-d-Y');
    }

    public function getQuantityOrderedAttribute($value)
    {
        return number_format($value); // Optional: Format quantity with commas (e.g., 1,000)
    }
}
