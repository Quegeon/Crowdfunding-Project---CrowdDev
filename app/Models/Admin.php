<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $primaryKey = 'id';
    protected $fillable = ['id','name','username','password','encrypt_view','email'];
    protected $keyType = 'string';
    public $incrementing = false;
}
