<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\SupportUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SupportController extends Controller
{
    /**
     * Обработать запрос на вход в систему поддержки.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // Вход администратора
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = SupportUser::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            session(['is_admin' => true, 'admin_email' => $user->email]);

            \Log::info('Admin login successful:', ['email' => $user->email]);

            return response()->json([
                'status' => 'success',
                'message' => 'Вход выполнен успешно.',
                'is_admin' => true,
                'email' => $user->email
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Неверный email или пароль.'
        ], 401);
    }

    /**
     * Проверка статуса администратора.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAdminStatus(Request $request)
    {
        $isAdmin = session('is_admin', false);
        return response()->json(['is_admin' => $isAdmin]);
    }

    /**
     * Выход из системы.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        session()->forget('is_admin');

        \Log::info('Admin logout successful.');

        return response()->json([
            'status' => 'success',
            'message' => 'Выход выполнен успешно.'
        ]);
    }
}
