<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Review extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'productId',
        'userId',
        'comment'
    ];

    protected $table = 'reviews';
}
