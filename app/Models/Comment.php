<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'cid';

    public function commentable()
    {
        return $this->morphTo();
    }
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable')->latest();
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
