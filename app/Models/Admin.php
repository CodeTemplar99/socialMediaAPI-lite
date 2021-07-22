<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    protected $table = 'admins';

    // protected $guard = 'admin';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
        'active',
        'activation_token',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
