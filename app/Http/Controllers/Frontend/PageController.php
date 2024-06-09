<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;



class PageController extends Controller
{
    public function products(Request $request)
    {

        $order=$request->order ?? 'id';
        $short=$request->short ?? 'asc';



        $products = Product::where('status', '1');

        $products= $products->orderBy($order,$short)->paginate(40);

        return view('frontend.pages.products', compact('products'));
    }
     public function categoryproducts($name, Request $request)
    {

        $order=$request->order ?? 'id';
        $short=$request->short ?? 'asc';


        $categoryproducts = Product::whereRaw('JSON_SEARCH(`categories`, "one", ?) IS NOT NULL',  $name);
        $categoryproducts = $categoryproducts->orderBy($order,$short)->paginate(40);

        return view('frontend.pages.categoryproducts', compact('categoryproducts','name'));
    }

    public function discountproducts()
    {
        return view('frontend.pages.products');
    }

    public function productdetail($slug)
    {

        $product = Product::where('slug', $slug)->first();
        $productcategories = json_decode($product->categories, true);
        $productcategory = isset($productcategories[0]) ? $productcategories[0] : null;
        $firstcategory = isset($productcategory['name']) ? $productcategory['name'] : null;


        $randomproducts = Product::where('slug', '!=', $slug)->
            whereRaw('JSON_SEARCH(`categories`, "one", ?) IS NOT NULL',  $firstcategory)
            ->take(8)
            ->get();

        return view('frontend.pages.productdetail', compact('product', 'randomproducts'));
    }

    public function checkout()
    {
        return view('frontend.pages.checkout');
    }

    public function deneme()
    {
        return view('frontend.pages.deneme');
    }
    public function denemecategory()
    {

        $categories = Category::where('status', '1')->get();

        return view('frontend.pages.vericategory', compact('categories'));
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function flowers()
    {
        return view('frontend.pages.flowers');
    }
    public function login()
    {
        return view('frontend.pages.login');
    }
    public function register()
    {
        return view('frontend.pages.register');
    }
    public function admin()
    {
        return view('frontend.pages.adminpanel');
    }
    public function odeme()
    {
        return view('frontend.pages.odeme');
    }
	public function onaylandi()
    {
        return view('frontend.pages.onaylandi');
    }
	public function reddedildi()
    {
        return view('frontend.pages.reddedildi');
    }   
    public function hakkimizda()
    {
        return view('frontend.pages.hakkimizda');
    } 
    public function gizlilik()
    {
        return view('frontend.pages.gizlilik');
    } 
    public function sartlarVeKosullar()
    {
        return view('frontend.pages.sartlarVeKosullar');
    } 
    public function iletisim()
    {
        return view('frontend.pages.iletisim');
    } 
    public function userOrder() {
        $userId = auth()->user()->id;
        $orders = Order::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('frontend.pages.userOrders', compact('orders'));
    }
   
   
    public function search()
    {
        $search_text = $_GET["query"];
        $name=$search_text;
        
        // Arama sorgusunu yapıyoruz
        $categoryproducts = Product::where('name', 'LIKE', '%' . $search_text . '%')->paginate(20);
        
        return view('frontend.pages.categoryproducts', compact('categoryproducts','name'));
    }
    




    public function addItem(Request $request)
    {
        // Sepete eklemek istediğiniz ürünü ve miktarı alın
        $productId = $request->input('product'); // Ürünün ID'sini alın
        $quantity = $request->input('quantity');
        
        // Ürünü veritabanından çekin
        $product = Product::find($productId);
        
        if (!$product) {
            // Ürün bulunamadıysa hata mesajı gönderin veya uygun bir işlem yapın
            return redirect()->back()->with('error', 'Ürün bulunamadı.');
        }
    
        // Eğer istenilen miktar 0 veya negatifse, hata mesajı gönderin
        if ($quantity <= 0) {
            return redirect()->back()->with('stoktayok', 'Lütfen istediğiniz miktarı giriniz.');
        }
        
        // Kullanıcı oturumu kontrolü ve kullanıcı ID'sini alın
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id; // Oturum açmış bir kullanıcı varsa, kullanıcı ID'sini alın
        } else {
            $userId = null; // Oturum açmamışsa, kullanıcı ID'sini null olarak ayarlayın
        }
        
        // Eğer aynı ürün sepette varsa, miktarını güncelleyin; yoksa yeni ürünü ekleyin
        $existingCartItem = Cart::where('user_id', $userId)
                                    ->where('product_id', $productId)
                                    ->first();
        
        if ($existingCartItem) {
            // Sepetteki toplam ürün miktarını kontrol edin
            $totalQuantity = $existingCartItem->quantity + $quantity;
            $productQuantity = $product->qty;
            
            // Eğer sepetteki toplam miktar, ürün stoğunu aşıyorsa veya ürün stoğu tamamen tükenmişse hata mesajı gönderin
            if ($totalQuantity > $productQuantity || $productQuantity <= 0) {
                return redirect()->back()->with('stoktayok', 'Ürün adedi stok sayısını geçiyor veya stokta ürün bulunmuyor.');
            }
            
            // Sepetteki ürün miktarını güncelleyin
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save(); // Değişiklikleri kaydedin
        } else {
            // Eğer ürün stokta varsa veya stok sıfırdan büyükse, sepete ekleme işlemini gerçekleştirin
            if ($product->qty > 0) {
                Cart::create([
                    "user_id" => $userId,
                    "product_id" => $productId,
                    "productName" => $product->name,
                    "slug" => $product->slug,
                    "images" => $product->images,
                    "price" => $product->price,
                    "quantity" => $quantity,
                ]);
            } else {
                return redirect()->back()->with('stoktayok', 'Stokta ürün bulunmuyor.');
            }
        }
        
        return redirect()->back()->with('uruneklendi', 'Ürün sepete eklendi.');
    }
    
    
    

	
	
public function showCart()
    {
        return view('frontend.pages.flowers');
    }
    
    public function showUserCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userId = $user->id;

            // Kullanıcının kendi sepet öğelerini getirin
            $carts = Cart::where('user_id', $userId)->get();

            return view('cart', ['carts' => $carts]);
        } else {
            return redirect()->route('login'); // Kullanıcı oturumu yoksa giriş sayfasına yönlendirin veya uygun bir işlem yapın.
        }
    }



    public function userLogin(Request $request)
{
    $email = $request->input('email');
    $password = $request->input('password');

    $credentials = [
        'email' => $email,
        'password' => $password
    ];

    // Email ve şifre ile oturumu denetle
    if (Auth::attempt($credentials)) {
        // Kullanıcı başarılı bir şekilde giriş yaptı
        $user = Auth::user(); // Giriş yapan kullanıcıyı al
        
        // Eğer kullanıcı yönetici ise, giriş bilgileri hatalı hatası ver
        if ($user->isAdmin) {
            Auth::logout(); // Yönetici oturumunu sonlandır
            return back()->with('login', 'Giriş bilgileri hatalı.');
        } else {
            Auth::login($user); // Kullanıcıyı oturumla ilişkilendir
            return redirect('/'); // Normal kullanıcı olarak yönlendir
        }
    
    } else {
        // Kullanıcı girişi başarısız
        return back()->with('login', 'Giriş bilgileri hatalı.');
    }
}
    

    
        public function createUser(Request $request)
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
        $user->save();
    
        return redirect()->route('login')->with('success', 'Kayıt işleminiz başarılı. Şimdi giriş yapınız.');
    }
    public function userLogout()
    {
           Auth::logout(); // Oturumu sonlandır
    
        return redirect()->route('userLogout')->with('cikis', 'Çıkış yaptınız..');
    }

    public function deleteCart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->route('index');
    }

  public function deleteCartCheckout($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        return redirect()->route('checkout');
    }

    

    
  
public function kart()
    {
        return view('frontend.pages.1_Kart');
    }
	
	
    public function pay(Request $request)
    {
		
     {
            if (Auth::check()) {
                $user = Auth::user();
                $userId = $user->id;
            }
        }
    $request->session()->put('delivery_info', $request->all());
     /*   // Retrieve necessary information from the request
        $delivery_name = $request->input('delivery_name');
        $delivery_surname = $request->input('delivery_surname');
        $delivery_phone = $request->input('delivery_phone');
        $delivery_address = $request->input('delivery_address');
        $delivery_note = $request->input('delivery_note');
        $delivery_email = $request->input('delivery_email');
        $total_amount = $request->input('total_amount');
        $status = "Hazırlanıyor";
        $order_date = now();
    
        // Fetch cart items for the user
        $cartItems = [];
        if ($userId) {
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        }
    
        // Create an array to store products and quantities
        $products = [];
        foreach ($cartItems as $cartItem) {
            $products[$cartItem->product->name] = $cartItem->quantity;
        }
        $productsJson = json_encode($products,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $statusOptions = [
            0 => "Hazırlanıyor",
            1 => "Kargoya verildi",
            2 => "Teslim edildi"
        ];
        
        $status = 0;
        
        $statusText = isset($statusOptions[$status]) ? $statusOptions[$status] : "Bilinmeyen Durum";
        // Create the order and store products
        Order::create([
            "user_id" => $userId,
            "delivery_name" => $delivery_name,
            "delivery_surname" => $delivery_surname,
            "delivery_phone" => $delivery_phone,
            "delivery_address" => $delivery_address,
            "delivery_note" => $delivery_note,
            "delivery_email" => $delivery_email,
            "total_amount" => $total_amount,
            "order_date" => $order_date,
            "status" => $statusText,
            "products" => $productsJson,
        ]);
        if ($userId) {
            Cart::where('user_id', $userId)->delete();
        }*/
        return view('frontend.pages.2_Odeme');
    }
    public function odemeonay()
    {
        return view('frontend.pages.3_OdemeOnay');
    }
    public function onaycevap(Request $request)
{
	/*	$responseCode = $request->input('ResponseCode');
    $deliveryInfo = $request->session()->get('delivery_info');

    $userId = null; // Varsayılan olarak userId'yi null yapalım

    if (isset($deliveryInfo['user_id'])) {
        $userId = $deliveryInfo['user_id'];
    } elseif (Auth::check()) {
        $user = Auth::user();
        $userId = $user->id;
    }

    $delivery_name = $deliveryInfo['delivery_name'] ?? null;
    $delivery_surname = $deliveryInfo['delivery_surname'] ?? null;
    $delivery_phone = $deliveryInfo['delivery_phone'] ?? null;
    $delivery_address = $deliveryInfo['delivery_address'] ?? null;
    $delivery_note = $deliveryInfo['delivery_note'] ?? null;
    $delivery_email = $deliveryInfo['delivery_email'] ?? null;
    $total_amount = $deliveryInfo['total_amount'] ?? null;
    $order_date = now();
    
    $statusOptions = [
        0 => "Hazırlanıyor",
        1 => "Kargoya verildi",
        2 => "Teslim edildi"
    ];

    $status = 0; // Varsayılan olarak Hazırlanıyor durumunu atayalım
    $statusText = isset($statusOptions[$status]) ? $statusOptions[$status] : "Bilinmeyen Durum";

    $cartItems = [];
    if ($userId) {
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
    }

    // Ürünleri ve miktarlarını içeren bir dizi oluştur
    $products = [];
    foreach ($cartItems as $cartItem) {
        $products[$cartItem->product->name] = [
            'quantity' => $cartItem->quantity,
            'slug' => $cartItem->product->slug // Burada ürünün slug'ını ekliyoruz
        ];
    }
    $productsJson = json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    // Order modelini kullanarak veritabanına kayıt yapma
    if($responseCode == 10){
		Order::create([
        "user_id" => $userId,
        "delivery_name" => $delivery_name,
        "delivery_surname" => $delivery_surname,
        "delivery_phone" => $delivery_phone,
        "delivery_address" => $delivery_address,
        "delivery_note" => $delivery_note,
        "delivery_email" => $delivery_email,
        "total_amount" => $total_amount,
        "order_date" => $order_date,
        "status" => $statusText,
        "products" => $productsJson, // Ürün bilgilerini burada sağlamalısınız
    ]);

    // Eğer kullanıcı varsa, sepeti temizle
    if ($userId) {
        Cart::where('user_id', $userId)->delete();
    }
	}*/
	

     return view('frontend.pages.4_OnayCevap');
}
public function siparisikaydet(Request $request)
{
    $deliveryInfo = $request->session()->get('delivery_info');
    $responseCode = $request->input('ResponseCode');
    $userId = null; // Varsayılan olarak userId'yi null yapalım

    if (isset($deliveryInfo['user_id'])) {
        $userId = $deliveryInfo['user_id'];
    } elseif (Auth::check()) {
        $user = Auth::user();
        $userId = $user->id;
    }
    
    $delivery_name = $deliveryInfo['delivery_name'] ?? null;
    $delivery_surname = $deliveryInfo['delivery_surname'] ?? null;
    $delivery_phone = $deliveryInfo['delivery_phone'] ?? null;
    $delivery_address = $deliveryInfo['delivery_address'] ?? null;
    $delivery_note = $deliveryInfo['delivery_note'] ?? null;
    $delivery_email = $deliveryInfo['delivery_email'] ?? null;
    $total_amount = $deliveryInfo['total_amount'] ?? null;
    $order_date = now();
    
    $statusOptions = [
        0 => "Hazırlanıyor",
        1 => "Kargoya verildi",
        2 => "Teslim edildi",
        3 => "İptal Edildi",
        4 => "İade Edildi",
    ];

    $status = 0; // Varsayılan olarak Hazırlanıyor durumunu atayalım
    $statusText = isset($statusOptions[$status]) ? $statusOptions[$status] : "Bilinmeyen Durum";

    $cartItems = [];
    if ($userId) {
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
    }

    // Ürünleri ve miktarlarını içeren bir dizi oluştur
    $products = [];
    foreach ($cartItems as $cartItem) {
        $products[$cartItem->product->name] = [
            'quantity' => $cartItem->quantity,
            'slug' => $cartItem->product->slug // Burada ürünün slug'ını ekliyoruz
        ];
    }
    $productsJson = json_encode($products, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    // Veritabanına siparişi kaydet
    $order = Order::create([
        "order_id" => Str::random(10), // 10 karakter uzunluğunda rastgele bir dize oluştur
        "user_id" => $userId,
        "delivery_name" => $delivery_name,
        "delivery_surname" => $delivery_surname,
        "delivery_phone" => $delivery_phone,
        "delivery_address" => $delivery_address,
        "delivery_note" => $delivery_note,
        "delivery_email" => $delivery_email,
        "total_amount" => $total_amount,
        "order_date" => $order_date,
        "status" => $statusText,
        "products" => $productsJson, // Ürün bilgilerini burada sağlamalısınız
    ]);

    foreach ($cartItems as $cartItem) {
        $product = $cartItem->product;
        $orderedQuantity = $cartItem->quantity;
    
        // Güncel ürün stoğunu kontrol et ve azalt
        if ($product->qty >= $orderedQuantity) {
            $product->qty -= $orderedQuantity;
            $product->save();
        } else {
            // Eğer sipariş edilen miktar, mevcut stoğu aşıyorsa hata mesajı verebilirsiniz
            return back()->with('error', 'Üzgünüz, ' . $product->name . ' ürününün stoğu yetersiz.');
        }
    }

    // Eğer kullanıcı varsa, sepeti temizle
    if ($userId) {
        Cart::where('user_id', $userId)->delete();
    }

    session(['deliveryInfo' => $deliveryInfo]);
    return redirect()->route('onaylandi');
}
	
    public function hata()
    {
        return view('frontend.pages.HataSayfasi');
    }
    
    public function cancelOrder(Request $request, $orderId)
{
    // Mevcut kullanıcının ID'sini al
    $userId = Auth::id();

    // İptal nedenini al
    $reason = $request->input('reason');

    // Siparişi bul
    $order = Order::find($orderId);

    // Eğer sipariş bulunamazsa hata döndür
    if (!$order) {
        return response()->status(404); // 404: Not Found
    }

    // OrderAction kaydını oluştur
    $orderAction = new OrderAction();
    $orderAction->user_id = $userId;
    $orderAction->order_id = $orderId;
    $orderAction->type = 'cancel'; // iptal işlemi
    $orderAction->reason = $reason ?: "Müşteri isteği"; // Eğer iptal nedeni yoksa default olarak "Müşteri isteği" kullan

    // OrderAction modelinin products alanına direkt olarak atama
    $orderAction->products = $order->products;

    // OrderAction kaydını veritabanına kaydet
    $orderAction->save();

    // Siparişin durumunu "İptal edildi" olarak güncelle
    $order->status = "İptal edildi";
    $order->save();

    // Ürün stoklarını güncelle
    $products = json_decode($order->products, true); // Ürünleri json formatından array formatına çevir
    foreach ($products as $productData) {
        $product = Product::where('slug', $productData['slug'])->first();
        if ($product) {
            $product->qty += $productData['quantity']; // Ürün stoklarını güncelle
            $product->save();
        }
    }

    // İşlem başarılı mesajı dön
    return redirect()->back()->with('success', 'Sipariş başarıyla iptal edildi.');
}
public function returnOrder(Request $request, $orderId)
{
    // Mevcut kullanıcının ID'sini al
    $userId = Auth::id();

    // İade nedenini al
    $reason = $request->input('reason');

    // Siparişi bul
    $order = Order::find($orderId);

    // Eğer sipariş bulunamazsa hata döndür
    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    // OrderAction kaydını oluştur
    $orderAction = new OrderAction();
    $orderAction->user_id = $userId;
    $orderAction->order_id = $orderId;
    $orderAction->type = 'return'; // iade işlemi
    $orderAction->reason = $reason ?: "Müşteri isteği"; // Eğer iade nedeni yoksa default olarak "Müşteri isteği" kullan

    // OrderAction modelinin products alanına direkt olarak atama
    $orderAction->products = $order->products;

    // OrderAction kaydını veritabanına kaydet
    $orderAction->save();

    // Siparişin durumunu "İade edildi" olarak güncelle
    $order->status = "İade edildi";
    $order->save();

    // Ürün stoklarını güncelle
    $products = json_decode($order->products, true); // Ürünleri json formatından array formatına çevir
    foreach ($products as $productData) {
        $product = Product::where('slug', $productData['slug'])->first();
        if ($product) {
            $product->qty += $productData['quantity']; // Ürün stoklarını güncelle
            $product->save();
        }
    }

    // İşlem başarılı mesajı dön
    return redirect()->back()->with('success', 'İade talebi oluşturuldu. Anlaşmalı kurye şirketinde "6378238731" numaralı gönderim koduyla ürünleri gönderebilirsiniz. Ücret iadesi bankanızın iade politikasına bağlı olarak birkaç gün sürebilir. Ayrıntılı bilgi için Whatsapp üzerinden ulaşabilirsiniz.');
}

    
    

}