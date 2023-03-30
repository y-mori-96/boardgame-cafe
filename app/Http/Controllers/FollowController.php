<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Follow;

class FollowController extends Controller
{
    /**
     * アクセス制限（ログイン時のみ）
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * フォロー一覧
     */
    public function index()
    {
        $follow_users = \Auth::user()->follow_users;
        return view('follows.index', [
          'header' => 'フォロー一覧',
          'follow_users' => $follow_users,
        ]);
    }

    /**
     * フォロー追加処理
     */
    public function store(Request $request)
    {
        $user = \Auth::user();
        Follow::create([
           'user_id' => $user->id,
           'follow_id' => $request->follow_id,
        ]);
        \Session::flash('success', 'フォローしました');
        return redirect()->back();
    }

    /**
     * フォロー削除処理
     */
    public function destroy(string $id)
    {
        $follow = \Auth::user()->follows->where('follow_id', $id)->first();
        $follow->delete();
        \Session::flash('success', 'フォロー解除しました');
        return redirect()->back();
    }

    /**
     * フォロワー一覧
     */
    public function followerIndex()
    {
        $followers = \Auth::user()->followers;
        return view('follows.follower_index', [
          'header' => 'フォロワー一覧',
          'followers' => $followers,
        ]);
    }
}
