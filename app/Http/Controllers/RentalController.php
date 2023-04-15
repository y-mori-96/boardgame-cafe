<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RentalRequest;

// モデル
use App\Models\User;
use App\Models\RentalItem;
use App\Models\Rental;
use Carbon\Carbon;

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
    public function index(Request $request)
    {
        $user = User::findOrFail(\Auth::id());
        
        // チェックボックスの状態を取得
        $reserve = $request->input('reserve');
        $rental = $request->input('rental');
        $arrears = $request->input('arrears');
        $completion = $request->input('completion');
        
        // 検索条件を作成
        $conditions = [];
        if ($reserve) {
            $conditions[] = ['state', '=', '予約中'];
        }
        if ($rental) {
            $conditions[] = ['state', '=', '貸出中'];
        }
        if ($arrears) {
            $conditions[] = ['state', '=', '延滞'];
        }
        if ($completion) {
            $conditions[] = ['state', '=', '完了'];
        }
        // 検索を実行
        $rentals = $user->rentals()->where($conditions)->get();

        return view('rental.index', [
            'header' => 'レンタル状態',
            'rentals' => $rentals,
        ]);
    }

    /**
     * レンタル状態へ追加
     */
    public function add(RentalRequest $request)
    {
        // カートに同じ商品があるか確認
        // $rentai_item_in_cart = Rental::where('rental_item_id', $request->rental_item_id)->where('user_id', \Auth::id())->first();
        // dd($request);
        // 商品があれば
        // if($rentai_item_in_cart) {
        //     session()->flash('success', 'すでにその商品はレンタル状態');
        // }
        
        /**
         * 要追加
         * 開始日付が今日より前なら受け付けない
         * 終了日付が開始日付より前なら受け付けない
         */

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
