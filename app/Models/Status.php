<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['content'];

    //即, 一个Status, 有个内置的User对象, 表示status一般都有个发帖人
    //相对的, User类里面应该也有一个hasMany的方法吧?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
