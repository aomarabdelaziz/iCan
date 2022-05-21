<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Store extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'email',
        'status',
        'image',
        'phone_number'
    ];

    public function image() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset(Storage::url($value)),
        );
    }


    public static function updateStoreStatus (array $validated)
    {
        $status = $validated['status'] == 1 ? 'accepted' : 'rejected';

        static::firstWhere(['id' => $validated['store_id']])->update(['status' => $status]);

        return $status;
    }

    public static function createStore(array $validated , string $store_path)
    {
        static::create(
            [
                'name' => $validated['name'],
                'user_id' => Auth::id(),
                'address' => $validated['address'],
                'phone_number' => $validated['phone_number'],
                'email' => Auth::user()->email,
                'image' => $store_path,
            ]);
    }

}
