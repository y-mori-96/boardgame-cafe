<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Boardgame;
use App\Models\RentalItem;

class Rental extends Model
{
    use HasFactory;
    
    protected $fillable = [
      'user_id',
      'rental_item_id',
      'state',
      'start_date',
      'rental_date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function rentalItem(){
        return $this->belongsTo(RentalItem::class);
    }
    
    /**
     * ボードゲーム一覧
     */
    // public function boardgame(){
    //   return $this->belongsTo('App\Models\Boardgame');
    // }
    public function boardgame()
    {
        return $this->rentalItem->boardgame();
    }
}
