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
        'client_id',
        'lead_id', 
    ];

    protected $casts = [
        'unit_price' => 'float',
        'total_price' => 'float',
        'order_date' => 'date',
        'status' => 'string',
    ];

    public static array $rules = [
        'product_id' => 'nullable',
        'quantity_ordered' => 'nullable',
        'unit_price' => 'nullable|numeric',
        'total_price' => 'nullable|numeric',
        'order_date' => 'nullable',
        'status' => 'nullable|string|max:20',
        'client_id' => 'nullable',
        'lead_id' => 'nullable',
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

    public function lead()
    {
    return $this->belongsTo(\App\Models\Lead::class, 'lead_id');
    }

    public function getOrderDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }

    // Automatically calculate total price before saving or updating
    public static function boot()
{
    parent::boot();

    // Set default value for status when creating a new order
    static::creating(function ($order) {
        if (is_null($order->status)) {
            $order->status = 'Pending';
        }
    });

    // Automatically calculate total_price when saving
    static::saving(function ($order) {
        if ($order->quantity_ordered && $order->unit_price) {
            $order->total_price = $order->quantity_ordered * $order->unit_price;
        }
    });
}


    /**
     * Accessor to calculate total_price after creating an instance
     *
     * @param $value
     * @return float
     */
    public function getTotalPriceAttribute($value)
    {
        // Return calculated value if not already set
        if (!$value && $this->quantity_ordered && $this->unit_price) {
            return $this->quantity_ordered * $this->unit_price;
        }

        return $value;
    }

    /**
     * A method to explicitly calculate the total price
     *
     * @return float
     */
    public function calculateTotalPrice()
    {
        return $this->quantity_ordered * $this->unit_price;
    }
}
