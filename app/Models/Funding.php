<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funding extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['id','id_user','id_proposal','fund'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function Proposal()
    {
        return $this->belongsTo(Proposal::class, 'id_proposal', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
