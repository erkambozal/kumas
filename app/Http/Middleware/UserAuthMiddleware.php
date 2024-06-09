<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kullanıcı oturumu açıksa devam et
        if (auth()->check()) {
            return $next($request);
        }

        // Kullanıcı oturumu açmamışsa, isteği engelle veya yönlendir
        return redirect('/login'); // Örnek: Giriş sayfasına yönlendir
    }
}