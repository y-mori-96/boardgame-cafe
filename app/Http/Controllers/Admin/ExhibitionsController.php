<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

// リクエストフォーム
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ExhibitionRequest;

// モデル
use App\Models\Boardgame;
use App\Models\Exhibition;

class ExhibitionsController extends Controller
{
    
    /**
     * アクセス制限
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
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
        // dd($boardgame_name);

        return view('admin.exhibitions.index', [
          'header' => '出品商品一覧',
          'exhibitions' => $exhibitions,
        ]);
    }

    /**
     * 追加フォーム
     */
    public function create()
    {
        return view('admin.exhibitions.create', [
          'header' => '出品商品追加',
        ]);
    }

    /**
     * 追加処理
     */
    public function store(ExhibitionRequest $request)
    {
        //画像投稿処理
        // $path = '';
        // $image = $request->file('image');
        // if( isset($image) === true ){
        //     // publicディスク(storage/app/public/)のphotosディレクトリに保存
        //     $path = $image->store('photos', 'public');
        // }
        // $boardgames = Boardgame::all();
        // $barcode = $request->barcode;
        // dd($request->barcode);
        $boardgames = Boardgame::all();
        $boardgame = $boardgames->where('barcode', $request->barcode)->first();
        
        // dd($boardgame->name);

        Exhibition::create([
            'boardgame_id' => $boardgame->id,
            'description' => $request->description,
            'price' => $request->price,
            // 'image' => $path, // ファイルパスを保存
            'image1' => '', // ファイルパスを保存
            'image2' => '', // ファイルパスを保存
            'image3' => '', // ファイルパスを保存
            'image4' => '', // ファイルパスを保存
        ]);
        session()->flash('success', '出品商品を追加しました');
        return redirect()->route('admin.exhibitions.index');
    }

    /**
     * 商品詳細
     */
    public function show(string $id)
    {
        $exhibition = Exhibition::findOrFail($id);
        
        return view('admin.exhibitions.show', [
            'header' => '出品商品詳細',
            'exhibition' => $exhibition,
        ]);
    }

    /**
     * 編集フォーム
     */
    public function edit(string $id)
    {
        $exhibition = Exhibition::findOrFail($id);

        if($exhibition === null){
            return redirect()->route('admin.exhibitions.index');
        }else{
            return view('admin.exhibitions.edit', [
              'header' => '出品商品情報編集',
              'exhibition'  => $exhibition,
            ]);
        }
    }

    /**
     * 更新処理
     */
    public function update(ExhibitionRequest $request, string $id)
    {
        $exhibition = Exhibition::findOrFail($id);
        $exhibition->update($request->only([
            'description', 
            'price', 
            'image1' => '', // ファイルパスを保存
            'image2' => '', // ファイルパスを保存
            'image3' => '', // ファイルパスを保存
            'image4' => '', // ファイルパスを保存
            // 'image' => $path, // ファイルパスを保存
            // 'image' => '', // ファイルパスを保存
            // 'outline',
        ]));
        
        session()->flash('success', '出品情報を編集しました');
        return redirect()->route('admin.exhibitions.index');
    }

    /**
     * 削除
     */
    public function destroy(string $id)
    {
        $exhibition = Exhibition::findOrFail($id);
        
        $exhibition->delete();
        \Session::flash('success', '出品商品を削除しました');
        return redirect()->route('admin.exhibitions.index');
    }
}
