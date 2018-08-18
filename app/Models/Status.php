<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function user()                     #注意函数命名为单数
    {
        return $this->belongsTo(User::class);  #让动态属于用户，一对多，一个用户可以有多条动态
    }
}
