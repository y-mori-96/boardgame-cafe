<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// モデル
use App\Models\Boardgame;

class BoardgameController extends Controller
{
    /**
     * 投稿一覧
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $query = Boardgame::search($search);
        
        $boardgames = $query->get();
        // $boardgames = Boardgame::all();
        // dd($search);
        
        return view('boardgames.index', [
            'header' => 'ボードゲーム一覧',
            'boardgames' => $boardgames,
            'search' => $search,
        ]);
    }
}
