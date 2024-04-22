<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['id','id_proposal','id_user','id_company','is_reject'];
    protected $keyType = 'string';
    public $incrementing = false;
}
