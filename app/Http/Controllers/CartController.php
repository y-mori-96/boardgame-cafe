<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// モデル
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;

class CartController extends Controller
{
    
    /**
     * アクセス制限（ログイン時のみ）
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * カード一覧
     */
    public function index()
    {
        $user = User::findOrFail(\Auth::id());
        $exhibitions = $user->exhibitions;
        $totalPrice = 0;
        
        foreach($exhibitions as $exhibition){
            $totalPrice += $exhibition->price;
        }
        
        // dd($exhibitions, $totalPrice);

        return view('cart.index', [
          'header' => '購入商品カート',
          'exhibitions' => $exhibitions,
          'totalPrice' => $totalPrice,
        ]);
    }
    
    /**
     * カードへ追加
     */
    public function add(Request $request)
    {
        $exhibitionInCart = Cart::where('exhibition_id', $request->exhibition_id)->where('user_id', \Auth::id())->first();
        // dd($request);
        if($exhibitionInCart) {
            // 処理なし
        }else{
            Cart::create([
                'user_id' => \Auth::id(),
                'exhibition_id' => $request->exhibition_id,
            ]);
        }
        
        return redirect()->route('cart.index');
    }
    
    /**
     * 削除
     */
    public function destroy(string $id)
    {
        Cart::where('exhibition_id', $id)->where('user_id', \Auth::id())->delete();

        \Session::flash('success', '商品を削除しました');
        return redirect()->route('cart.index');
    }
    
    /**
     * 決済
     */
    public function checkout()
    {
        $user = User::findOrFail(\Auth::id());
        $exhibitions = $user->exhibitions;

        $lineItems = [];
        foreach($exhibitions as $exhibition){
            // https://stripe.com/docs/api/checkout/sessions/create
            // StripeARI->Parameters->show moreより必要なパラメータを渡せるようにする
            $lineItem = [
                // 'name' => $exhibition->boardgame->name,
                // 'description' => $exhibition->boardgame->description,
                // 'amount' => $exhibition->price,
                // 'currency' => 'jpy',
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $exhibition->price,
                    'product_data' => [
                        'name' => $exhibition->boardgame->name,
                        'description' => $exhibition->boardgame->description,
                    ],
                ],
                'quantity' => 1,
            ];
            array_push($lineItems, $lineItem);
        }
        
        // dd($lineItems);
        
        // https://stripe.com/docs/checkout/quickstart?lang=php
        // 構築済みの Checkout ページより設定
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('cart.success'),
            'cancel_url' => route('cart.cancel'),
        ]);
        

        $publicKey = (env('STRIPE_PUBLIC_KEY'));
        
        return view('cart.checkout', [
        //   'header' => 'カート',
          'session' => $session,
          'publicKey' => $publicKey,
        ]);
    }
    
    /**
     * 決済完了
     */
    public function success()
    {   
        $user = User::findOrFail(\Auth::id());
        $exhibitions = $user->exhibitions;
        
        // dd($exhibitions->id);
        
        foreach($exhibitions as $exhibition){
            foreach($user->orders as $order){
                if($order->exhibition_id === $exhibition->id){
                    $order->update([
                        'confirm' => true,
                    ]);
                }
            }
            // dd($order);
        }
        
        // カートから商品削除
        Cart::where('user_id', \Auth::id())->delete();
        
        \Session::flash('success', 'ご購入ありがとうございました。');

        return redirect()->route('exhibitions.index');
    } 
    
    
    /**
     * 決済取消
     */
    public function cancel()
    {   
        $user = User::findOrFail(\Auth::id());
        $exhibitions = $user->exhibitions;

        foreach($exhibitions as $exhibition){
            $order = $user->orders()->where('exhibition_id', $exhibition->id)->first();
            
            // dd($order !== null, $order->confirm, $order->confirm === 0 );
            if( $order !== null && $order->confirm === 0 ) {
                $order->delete();
            }
        }
        
        return redirect()->route('cart.index');
    } 
}
