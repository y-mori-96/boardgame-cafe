<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('admin.auth.register');
    }

    /**
     * 新規ユーザ登録処理
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->only('name', 'email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            /**
             * name、emailに関して、アカウント情報変更と合わせる
             * app/Http/Requests/ProfileUpdateRequest.php
             */
            $request->validate([
                'name' => ['required', 'string', 'max:10'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Admin::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
    
            $user = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            event(new Registered($user));
    
            Auth::guard('admin')->login($user);
    
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }
    }
}
