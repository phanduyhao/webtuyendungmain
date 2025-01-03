<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmminMoney extends Model
{
    use HasFactory;
    protected $table = "admin_money";
    public function User()
    {
        return $this->belongsTo( User::class, 'user_id','id');
    }
}
