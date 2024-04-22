<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['id','id_proposal','id_company','is_rejected'];
    protected $keyType = 'string';
    public $incrementing = false;
}
