<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'price',
        'string',
        'image'
    ];

    public static function createNewProduct(array $validated , string $image_path)
    {
        $validated['image'] = $image_path;
        static::create(
            [
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'image' => $validated['image'],
            ]);
    }
}
