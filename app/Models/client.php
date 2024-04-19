<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class client extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'clients';
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'phone_number',
    ];
}
