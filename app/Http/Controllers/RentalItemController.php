<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RentalItem;

use Carbon\Carbon;

class RentalItemController extends Controller
{
    /**
     * アクセス制限（ログイン時のみ）
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * 商品の存在判定
     */
    private function isExistence($rental){
        if($rental === null){
            // session()->flash('success','その商品は存在しません');
            return true;
        }
    }
    
    /**
     * 商品一覧
     */
    public function index()
    {
        $rental_items = RentalItem::all();
        
        return view('rental-items.index', [
            'header' => 'レンタル一覧',
            'rental_items' => $rental_items,
        ]);
    }

    /**
     * 詳細
     */
    public function show(string $id)
    {
        $rental_item = RentalItem::findOrFail($id);

        return view('rental-items.show', [
            'header' => 'レンタル詳細',
            'rental_item' => $rental_item,
        ]);
    }
}
