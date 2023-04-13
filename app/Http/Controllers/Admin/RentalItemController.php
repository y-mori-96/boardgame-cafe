<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RentalItemRequest;

// モデル
use App\Models\Boardgame;
use App\Models\RentalItem;

class RentalItemController extends Controller
{
    /**
     * アクセス制限
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rental_items = RentalItem::all();
        
        return view('admin.rental-items.index', [
          'header' => 'レンタル一覧',
          'rental_items' => $rental_items,
        ]);
    }

    /**
     * 追加フォーム
     */
    public function create()
    {
        return view('admin.rental-items.create', [
          'header' => 'レンタル追加',
        ]);
    }

    /**
     * 追加処理
     */
    public function store(RentalItemRequest $request)
    {
        $boardgames = Boardgame::all();
        $boardgame = $boardgames->where('barcode', $request->barcode)->first();
        

        RentalItem::create([
            'boardgame_id' => $boardgame->id,
            'state' => true,
            'stock_quantity' => $request->stock_quantity,
        ]);
        session()->flash('success', 'レンタルを追加しました');
        return redirect()->route('admin.rental-items.index');
    }

    /**
     * 商品詳細
     */
    public function show(string $id)
    {
        $rental_item = RentalItem::findOrFail($id);
        
        return view('admin.rental-items.show', [
            'header' => 'レンタル詳細',
            'rental_item' => $rental_item,
        ]);
    }

    /**
     * 編集フォーム
     */
    public function edit(string $id)
    {
        $rental_item = RentalItem::findOrFail($id);

        if($rental_item === null){
            return redirect()->route('admin.rental-items.index');
        }else{
            return view('admin.rental-items.edit', [
              'header' => 'レンタル情報編集',
              'rental_item'  => $rental_item,
            ]);
        }
    }

    /**
     * 更新処理
     */
    public function update(RentalItemRequest $request, string $id)
    {
        $rental_item = RentalItem::findOrFail($id);
        // dd($rental_item, $request->stock_quantity);
        $rental_item->update($request->only([
            'stock_quantity',
        ]));
        session()->flash('success', 'レンタルを追加しました');
        return redirect()->route('admin.rental-items.index');
    }

    /**
     * 削除
     */
    public function destroy(string $id)
    {
        $rental_item = RentalItem::findOrFail($id);
        
        $rental_item->delete();
        \Session::flash('success', 'レンタルを削除しました');
        return redirect()->route('admin.rental-items.index');
    }
}
