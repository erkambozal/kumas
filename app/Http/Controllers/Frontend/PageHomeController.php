<?php

namespace App\Http\Controllers\Frontend;;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageHomeController extends Controller
{
    public function index()
{
    if (auth()->check()) {
        $user = auth()->user();
        $username = $user->name;
        $email = $user->email;
    } else {
        $username = null;
        $email = null;
    }
    
    $slider = Slider::where('status','1')->first();
    $products = Product::where('status','1')->get();
    $productiscampaing=Product::where('isCampaing','1')->first();
    $categories = Category::where('status','1')->get();
    
    return view('frontend.pages.index', compact('slider', 'categories', 'products', 'productiscampaing', 'username', 'email'));
}
   
    
    public function userLogout()
{
    if (Auth::check()) {
        Auth::logout(); // Oturumu sonlandır
    }

    return redirect('/');
}
    
    



}
