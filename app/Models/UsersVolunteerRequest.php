<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UsersVolunteerRequest extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'volunteer_id',
        'user_id',
        'status',

    ];

    public static function createRequest(array $validated)
    {
        static::create(
            [
                'volunteer_id' => $validated['volunteer_id'],
                'user_id' => Auth::id(),

            ]);
    }
}
