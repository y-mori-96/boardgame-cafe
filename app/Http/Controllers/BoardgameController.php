<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;

// モデル
use App\Models\Boardgame;
use App\Models\Review;

class BoardgameController extends Controller
{
    /**
     * 一覧
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $query = Boardgame::search($search);
        
        $boardgames = $query->get();
        
        return view('boardgames.index', [
            'header' => 'ボードゲーム一覧',
            'boardgames' => $boardgames,
            'search' => $search,
        ]);
    }
    
    /**
     * 詳細
     */
    public function show(string $id)
    {
        $boardgame = Boardgame::findOrFail($id);
        $reviews = $boardgame->reviews()->latest()->paginate(10);
        $review_count = $boardgame->reviews()->count();
        $review_scores = $boardgame->reviews;
        
        $reviews_score = 0;
        foreach($review_scores as $review_score) {
            $reviews_score += $review_score->score;
        }
        // 条件式 ? 真の場合の値 : 偽の場合の値
        $average_score = $review_scores->count() > 0 ? $reviews_score / $review_scores->count() : 0;

        return view('boardgames.show', [
            'boardgame' => $boardgame,
            'reviews' => $reviews,
            'review_count' => $review_count,
            'average_score' => $average_score,
        ]);
    }
    
    /**
     * レビュー追加
     */
    public function reviewCreate(string $id)
    {
        $boardgame = Boardgame::findOrFail($id);

        return view('review.create', [
            'header' => 'レビュー投稿',
            'boardgame' => $boardgame,
        ]);
    }
    
    /**
    //  * レビュー追加処理
     */
    public function reviewStore(ReviewRequest $request, $boardgame)
    {
        // dd($request, $boardgame);
        $boardgame = Boardgame::findOrFail($boardgame);
        
        Review::create([
          'boardgame_id' => $request->boardgame_id,
          'user_id' => \Auth::user()->id,
          'title' => $request->title,
          'body' => $request->body,
          'score' => $request->score,
        ]);
        session()->flash('success', 'レビューを投稿しました');
        return redirect()->route('boardgames.index');
    }
    
    /**
    //  * レビュー編集処理
     */
    public function reviewEdit(string $review)
    {
        $user = \Auth::user();
        $review = Review::findOrFail($review);
        
        if($review->user_id !== $user->id){
            abort(403);
        }else{
            return view('review.edit', [
              'header' => 'レビュー編集',
              'review'  => $review,
            ]);
        }
    }
    
    /**
     * 投稿更新処理
     */
    public function reviewUpdate(ReviewRequest $request, string $review)
    {
        $review = Review::find($review);
        $review->update($request->only(['title', 'body', 'score']));
        
        session()->flash('success', 'レビューを編集しました');
        return redirect()->route('boardgames.index');
    }
    
    /**
     * 投稿削除処理
     */
    public function reviewDestroy(string $review)
    {
        $review = Review::find($review);
        
        $review->delete();
        \Session::flash('success', 'レビューを削除しました');
        return redirect()->route('boardgames.index');
    }
}
