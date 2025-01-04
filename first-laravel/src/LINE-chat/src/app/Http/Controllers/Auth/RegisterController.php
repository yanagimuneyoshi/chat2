<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * ユーザー登録フォームの表示
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // 登録フォームのビューを返す
    }

    /**
     * ユーザー登録の処理
     */
    public function register(Request $request)
    {
        // バリデーション
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // ユーザーを作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 自動的にログイン
        auth()->login($user);

        // リダイレクト
        return redirect('/login')->with('success', '登録が完了しました！');
    }
}
