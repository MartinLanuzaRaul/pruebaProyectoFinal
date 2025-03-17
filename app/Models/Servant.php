<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'rarity',
        'className',
        'noblePhantasmCard',
        'servantId',
        'attribute',
        'gender',
        'img' ,
        'atkBase' ,
        'hpBase' ,
        'noblePhantasmEffect'
    ];
}
