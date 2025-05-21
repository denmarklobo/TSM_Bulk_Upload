<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;

    // Specify the table name (optional if the table name is the plural form of the model)
    protected $table = 'admin_logs';

    // Define the fillable fields
    protected $fillable = [
        'user_id',
        'job_number',
        'submitted_by',
        'name',
        'email',
        'action',
        'file_path',
        'processed_at',
    ];
}
