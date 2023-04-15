<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\User;
use App\Models\Rental;

use Carbon\Carbon;

class UsersController extends Controller
{
    /**
     * アクセス制限（ログイン時のみ）
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    /**
     * ユーザ一覧
     */
    public function index()
    {
        $users = User::select('name', 'email', 'created_at')->paginate(5);
        // $users = User::all();
        // dd($users->created_at-);
        
        return view('admin.users.index', [
            'header' => 'ユーザ一覧',
            'users' => $users,
        ]);
    }
    
    /**
     * ユーザレンタル状態
     */
    public function rentals()
    {
        $user = User::findOrFail(\Auth::id());
        $rentals = $user->rentals;
        // dd($rentals);
        

        // $users = User::all();
        // dd($users->created_at-);
        
        return view('admin.users.rentals', [
            'header' => 'レンタル状態',
            'user' => $user,
            'rentals' => $rentals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
