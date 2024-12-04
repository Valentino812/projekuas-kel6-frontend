<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Transaction extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'userId',
        'items',
        'total',
        'status',
        'datetime',
    ];

    protected $table = 'transactions';
}
