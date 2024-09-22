<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        'name',
        'last_name',
        'middle_name',
        'phone',
        'email',
        'password',
        'role',
        'office_id',
        'avatar',
        'company_id',
    ];

    public function getfioAttribute()
    {
        return $this->last_name.' '.$this->name.' '.$this->middle_name;
    }
}
