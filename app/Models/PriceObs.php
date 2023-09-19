<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceObs extends Model
{
    use HasFactory;

    protected $table = 'objects';

    protected $fillable = [
        'id',
        'description',
        'url',
        'reference',
        'reference_id',
        'price',
        'old_price',
        'mail'
    ];

}
