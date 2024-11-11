<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    public $fillable = [
        'product_id',
        'quantity_ordered',
        'unit_price',
        'total_price',
        'order_date',
        'status',
        'client_id'
    ];

    protected $casts = [
        'unit_price' => 'float',
        'total_price' => 'float',
        'order_date' => 'date',
        'status' => 'string'
    ];

    public static array $rules = [
        'product_id' => 'nullable',
        'quantity_ordered' => 'nullable',
        'unit_price' => 'nullable|numeric',
        'total_price' => 'nullable|numeric',
        'order_date' => 'nullable',
        'status' => 'nullable|string|max:20',
        'client_id' => 'nullable'
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Transaction::class, 'order_id');
    }
}
