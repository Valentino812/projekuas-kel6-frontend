<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Product extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'price',
        'description',
        'type',
        'gender',
        'img1',
        'img2',
        'stock',
    ];

    protected $table = 'products';

}
