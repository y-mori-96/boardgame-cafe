<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Boardgame;
use App\Models\Oder;

class Exhibition extends Model
{
    use HasFactory;
    
    protected $fillable = [
      'boardgame_id',
      'description',
      'price',
      'image1',
      'image2',
      'image3', 
      'image4'
    ];
    
    // 購入したユーザ
    public function users(){
      return $this->belongsToMany(User::class, 'carts')->withPivot(['id', 'quantity']);
    }
    
    /**
     * ボードゲーム一覧
     */
    public function boardgame(){
      return $this->belongsTo('App\Models\Boardgame');
    }
    
    /**
     * EC
     */
    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
    
    public function isSold(){
      return $this->orders->count() > 0;
    }
}
