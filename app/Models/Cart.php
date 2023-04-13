<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Exhibition;

class Cart extends Model
{
    use HasFactory;
    
     protected $fillable = [
      'user_id',
      'exhibition_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }
}
