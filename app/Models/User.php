<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Follow;
use App\Models\Exhibition;
use App\Models\Cart;
use App\Models\Order;
use App\Models\RentalItem;
use App\Models\Rental;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * リレーションを設定
     */

    // ユーザの投稿
    public function posts(){
        return $this->hasMany('App\Models\Post');
    }
    
    // フォロー
    public function follows(){
        return $this->hasMany('App\Models\Follow');
    }
 
    // フォローしているユーザを取得
    public function follow_users(){
      return $this->belongsToMany('App\Models\User', 'follows', 'user_id', 'follow_id');
    }
 
    // フォロワー
    public function followers(){
      return $this->belongsToMany('App\Models\User', 'follows', 'follow_id', 'user_id');
    }
    
    // 該当のユーザーが特定のユーザーをフォローしているかどうか
    public function isFollowing($user){
      $result = $this->follow_users->pluck('id')->contains($user->id);
      return $result;
    }
    
    // おすすめのユーザーを選択するロジック
    public function scopeRecommend($query, $self_id){
        // 最新順
        // return $query->where('id', '!=', $self_id)->latest()->limit(3);
        
        // ランダム
        return $query->where('id', '!=', $self_id)->orderByRaw('RAND()')->limit(3);
    }
    
    /**
     * EC
     */
    // 商品
    public function Exhibitions(){
      return $this->belongsToMany(Exhibition::class, 'carts')->withPivot(['id', 'quantity']);
    }
    
    // 注文者
    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    // 注文商品
    public function orderItems(){
        return $this->belongsToMany('App\Models\Exhibition', 'orders');
    }
    
    // カート
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    
    /**
     * レンタル
     */
     
    public function rentalItems(){
      return $this->belongsToMany(RentalItem::class, 'rentals')->withPivot(['id', 'state', 'start_date', 'rental_date']);
    }
    
    // 注文状態
    public function rentals(){
        return $this->hasMany(Rental::class);
    }
}
