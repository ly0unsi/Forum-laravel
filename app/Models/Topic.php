<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  use HasFactory;
  protected $table = 'topics';
  protected $guarded = [];
  protected $primaryKey = 'tid';
  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id');
  }
  public function comments()
  {
    return $this->morphMany('App\Models\Comment', 'commentable')->latest();
  }
}
