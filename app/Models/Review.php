<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = ['boardgame_id', 'user_id', 'title',  'body', 'score'];
    
    // 投稿したユーザ
    public function user(){
      return $this->belongsTo('App\Models\User');
    }
}
