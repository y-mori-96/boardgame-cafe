<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Boardgame;
use App\Models\Rental;

class RentalItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
      'boardgame_id',
      'state',
      'stock_quantity',
    ];
    
    // 購入したユーザ
    public function users(){
      return $this->belongsToMany(User::class, 'rentals')->withPivot(['id', 'state','start_date', 'rental_date']);
    }
    
    /**
     * ボードゲーム一覧
     */
    public function boardgame()
    {
      return $this->belongsTo(Boardgame::class);
    }

    public function rentals()
    {
      return $this->hasMany(Rental::class);
    }
}
