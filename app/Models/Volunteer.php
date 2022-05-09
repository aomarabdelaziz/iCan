<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'volunteer_id',
        'request_id',
        'start_date',
        'end_date',
        'comment',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class );
    }

    public function getVolunteerIdAttribute($value)
    {
        $data = User::firstWhere('id' , $value);
        $fullName = ucfirst($data->first_name) . ' ' . ucfirst($data->last_name);
        return $fullName;

    }

}
