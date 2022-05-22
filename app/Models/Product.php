<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'store_id',
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
                'store_id' => $validated['store_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'image' => $validated['image'],
            ]);
    }

    public function image() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset(Storage::url($value)),
        );
    }

}
