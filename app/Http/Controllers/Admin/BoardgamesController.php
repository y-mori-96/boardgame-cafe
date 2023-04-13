<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// リクエストフォーム
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BoardgameRequest;
use App\Http\Requests\Admin\BoardgameImageRequest;

// モデル
use App\Models\Boardgame;

class BoardgamesController extends Controller
{
    /**
     * アクセス制限（ログイン時のみ）
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * ボードゲーム一覧
     */
    public function index()
    {
        $boardgames = Boardgame::all();

        return view('admin.boardgames.index', [
          'header' => 'ボードゲーム一覧',
          'boardgames' => $boardgames,
        ]);
    }

    /**
     * 追加フォーム
     */
    public function create()
    {
        return view('admin.boardgames.create', [
          'header' => 'ボードゲーム投稿',
        ]);
    }

    /**
     * 追加処理
     */
    public function store(BoardgameRequest $request)
    {
        //画像投稿処理
        // $path = '';
        // $image = $request->file('image');
        // if( isset($image) === true ){
        //     // publicディスク(storage/app/public/)のphotosディレクトリに保存
        //     $path = $image->store('photos', 'public');
        // }

        Boardgame::create([
            'name' => $request->name,
            'barcode' => $request->barcode,
            // 'image' => $path, // ファイルパスを保存
            'image' => '', // ファイルパスを保存
            'outline' => $request->outline,
        //   'play_people_id' => '２～４人',
        //   'play_time_id' => '３０分～６０分',
        ]);
        session()->flash('success', 'ボードゲームを追加しました');
        return redirect()->route('admin.boardgames.index');
    }

    /**
     * 詳細
     */
    public function show(string $id)
    {
        return view('admin.boardgames.show', [
          'header' => 'ボードゲーム詳細',
        ]);
    }

    /**
     * 編集フォーム
     */
    public function edit(string $id)
    {
        $boardgame = Boardgame::find($id);

        if($boardgame === null){
            return redirect()->route('admin.boardgames.index');
        }else{
            return view('admin.boardgames.edit', [
              'header' => 'ボードゲーム編集',
              'boardgame'  => $boardgame,
            ]);
        }
    }

    /**
     * 更新処理
     */
    public function update(BoardgameRequest $request, string $id)
    {
        //画像投稿処理
        // $path = '';
        // $image = $request->file('image');
 
        // if( isset($image) === true ){
        //     // publicディスク(storage/app/public/)のphotosディレクトリに保存
        //     $path = $image->store('photos', 'public');
        // }
        
        $boardgame = Boardgame::find($id);
        
        // 変更前の画像の削除
        // if($boardgame->image !== ''){
        //   \Storage::disk('public')->delete(\Storage::url($boardgame->image));
        // }
        
        $boardgame->update($request->only([
            'name', 
            'barcode', 
            // 'image' => $path, // ファイルパスを保存
            // 'image' => '', // ファイルパスを保存
            'outline',
        ]));
        
        session()->flash('success', '情報を編集しました');
        return redirect()->route('admin.boardgames.index');
    }

    /**
     * 削除
     */
    public function destroy(string $id)
    {
        $boardgame = Boardgame::find($id);
        
        // 画像の削除
        if($boardgame->image !== ''){
          \Storage::disk('public')->delete($boardgame->image);
        }
        
        $boardgame->delete();
        \Session::flash('success', 'ボードゲームを削除しました');
        return redirect()->route('admin.boardgames.index');
    }
    
    /**
     * 画像変更処理
     */
    public function editImage($id)
    {
        $boardgame = Boardgame::find($id);
        
        return view('admin.boardgames.edit_image', [
            'header' => '画像変更画面',
            'boardgame' => $boardgame,
        ]);
    }
    
    /**
     * 画像変更処理
     */
    public function updateImage($id, BoardgameImageRequest $request){
 
        //画像投稿処理
        $path = '';
        $image = $request->file('image');
 
        if( isset($image) === true ){
            // publicディスク(storage/app/public/)のphotosディレクトリに保存
            $path = $image->store('photos', 'public');
        }
 
        $boardgame = Boardgame::find($id);
 
        // 変更前の画像の削除
        if($boardgame->image !== ''){
          \Storage::disk('public')->delete(\Storage::url($boardgame->image));
        }
 
        $boardgame->update([
          'image' => $path, // ファイル名を保存
        ]);
 
        session()->flash('success', '画像を変更しました');
        return redirect()->route('admin.boardgames.index');
      }
}
