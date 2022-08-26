<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'address',
        'created_by',
    ];


    //Belongs to Agent User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Relation with Appointments
    public function appointments()
    {
        return $this->hasMany(Appointments::class);
    }
}
