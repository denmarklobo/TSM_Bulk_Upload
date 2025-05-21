<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLogin extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'admin_login';

    // Set the fillable attributes (this is for mass assignment protection)
    protected $fillable = ['name', 'email', 'password'];

    // You may want to hide sensitive data (like password) when retrieving the model
    protected $hidden = ['password', 'remember_token'];

    // Optionally, you can define any additional methods here if needed.
}