<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Company extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $primaryKey = 'id';
    protected $fillable = ['id','username','password','encrypt_view','company_name','work_field','country','company_email','company_description','name','position','personal_email'];
    protected $keyType = 'string';
    public $incrementing = false;

}
