<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'accounts';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'failed_attempts', 
    ];

    // Hidden fields 
    protected $hidden = [
        'password',
        'token',
    ];
}