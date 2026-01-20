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
            // Try to check if database is accessible
            \DB::connection()->getPdo();

            // Check if user table exists (untuk handle fresh migration)
            if (!\Schema::hasTable('users')) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('warning', 'Database telah di-reset. Silakan login kembali.');
            }

            // Check if current user still exists in database
            if (Auth::check()) {
                $user = \App\Models\User::find(Auth::id());
                if (!$user) {
                    Auth::logout();
                    return redirect()->route('login')
                        ->with('warning', 'Session Anda tidak valid. Silakan login kembali.');
                }
            }

        } catch (\Exception $e) {
            // Database connection failed
            if (Auth::check()) {
                Auth::logout();
            }
            return redirect()->route('login')
                ->with('error', 'Koneksi database bermasalah. Silakan hubungi administrator.');
        }

        return $next($request);
    }
}
