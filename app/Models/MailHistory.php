<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailHistory extends Model
{
    use HasFactory;
    protected $table = "mail_history";
    public function User()
    {
        return $this->belongsTo( User::class, 'user_id','id');
    }
}
