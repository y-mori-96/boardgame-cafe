<?php

// コントローラ
namespace App\Http\Controllers;
// リクエストフォーム
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
// モデル
use App\Models\User;
use App\Models\Post;


class PostController extends Controller
{
    /**
     * アクセス制限（ログイン時のみ）
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * 投稿一覧
     */
    public function index(Request $request)
    {
        $user = \Auth::user();
        $follow_user_ids = $user->follow_users->pluck('id');
        $search = $request->search;
        $user_posts = $user->posts()->orWhereIn('user_id', $follow_user_ids )->search($search)->latest()->paginate(10);
        $recommended_users = $user->whereNotIn('id', $follow_user_ids)->recommend($user->id)->limit(3)->get();
        
        
        return view('posts.index', [
            'header' => '投稿一覧',
            'user' => $user,
            'recommended_users' => $recommended_users,
            'posts' => $user_posts,
            'search' => $search,
        ]);
    }

    /**
     * 新規投稿フォーム
     */
    public function create()
    {
        return view('posts.create', [
          'header' => '新規投稿',
        ]);
    }

    /**
     * 投稿追加処理
     */
    public function store(PostRequest $request)
    {
        Post::create([
          'user_id' => \Auth::user()->id,
          'title' => $request->title,
          'body' => $request->body,
        ]);
        session()->flash('success', '投稿を追加しました');
        return redirect()->route('posts.index');
    }

    /**
     * 投稿詳細
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if($post === null){
            return redirect()->route('posts.index');
        }
        
        /* 詳細作成する際はコメントアウト解除 */
        return redirect()->route('posts.index');
        // return view('posts.show', [
        //   'header' => '投稿詳細',
        // ]);
    }

    /**
     * 投稿編集フォーム
     */
    public function edit(string $id)
    {
        $user = \Auth::user();
        $post = Post::find($id);

        if($post === null){
            return redirect()->route('posts.index');
        }else if($post->user_id !== $user->id){
            abort(403);
        }else{
            return view('posts.edit', [
              'header' => '投稿編集',
              'post'  => $post,
            ]);
        }
    }

    /**
     * 投稿更新処理
     */
    public function update(PostRequest $request, string $id)
    {
        $post = Post::find($id);
        $post->update($request->only(['title', 'body']));
        
        session()->flash('success', '投稿を編集しました');
        return redirect()->route('posts.index');
    }

    /**
     * 投稿削除処理
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        
        $post->delete();
        \Session::flash('success', '投稿を削除しました');
        return redirect()->route('posts.index');
    }
}
