<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// モデル
use App\Models\User;
use App\Models\Boardgame;
use App\Models\Exhibition;
use App\Models\Order;

class ExhibitionController extends Controller
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
    private function isExistence($exhibition){
        if($exhibition === null){
            // session()->flash('success','その商品は存在しません');
            return true;
        }
    }
    
    /**
     * 商品一覧
     */
    public function index()
    {
        $exhibitions = Exhibition::all();
        
        foreach($exhibitions as $exhibition) {
            $boardgame_name = $exhibition->boardgame->name;
            // $boardgame_nameにboardgame_idに紐づくBoardgameのnameが入ります
            // ここで$nameとして何かしらの処理を行います
        }
        
        return view('exhibitions.index', [
            'header' => '商品一覧',
            'exhibitions' => $exhibitions,
        ]);
    }
    
    /**
     * 商品詳細
     */
    public function show(string $id)
    {
        $exhibition = Exhibition::findOrFail($id);
        
        return view('exhibitions.show', [
            'header' => '商品詳細',
            'exhibition' => $exhibition,
        ]);
    }
    
    /**
     * 購入確認
     */
    public function confirm($id)
    {
        $user = \Auth::user();
        $exhibition = Exhibition::find($id);
        
        if($this->isExistence($exhibition)){
            return redirect()->route('exhibitions.index');
        }
        
        return view('exhibitions.confirm', [
           'header'  => '購入確認',
           'exhibition' => $exhibition,
        ]);
    }

    /**
     * 売り切れ処理
     */
    public function addSoldItem($id){
        $user = User::findOrFail(\Auth::id());
        $exhibitions = $user->exhibitions;
        // dd($exhibitions);
        
        foreach($exhibitions as $exhibition){
            if($exhibition->isSold()){
                session()->flash('success','申し訳ありません。ちょっと前に売り切れました。');
                return redirect()->route('cart.index');
            }else{
                $order = Order::create([
                    'user_id' => $user->id,
                    'exhibition_id' => $exhibition->id,
                    'confirm' => false,
                ]);
            }
            // dd($order);
        }
        // dd('check');
        // return redirect(route('exhibitions.finish', $exhibition));
        return redirect(route('cart.checkout'));
    }
}
