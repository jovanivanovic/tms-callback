<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];
    protected $with = ['user'];

    public function callback()
    {
        return $this->belongsTo(CallBack::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
