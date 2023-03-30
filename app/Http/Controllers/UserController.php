<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;

class UserController extends Controller
{
    /**
     * アクセス制限（ログイン時のみ）
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * ユーザー詳細
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if($user === null){
            return redirect()->route('posts.index');
        }
        
        $posts = User::find($id)->posts()->latest('created_at')->paginate(10);
        return view('users.show', [
          'header' => 'ユーザ詳細',
          'user' => $user,
          'posts' => $posts
        ]);
    }
}
