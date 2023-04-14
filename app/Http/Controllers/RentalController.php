<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// モデル
use App\Models\User;
use App\Models\RentalItem;
use App\Models\Rental;

class RentalController extends Controller
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
     *  レンタル状態一覧
     */
    public function index()
    {
        $user = User::findOrFail(\Auth::id());
        // $rentals = $user->rentalItems;
        $rentals = $user->rentals;
        // dd($rentals->id);
        
        // foreach($rentals as $rental){
        //     // $rental->id;
        //     dd($rental->boardgame);
        // }
        // $rentals = Rental::all();
        
        return view('rental.index', [
            'header' => 'レンタル状態',
            'rentals' => $rentals,
        ]);
    }

    /**
     * レンタル状態へ追加
     */
    public function add(Request $request)
    {
        // カートに同じ商品があるか確認
        // $rentai_item_in_cart = Rental::where('rental_item_id', $request->rental_item_id)->where('user_id', \Auth::id())->first();
        // dd($request);
        // 商品があれば
        // if($rentai_item_in_cart) {
        //     session()->flash('success', 'すでにその商品はレンタル状態');
        // }
        
        
        // ストック数を減らす
        $rental_item = RentalItem::findOrFail($request->rental_item_id);
        $rental_item->stock_quantity -= 1;
        if($rental_item->stock_quantity === 0 ){
            $rental_item->state = 0;
            // dd($rental_item->state);
        }
        // dd($rental_item->stock_quantity);
        $rental_item->save();
        
        Rental::create([
            'user_id'=> \Auth::id(),
            'rental_item_id' => $request->rental_item_id,
            'state' => '予約中',
            'start_date' => $request->start_date,
            'rental_date' => $request->rental_date,
        ]);
            
        return redirect()->route('rental.index');
    }
    
    
    /**
     * 削除
     */
    public function destroy(string $id)
    {
        $rental = Rental::findOrFail($id);
        
        // ストック数を増やす
        // dd($rental->rental_item_id->stock_quantity);
        $rental_item = $rental->rentalItem;
        $rental_item->stock_quantity += 1;
        if($rental_item->stock_quantity > 0 ){
            $rental_item->state = 1;
            // dd($rental_item->state);
        }
        
        
        // dd($rental, $rental_item, $rental_item->state);
        $rental_item->save();
        $rental->delete();

        \Session::flash('success', '予約を取り消しました');
        return redirect()->route('rental.index');
    }
}
