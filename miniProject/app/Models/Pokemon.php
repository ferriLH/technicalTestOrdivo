<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Pokemon extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pokemons';
    protected $fillable = [
        'page',
        'name',
        'url',
        'createdAt',
        'expireAt'
    ];

    protected $dates = ['createdAt', 'expireAt'];
}
