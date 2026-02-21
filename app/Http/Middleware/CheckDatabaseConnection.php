<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckDatabaseConnection
{

    public function handle(Request $request, Closure $next)
    {
        try {
            \DB::connection()->getPdo();

            if (!\Schema::hasTable('users')) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('warning', 'Database telah di-reset. Silakan login kembali.');
            }

            if (Auth::check()) {
                $user = \App\Models\User::find(Auth::id());
                if (!$user) {
                    Auth::logout();
                    return redirect()->route('login')
                        ->with('warning', 'Session Anda tidak valid. Silakan login kembali.');
                }
            }

        } catch (\Exception $e) {
            if (Auth::check()) {
                Auth::logout();
            }
            return redirect()->route('login')
                ->with('error', 'Koneksi database bermasalah. Silakan hubungi administrator.');
        }

        return $next($request);
    }
}
