<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public function Users()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class,'admin_id','id');
    }
}
