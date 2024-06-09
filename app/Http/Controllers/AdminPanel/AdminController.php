<?php

namespace App\Http\Controllers\AdminPanel;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderAction;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    
    public function adminpanel()
    {
        return view('adminpanel.adminlogin');
    }
    public function adminLogin(Request $request)
    {
        // Gelen request'den email ve password değerlerini al
        $credentials = $request->only('email', 'password');

        // Kullanıcıyı authenticate et ve `isAdmin` olup olmadığını kontrol et
        if (Auth::attempt($credentials)) {
            // Kullanıcı doğrulandı, şimdi isAdmin kontrolü yap
            $user = Auth::user();
            if ($user->isAdmin == 1) {
                // Kullanıcı admin ise liste fonksiyonunu çalıştır
                return redirect()->route('dashboard');
            } else {
                // Kullanıcı admin değilse logout yap ve hata mesajı ile geri dön
                Auth::logout();
                return redirect()->route('adminpanel')->withErrors('Bu alana erişim izniniz yok.');
            }
        } else {
            // Doğrulama başarısız, geri yönlendir
            return redirect()->route('adminpanel')->withErrors('Email veya şifre yanlış.');
        }
    }
    public function adminLogout()
    {
           Auth::logout(); // Oturumu sonlandır
    
        return redirect()->route('adminpanel')->with('cikis', 'Çıkış yaptınız..');
    }
    public function dashboard()
{
    $todayOrders = Order::whereDate('created_at', Carbon::today())
                        ->whereNotIn('status', ['İptal edildi', 'İade edildi'])
                        ->count();
    $totalOrders = Order::whereNotIn('status', ['İptal edildi', 'İade edildi'])
                        ->count();
    $todayUsers = User::whereDate('created_at', Carbon::today())->count();
    $totalUsers = User::count();

    $totalSales = Order::sum('total_amount');
    $totalReturnAmount = Order::whereIn('status', ['İptal edildi', 'İade edildi'])->sum('total_amount');
    $returnPercentage = $totalReturnAmount > 0 ? number_format(($totalReturnAmount / $totalSales) * 100, 2) : 0;

    // Haftanın tüm günleri için satış verilerini al
    $lastWeekSalesData = [];
    $thisWeekSalesData = [];

    // Geçen hafta günleri
    $lastWeekStartDate = Carbon::today()->startOfWeek()->subWeek();
    $lastWeekEndDate = Carbon::today()->startOfWeek()->subDay(); // Geçen haftanın son günü (Pazar)

    for ($date = $lastWeekStartDate; $date->lte($lastWeekEndDate); $date->addDay()) {
        $lastWeekSalesData[$date->format('D')] = Order::whereDate('created_at', $date)
                                                      ->whereNotIn('status', ['İptal edildi', 'İade edildi'])
                                                      ->sum('total_amount');
    }

    // Bu hafta günleri
    $thisWeekStartDate = Carbon::today()->startOfWeek();
    $thisWeekEndDate = Carbon::today(); // Bu haftanın bugünü dahil

    for ($date = $thisWeekStartDate; $date->lte($thisWeekEndDate); $date->addDay()) {
        $thisWeekSalesData[$date->format('D')] = Order::whereDate('created_at', $date)
                                                      ->whereNotIn('status', ['İptal edildi', 'İade edildi'])
                                                      ->sum('total_amount');
    }

    // Haftanın tüm günlerini içeren bir dizi oluştur
    $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $monthNames = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];

    // Geçen hafta ve bu hafta satış verilerini birleştir
    $combinedSalesData = [];
    foreach ($daysOfWeek as $day) {
        $combinedSalesData[$day] = [
            'last_week' => $lastWeekSalesData[$day] ?? 0,
            'this_week' => $thisWeekSalesData[$day] ?? 0,
        ];
    }

    // JSON formatında satış verileri
    $salesDataJson = json_encode($combinedSalesData);
    
    
    
    
    $monthlySalesData = Order::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('SUM(total_amount) as total_sales'),
        DB::raw('SUM(CASE WHEN status IN ("İade edildi", "İptal edildi") THEN total_amount ELSE 0 END) as return_amount')
    )
    ->groupBy('month')
    ->orderBy('month')
    ->get();

// Ay bazında sipariş gelirleri ve iade giderleri
$salesData = [];
$returnData = [];

// Verileri ay bazında saklama
foreach ($monthlySalesData as $data) {
    $monthName = $monthNames[$data->month - 1]; // Ay ismini al
    $salesData[$monthName] = $data->total_sales;
    $returnData[$monthName] = $data->return_amount;
}

    return view('adminpanel.anasayfa', compact(
        'todayOrders', 
        'totalOrders', 
        'todayUsers', 
        'totalUsers',
        'salesDataJson',
        'salesData',
        'returnData',
        'totalSales',
        'totalReturnAmount',
        'returnPercentage',
        'monthName'
    ));
}
    public function addproduct()
    {
        return view('adminpanel.urunekle');
    }
    public function adminayarlar()
    {
        return view('adminpanel.adminayarlar');
    }
    public function changePassword(Request $request)
{
    // Yeni şifrenin uzunluğunu kontrol et
    if (strlen($request->new_password) < 8) {
        return redirect()->back()->with('error', 'Yeni şifre en az 8 karakter uzunluğunda olmalıdır.');
    }

    // Diğer doğrulamaları yap
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed',
    ]);

    // Oturum açmış kullanıcıyı al
    $userId = Auth::id();
    $user = User::find($userId);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }

    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->with('error', 'Şifre yanlış.');
    }

    // Yeni şifrenin hash'ini oluştur ve kullanıcıyı güncelle
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'Şifre başarıyla değişti.');
}

	public function urundetay($id)
    {
        $products = Product::where('id', $id)->paginate(15);
        return view('adminpanel.urundetay',compact("products"));
    }
    
    public  function liste() {
        $products = Product::paginate(15);
       return view('adminpanel.urunlistele', compact("products"));
    }
    public  function stok() {
        $products = Product::orderBy('qty')->paginate(20);
       return view('adminpanel.stok', compact("products"));
    }
    public function stokGuncelle(Request $request)
    {
        $productId = $request->input('productId');
        $newQty = $request->input('newQty');

        // Burada gelen productId ile ilgili ürünü veritabanında bulup stok miktarını güncelleyebilirsiniz
        $product = Product::find($productId);
        if ($product) {
            $product->qty = $newQty;
            $product->save();

            return response()->json(['success' => true, 'message' => 'Stok güncellendi.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Ürün bulunamadı.'], 404);
        }
    }
    public function outOfStockProducts()
{
    $outOfStockProducts = Product::where('qty', 0)->get();
    return response()->json($outOfStockProducts);
}
    public function adminliste() {
        $adminUsers = User::where('isAdmin', 1)->paginate(15);
        return view('adminpanel.adminliste', compact('adminUsers'));
    }

    public function adminform()
    {
        return view('adminpanel.adminform');
    }

    public function adminekle(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required',
            'password' => 'required|min:6',
        ]);
    
        $existingUserWithEmail = User::where('email', $request->email)->first();
        $existingUserWithPhone = User::where('phoneNumber', $request->phoneNumber)->first();
    
        if ($existingUserWithEmail) {
            return redirect()->back()->with(['email' => 'Bu email zaten kayıtlı.'])->withInput();
        }
    
        if ($existingUserWithPhone) {
            return redirect()->back()->with(['phoneNumber' => 'Bu telefon numarası zaten kayıtlı.'])->withInput();
        }
    
        // Yukarıdaki kontroller başarılıysa yeni kullanıcı oluşturulabilir
        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->phoneNumber = $request->phoneNumber;
        $user->password = Hash::make($request->password);
        $user->isAdmin = 1;
        $user->save();
    
        return redirect()->route('adminliste')->with('success', 'Kayıt işleminiz başarılı.');
    }

    public function uyeliste() {
        $registeredUsers = User::where('isAdmin', 0)->paginate(15);
        return view('adminpanel.uyeliste', compact('registeredUsers'));
    }
    public function updateproduct()
    {
        return view('adminpanel.urunduzenle');
    }
    public function ekle(Request $request)
    {
        $name=$request->name;
        $categories = $request->input('categories');
        
        $content=$request->content;
        $price=$request->price;
        $qty=$request->qty;
        $status=$request->status;

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imageData = [];
        
            foreach ($images as $image) {
                $filename = $image->getClientOriginalName();
                // Resmi kaydetmek için uygun bir yol belirleyin (örneğin, public/img/products/).
                $destinationPath = 'img/products'; // Relative yol
                $filePath = $destinationPath . '/' . $filename;
        
                // "\\" işaretini "/" ile değiştirin
                $filePath = str_replace('\\/', '/', $filePath);
        
                $image->move(public_path($destinationPath), $filename);
                $imageData[] = $filePath;
            }
        
            $jsonImages = json_encode($imageData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $jsonImages = stripslashes($jsonImages);
        } else {
            $jsonImages = json_encode([], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        

        
            $categoryData = [];

            foreach ($categories as $jsonString) {
                // Her JSON dizesini bir diziye çevirin.
                $categoryArray = json_decode($jsonString, true);

                if ($categoryArray) {
                    // Dizi geçerliyse ana diziye ekleyin.
                    $categoryData[] = $categoryArray;
                }
            }

            // Şimdi oluşturulan diziyi JSON formatına dönüştürebilirsiniz.
            $jsonCategory = json_encode($categoryData,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        
        Product::create([
            "name"=>$name,
           
            "categories"=>$jsonCategory,
            "images"=>$jsonImages,
            "content"=>$content,
            "price"=>$price,
            "qty"=>$qty,
            "status"=>$status
        ]);
        
         return view('adminpanel.urunlistele');
        
    }
/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duzenle($id)
    {
        $product = Product::whereId($id)->first();
        if($product)
        {
            return view('adminpanel.urunduzenle', compact("product"));
        }
        else{

            return redirect()->route('urunlistele');
        }
        
    }



 /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function duzenlePost(Request $request, $id)
     {
         $request->validate([
             'name' => 'required',
             'slug' => 'required',
             'categories' => 'required',
             'content' => 'required',
             'price' => 'required',
             'qty' => 'required|numeric', 
             'status' => 'required',
         ]);
     
         $product = Product::find($id);
     
         if (!$product) {
             return redirect()->route('urunduzenle', ['id' => $id])->with('error', 'Ürün bulunamadı.');
         }
     
         $product->name = $request->input('name');
         $product->slug = $request->input('slug');
         $product->content = $request->input('content');
         $product->price = $request->input('price');
         $product->qty = (float) $request->input('qty'); // Ondalık sayı olarak saklanacaksa
         $product->status = $request->input('status');
     
         if ($request->hasFile('images')) {
             $imageData = [];
     
             foreach ($request->file('images') as $image) {
                 $filename = $image->getClientOriginalName();
                 $destinationPath = 'img/products'; // Resimleri kaydetmek istediğiniz klasör yolu
                 $filePath = $destinationPath . '/' . $filename;
     
                 $image->move(public_path($destinationPath), $filename);
                 $imageData[] = $filePath;
             }
     
             $product->images = json_encode($imageData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
         }
         $categoryData = [];

    foreach ($request->categories as $jsonString) {
        // Her JSON dizesini bir diziye çevirin.
        $categoryArray = json_decode($jsonString, true);

        if ($categoryArray) {
            // Dizi geçerliyse ana diziye ekleyin.
            $categoryData[] = $categoryArray;
        }
    }
    $product->categories = json_encode($categoryData,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
     
         $product->save();
     
         return redirect()->route('urunduzenle', ['id' => $id])->with('success', 'Ürün başarıyla güncellendi.');
     }

    public function searchadmin()
{
    $searchText = request()->input('query');;
    
    // Arama sorgusunu yapıyoruz
    $products = Product::where('name', 'LIKE', '%' . $searchText . '%')->paginate(20);
    
    return view('adminpanel.urunlistele', compact('products'));
}

public function destroy($id)
{
    $adminUsers = User::find($id);

    if ($adminUsers) {
        $adminUsers->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}

public function searchUser()
{
    $searchText = request()->input('query'); // Kullanıcıdan gelen arama metni
    
    $registeredUsers = User::where(function ($query) use ($searchText) {
        $query->where('id', 'LIKE', '%' . $searchText . '%')
              ->orWhere('name', 'LIKE', '%' . $searchText . '%') // Sütunları buraya ekleyin
              ->orWhere('email', 'LIKE', '%' . $searchText . '%')
              ->orWhere('phoneNumber', 'LIKE', '%' . $searchText . '%')
              ->orWhere('surname', 'LIKE', '%' . $searchText . '%');
        // Eklemek istediğiniz her sütunu buraya devam edin
    })->paginate(20);

    return view('adminpanel.uyeliste', compact('registeredUsers'));
}

	public function searchOrder()
{
    $searchText = request()->input('query'); // Kullanıcıdan gelen arama metni
    
    $orders = Order::where(function ($query) use ($searchText) {
        $query->where('id', 'LIKE', '%' . $searchText . '%')
              ->orWhere('products', 'LIKE', '%' . $searchText . '%') // Sütunları buraya ekleyin
              ->orWhere('delivery_name', 'LIKE', '%' . $searchText . '%');
        // Eklemek istediğiniz her sütunu buraya devam edin
    })->paginate(20);

    return view('adminpanel.siparistakip', compact('orders'));
}

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('urunlistele');
    }
	
	public function siparisliste() {
        $orders = Order::orderBy('id', 'desc')->paginate(15);
        return view('adminpanel.siparistakip', compact('orders'));
    }
	
	public function siparisdetay($id) {
        $orders = Order::where('id', $id)->paginate(15);
        return view('adminpanel.siparisdetay', compact("orders"));
    }
	 public function updateStatus(Request $request, $id) {
        $order = Order::findOrFail($id); // Siparişi bul
    
        // Formdan gelen veriyi al ve siparişin durumunu güncelle
        $order->status = $request->input('status');
        $order->save();
    
        return redirect()->back()->with('success', 'Sipariş durumu güncellendi!');
    }
    public function iptaliade()
    {
        $orderActions = OrderAction::all();
        return view('adminpanel.iptaliade',compact('orderActions'));
    }
    public function charts()
    {
        $orders = Order::all();
        return view('adminpanel.charts',compact('orders'));
    }

    public function getTopSellingProducts()
    {
        $orders = Order::all();

        $productCounts = [];

        foreach ($orders as $order) {
            $products = json_decode($order->products, true);
            foreach ($products as $product) {
                $slug = $product['slug'];
                $quantity = $product['quantity'];

                if (isset($productCounts[$slug])) {
                    $productCounts[$slug] += $quantity;
                } else {
                    $productCounts[$slug] = $quantity;
                }
            }
        }

        // En çok satılan ürünleri sıralayıp ilk 5'ini almak için:
        arsort($productCounts);
        $topSlugs = array_slice($productCounts, 0,8, true);

        // Ürün slug'larını kullanarak ürün isimlerini almak
        $topProducts = [];
        foreach ($topSlugs as $slug => $count) {
            $product = DB::table('products')->where('slug', $slug)->first();
            if ($product) {
                $topProducts[$product->name] = $count;
            }
        }

        return response()->json($topProducts);
    }

    


    public function getCancelledOrReturnedProducts()
    {
        // İptal edilen veya iade edilen siparişleri çekme
        $orders = DB::table('orders')
                    ->whereIn('status', ['İptal edildi', 'İade edildi'])
                    ->get();

        $productCounts = [];

        foreach ($orders as $order) {
            $products = json_decode($order->products, true);
            foreach ($products as $product) {
                $slug = $product['slug'];
                $quantity = $product['quantity'];

                if (isset($productCounts[$slug])) {
                    $productCounts[$slug] += $quantity;
                } else {
                    $productCounts[$slug] = $quantity;
                }
            }
        }

        // En çok iptal veya iade edilen ürünleri sıralayıp ilk 5'ini almak için:
        arsort($productCounts);
        $topSlugs = array_slice($productCounts, 0, 5, true);

        // Ürün slug'larını kullanarak ürün isimlerini almak
        $topProducts = [];
        foreach ($topSlugs as $slug => $count) {
            $product = DB::table('products')->where('slug', $slug)->first();
            if ($product) {
                $topProducts[$product->name] = $count;
            }
        }

        return response()->json($topProducts);
    }

    public function getWeeklySales()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $sales = DB::table('orders')
                    ->whereBetween('order_date', [$startOfWeek, $endOfWeek])
                    ->select(DB::raw('DATE(order_date) as date'), DB::raw('SUM(total_amount) as total'))
                    ->groupBy('date')
                    ->get();

        return response()->json($sales);
    }

    public function getMonthlySales()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $sales = DB::table('orders')
                    ->whereBetween('order_date', [$startOfMonth, $endOfMonth])
                    ->select(DB::raw('DATE(order_date) as date'), DB::raw('SUM(total_amount) as total'))
                    ->groupBy('date')
                    ->get();

        return response()->json($sales);
    }

}







   

