<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public $table = 'leads';

    public $fillable = [
        'full_name',
        'email',
        'phone_number',
        'source',
        'status',
        'employee_id',
        'notes'
    ];

    protected $casts = [
        'full_name' => 'string',
        'email' => 'string',
        'source' => 'string',
        'status' => 'string',
        'notes' => 'string'
    ];

    public static array $rules = [
        'full_name' => 'nullable|string|max:100',
        'email' => 'required|string|max:30',
        'phone_number' => 'nullable',
        'source' => 'nullable|string|max:30',
        'status' => 'nullable|string|max:30',
        'employee_id' => 'nullable',
        'notes' => 'nullable|string|max:65535',
        'created_at' => 'nullable'
    ];

    public function employee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }

    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Client::class, 'lead_id');
    }

    public function interactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Interaction::class, 'lead_id');
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Product::class, 'lead_id');
    }
}
