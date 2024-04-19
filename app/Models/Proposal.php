<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['id','id_user','id_company','title','document','total_target','status'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function Company()
    {
        return $this->belongsTo(Company::class, 'id_company', 'id');
    }
}
