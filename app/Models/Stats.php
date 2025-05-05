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
        'min_tries_count',
        'total_guesses',
        'numeroIntentosIlimitado',
        'Unlimited_total_guesses'
    ];
}
