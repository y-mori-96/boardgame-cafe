<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// リクエストフォーム
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BoardgameRequest;

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
        Boardgame::create([
          'name' => $request->name,
          'barcode' => '111111',
        //   'image' => '', // 仮置き
          'outline' => '概要',
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
        return view('admin.boardgames.edit', [
          'header' => 'ボードゲーム編集',
        ]);
    }

    /**
     * 更新処理
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * 削除
     */
    public function destroy(string $id)
    {
        //
    }
}
