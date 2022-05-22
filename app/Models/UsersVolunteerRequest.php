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
        'user_id',
        'volunteer_type',
        'user_name',
        'user_phone',
        'from',
        'to',
        'date',
        'status',

    ];

    public static function createRequest(array $validated)
    {
        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        static::create(
            [
                'user_id' => Auth::id(),
                'volunteer_type' => $validated['volunteer_type'],
                'user_name' =>$userName,
                'user_phone' =>Auth::user()->phone,
                'from' =>  $validated['from'] ?? '',
                'to' =>  $validated['to'] ?? '',
                'date' =>  $validated['date'] ,


            ]);
    }
}
