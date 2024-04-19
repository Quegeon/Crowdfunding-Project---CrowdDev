<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'id';
    protected $fillable = ['id','name','username','password','encrypt_view','email','payment_credential'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function User()
    {
        return $this->hasMany(User::class, 'id_user', 'id');
    }
}
