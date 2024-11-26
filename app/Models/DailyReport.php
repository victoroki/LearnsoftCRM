<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's naming convention)
    protected $table = 'daily_reports';

    // Specify the primary key (optional if it's the default 'id')
    protected $primaryKey = 'id';

    // Define which fields are mass assignable
    protected $fillable = [
        'employee_id', 
        'monday_report', 
        'tuesday_report', 
        'wednesday_report', 
        'thursday_report', 
        'friday_report',
    ];

    // Define the relationship with the Employee model
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

