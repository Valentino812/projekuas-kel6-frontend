<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reviev extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'img1',
        'img2',
        'comment',
    ];

    protected $table = 'reviews';
}
