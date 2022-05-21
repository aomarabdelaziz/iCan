<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CenterBooking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'center_id',
        'case_name',
        'phone',

    ];

    protected $casts = [
        'booking_date' => 'date'
    ];

    public static function assignNewBooking(array $validated)
    {
        static::create(
            [
                'user_id' => Auth::id(),
                'center_id' => $validated['center_id'],
                'case_name' => $validated['case_name'],
                'phone' => $validated['phone'],
                'booking_date' => $validated['booking_date'],
            ]);
    }

}
