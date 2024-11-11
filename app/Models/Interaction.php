<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    public $table = 'interactions';

    public $fillable = [
        'client_id',
        'lead_id',
        'type',
        'description',
        'interactions_date'
    ];

    protected $casts = [
        'type' => 'string',
        'description' => 'string',
        'interactions_date' => 'date'
    ];

    public static array $rules = [
        'client_id' => 'nullable',
        'lead_id' => 'nullable',
        'type' => 'nullable|string|max:30',
        'description' => 'nullable|string|max:65535',
        'interactions_date' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }

    public function lead(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Lead::class, 'lead_id');
    }
    public function getInteractionsDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
