<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Category;
use App\Models\Cart;
use App\Models\User;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class SiteSettingsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $settings=SiteSettings::pluck('data','name')->toArray();

        $categories = Category::where('status','1')->get();

        $carts =  DB::table('carts')->get();
        $users =  DB::table('users')->get();
        

        view()->share([
            'categories' => $categories,
            'carts' => $carts,
            'users' => $users,
            'settings' => $settings,
            ]); //ayarları sayflara paylaşıyor.

        return $next($request);
    }
}
