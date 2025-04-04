<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    use HasFactory;

    protected $fillable = [
        'idUser' ,
        'currentStreak',
        'totalTries',
        'min_tries_servant',
    ];
}
