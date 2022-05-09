<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
    ];

    public static function updateCenterStatus (array $validated)
    {
        $status = $validated['status'] == 1 ? 'accepted' : 'rejected';

        static::firstWhere(['id' => $validated['center_id']])->update(['status' => $status]);

        return $status;
    }

    public static function addNewCenter (array $validated)
    {
        static::create(
            [
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
    }



}