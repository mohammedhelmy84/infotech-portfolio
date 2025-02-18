<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $table = 'contactus';
    protected $fillable = [
        'firstname',
        'lastname',
        'mobile',
        'address',
        'email',
        'title',
        'option',
        'message',
    ];

}
