<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cart extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'userId',
        'items',
        'total',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $table = 'carts';
}
