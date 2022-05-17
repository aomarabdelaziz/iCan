<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Center extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'status',
        'rating',
        'about',
        'image',
    ];

    public function image() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset(Storage::url($value)),
        );
    }


    public static function updateCenterStatus (array $validated)
    {
        $status = $validated['status'] == 1 ? 'accepted' : 'rejected';

        static::firstWhere(['id' => $validated['center_id']])->update(['status' => $status]);

        return $status;
    }

    public static function addNewCenter (array $validated , string $center_path)
    {
        static::create(
            [
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'about' => $validated['about'],
                'image' => $center_path,
            ]);
    }



}
