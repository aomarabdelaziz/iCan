<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'phone',
        'category',
        'category_id',
    ];

    public static function addNewPhoneNumber(array $validated)
    {
        static::create(
            [
                'phone' => $validated['phone'],
                'category_id' => $validated['category_id'],
                'category' => $validated['category'],
            ]);
    }
}
