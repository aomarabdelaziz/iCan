<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStore extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'store_id',
        'product_id',
    ];

    public static function addProductToStore(array $validated)
    {
        static::create([
            'store_id' => $validated['store_id'],
            'product_id' => $validated['product_id'],
        ]);
    }
}
