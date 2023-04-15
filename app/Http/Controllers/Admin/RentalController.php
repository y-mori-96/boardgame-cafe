<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// モデル
use App\Models\Rental;
use Carbon\Carbon;

class RentalController extends Controller
{
    /**
     * アクセス制限
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     *  レンタル状態一覧
     */
    public function index(Request $request)
    {
        $rental_states = Rental::all();
        foreach($rental_states as $rental){
            if($rental->rental_date < today()){
                if(   ($rental->state === '貸出中')
                    ||($rental->state === '延滞')
                ){
                    $rental->state = '延滞';
                    $rental->save();
                }elseif($rental->state === '予約中'){
                    return redirect()->route('admin.rentals.destroy');
                }elseif($rental->state === '完了'){
                    // 処理なし
                }
            }
        }
        
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
        $rentals = Rental::where($conditions)->get();
        
        return view('admin.rentals.index', [
            'header' => 'レンタル状態',
            'rentals' => $rentals,
        ]);
    }
    
    /**
     * 貸出処理
     */
    public function permission(string $id)
    {
        $rental = Rental::findOrFail($id);
        $rental->state = '貸出中';
        
        $rental->save();
        return redirect()->route('admin.rentals.index');
    }
    /**
     * 返却処理
     */
    public function completion(string $id)
    {
        $rental = Rental::findOrFail($id);
        $rental->state = '完了';
        
        // レンタル商品
        // dd($rental->rental_item_id->stock_quantity);
        $rental_item = $rental->rentalItem;
        // ストック数を増やす
        $rental_item->stock_quantity += 1;
        if($rental_item->stock_quantity > 0 ){
            $rental_item->state = 1;
            // dd($rental_item->state);
        }

        $rental->save();
        $rental_item->save();
        // dd($rental->state);
        return redirect()->route('admin.rentals.index');
    }
    
    /**
     * 削除
     */
    public function destroy(string $id)
    {
        $rental = Rental::findOrFail($id);
        
        // レンタル商品
        // dd($rental->rental_item_id->stock_quantity);
        $rental_item = $rental->rentalItem;
        // ストック数を増やす
        $rental_item->stock_quantity += 1;
        if($rental_item->stock_quantity > 0 ){
            $rental_item->state = 1;
            // dd($rental_item->state);
        }
        
        
        // dd($rental, $rental_item, $rental_item->state);
        $rental_item->save();
        $rental->delete();

        \Session::flash('success', '予約を取り消しました');
        return redirect()->route('admin.rentals.index');
    }
}
