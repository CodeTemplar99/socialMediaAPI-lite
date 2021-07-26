<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

     protected $fillable = [
        'title',
        'tag',
        'body',
    ];

    public function User(){
        return $this->belongsTo('App\User');
    }
}
