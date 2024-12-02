<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;
    protected $table = 'notifies';
    public function Application()
    {
        return $this->belongsTo( Application::class, 'application_id','id');
    }
    public function User()
    {
        return $this->belongsTo( User::class, 'user_id','id');
    }
}
