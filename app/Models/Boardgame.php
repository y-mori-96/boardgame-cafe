<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boardgame extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'barcode', 'image', 'outline'];
    
    public function exhibitions(){
      return $this->hasMany('App\Models\Exhibition');
    }
    
    public function rentalItems(){
      return $this->hasMany('App\Models\RentalItem');
    }
    
    /**
     * ローカルスコープ
     */
    // 検索
    public function scopeSearch($query, $search)
    {
      if($search !== null ){
        // 全角スペースを半角にする
        $search_change_white_space = mb_convert_kana($search, 's');
        // 空白で区切る
        $search_delimit_white_space = preg_split('/[\s]+/', $search_change_white_space);
        
        foreach($search_delimit_white_space as $value){
          $query->where('name', 'like', '%' .$value. '%');
        }
      }
      
      return $query;
    }
}
