<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PageHomeController;
use App\Http\Controllers\AdminPanel\AdminController;
use App\Http\Controllers\AdminPanel\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware'=>'sitesettings'], function(){

Route::get('/', [PageHomeController::class,'index'])->name('index');

Route::get('/products', [PageController::class,'products'])->name('products');
Route::get('/categoryproducts/{name}', [PageController::class,'categoryproducts'])->name('categoryproducts');
Route::get('/discountproducts', [PageController::class,'discountproducts'])->name('discountproducts');

Route::get('/product/detail/{slug}', [PageController::class,'productdetail'])->name('productdetail');
Route::get('/adminpanel', [AdminController::class,'adminpanel'])->name('adminpanel')->middleware('auth');
Route::get('/addproduct', [AdminController::class,'addproduct'])->name('addproduct')->middleware('auth');
Route::get('/updateproduct', [AdminController::class,'updateproduct'])->name('updateproduct')->middleware('auth');
Route::post('/urunekleme', [AdminController::class,'ekle'])->name('urunekleme')->middleware('auth');
Route::get('/urunduzenle/{id}', [AdminController::class,'duzenle'])->name('urunduzenle')->middleware('auth');
Route::post('/urunduzenle-post/{id}', [AdminController::class,'duzenlePost'])->name('duzenlePost')->middleware('auth');
Route::get('/urunlistele', [AdminController::class,'liste'])->name('urunlistele')->middleware('auth');
Route::get('/siparistakip', [AdminController::class,'siparisliste'])->name('siparisliste')->middleware('auth');
Route::get('/siparisdetay/{id}', [AdminController::class,'siparisdetay'])->name('siparisdetay')->middleware('auth');
Route::get('/searchadmin', [AdminController::class,'searchadmin'])->name('searchadmin')->middleware('auth');
Route::get('/searchorder', [AdminController::class,'searchorder'])->name('searchorder')->middleware('auth');
Route::get('/search', [PageController::class,'search'])->name('search');
Route::get('/urunlistele/{id}', [AdminController::class,"delete"]);
Route::get('/checkout', [PageController::class,'checkout'])->name('checkout')->middleware('auth');
Route::post('/cart/add', [PageController::class,'addItem'])->name('addItem')->middleware('auth');
Route::post('/add', [PageController::class,'addCart'])->name('addCart')->middleware('auth');
Route::get('/cart', [PageController::class,'showCart'])->name('showCart');
Route::get('/login', [PageController::class,'login'])->name('login');
Route::post('/userlogin', [PageController::class,'userLogin'])->name('userLogin');
Route::post('/create-user', [PageController::class,'createUser'])->name('createUser');
Route::get('/register', [PageController::class,'register'])->name('register');
Route::get('/home', [PageHomeController::class,'userLogout'])->name('userLogout');
Route::get('/deleteCart/{id}', [PageController::class,"deleteCart"])->name('deleteCart');
Route::get('/deleteCartCheckout/{id}', [PageController::class,"deleteCartCheckout"])->name('deleteCartCheckout');
Route::get('/1_Kart', [PageController::class,'kart'])->name('kart');
Route::post('/2_Odeme', [PageController::class,'pay'])->name('pay')->middleware('auth');
Route::post('/3_OdemeOnay', [PageController::class,'odemeonay'])->name('odemeonay')->middleware('auth');
Route::post('/4_OnayCevap', [PageController::class,'onaycevap'])->name('onaycevap')->middleware('auth');
Route::post('/HataSayfasi', [PageController::class,'hata'])->name('hata')->middleware('auth');
Route::put('/order/{id}/update-status', [AdminController::class,'updateStatus'])->name('order.updateStatus');
Route::post('/siparisikaydet', [PageController::class,'siparisikaydet'])->name('siparisikaydet')->middleware('auth');
Route::get('/onaylandi', [PageController::class,'onaylandi'])->name('onaylandi');
Route::get('/reddedildi', [PageController::class,'reddedildi'])->name('reddedildi');
Route::get('/hakkimizda', [PageController::class,'hakkimizda'])->name('hakkimizda');
Route::get('/gizlilik', [PageController::class,'gizlilik'])->name('gizlilik');
Route::get('/sartlarVeKosullar', [PageController::class,'sartlarVeKosullar'])->name('sartlarVeKosullar');
Route::get('/iletisim', [PageController::class,'iletisim'])->name('iletisim');
Route::get('/urundetay/{id}', [AdminController::class,'urundetay'])->name('urundetay')->middleware('auth');
Route::get('/userOrders', [PageController::class,'userOrder'])->name('userOrder')->middleware('auth');
Route::put('order/{orderId}/cancel', [PageController::class, 'cancelOrder'])->name('order.cancel');
Route::put('/return-order/{orderId}', [PageController::class, 'returnOrder'])->name('order.return');
Route::get('/adminpanel', [AdminController::class,'adminpanel'])->name('adminpanel');
Route::post('/adminlogin', [AdminController::class,'adminLogin'])->name('admin.login');
Route::get('/userlogout', [AdminController::class,'adminLogout'])->name('adminlogout');
Route::get('/anasayfa', [AdminController::class,'dashboard'])->name('dashboard');
Route::get('/adminliste', [AdminController::class,'adminliste'])->name('adminliste');
Route::get('/uyeliste', [AdminController::class,'uyeliste'])->name('uyeliste');
Route::get('/searchuser', [AdminController::class,'searchUser'])->name('searchuser')->middleware('auth');
Route::delete('/adminliste/delete/{id}', [AdminController::class, 'destroy']);
Route::get('/adminliste/form', [AdminController::class, 'adminform'])->name('admin.form');
Route::post('/adminliste/ekle', [AdminController::class, 'adminekle'])->name('admin.ekle');
Route::get('/stok', [AdminController::class, 'stok'])->name('stok');
Route::post('/stokguncelle/{id}', [AdminController::class, 'stokGuncelle']);
Route::get('/out-of-stock-products', 'AdminController@outOfStockProducts');
Route::get('/iptaliade', [AdminController::class, 'iptaliade'])->name('iptaliade');
Route::get('/charts', [AdminController::class, 'charts'])->name('charts');
Route::get('/top-selling-products', [AdminController::class, 'getTopSellingProducts']);
Route::get('/cancelled-returned-products', [AdminController::class, 'getCancelledOrReturnedProducts']);
Route::get('/weekly-sales', [AdminController::class, 'getWeeklySales']);
Route::get('/monthly-sales', [AdminController::class, 'getMonthlySales']);
Route::get('/adminayarlar', [AdminController::class, 'adminayarlar'])->name('adminayarlar');
Route::post('/changepassword', [AdminController::class, 'changePassword'])->name('changePassword');
});

