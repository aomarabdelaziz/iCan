<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Evaluation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'center_id',
        'rate',

    ];

    public static function evaluateCenter(array $validated)
    {
        static::create(
            [
                'user_id' => Auth::id(),
                'center_id' => $validated['center_id'],
                'rate' => $validated['rate'],
            ]);

    }



}
