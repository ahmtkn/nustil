<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{

    protected $fillable = [
        'name',
        'unit',
        'parent_id',
    ];

    protected $table = "nutritions";


    protected static function convert($from, $to, $value, $decimals = 1)
    {
        $multiplier = config('nustil.unit_conversions.'.$from.'.'.$to);

        return number_format(floatval($value) * $multiplier, $decimals);
    }

}
