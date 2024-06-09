<!DOCTYPE html>
<html lang="en">
  <?php

  use Illuminate\Support\Facades\Auth;
  
  ?>
  
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tanerk Admin</title>
  <link rel="stylesheet" href="{{asset('/')}}admin/vendors/feather/feather.css">
  <link rel="stylesheet" href="{{asset('/')}}admin/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="{{asset('/')}}admin/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="{{asset('/')}}admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="{{asset('/')}}admin/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="{{asset('/')}}admin/js/select.dataTables.min.css">
  <link rel="stylesheet" href="{{asset('/')}}admin/css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="{{asset('/')}}img/tanerkmini.png" />
  <style>
    tr:hover {
      background-color: lightgray;
      cursor: pointer;
    }
    td {
      max-width: 150px; /* Tablo hücresinin maksimum genişliği */
      overflow: hidden;
      text-overflow: ellipsis; /* Metin taşarsa ... ekle */
      white-space: nowrap;
    }
  </style>
</head>
<body>
  <div class="container-scroller">
    <!-- navbar -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="/anasayfa"><img src="img/tanerk.png" class="mr-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="/anasayfa"><img src="img/tanerkmini.png" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown">
            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="navbar-profile">
                <img class="img-xs rounded-circle" src="img/tanerkmini.png" alt="profile image">
                <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Auth::user()->name }}</p>
                <i class="ti-angle-down"></i>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="{{ route('adminayarlar') }}">
                <i class="ti-settings text-primary"></i>
                Ayarlar
              </a>
              <a class="dropdown-item" href="{{ route('adminlogout') }}" >
                <i class="ti-power-off text-primary"></i>
                Çıkış Yap
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
     
      
      
    </nav>
    <!-- sidebar -->
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/anasayfa">
                  <i class="icon-grid menu-icon"></i>
                  <span class="menu-title">Anasayfa</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/adminliste">
                  <i class="icon-head menu-icon"></i>
                  <span class="menu-title">Admin</span>
                </a>
                <li class="nav-item">
                  <a class="nav-link" href="/uyeliste">
                    <i class="icon-head menu-icon"></i>
                    <span class="menu-title">Üyeler</span>
                  </a>
                  <li class="nav-item">
                    <a class="nav-link" href="/stok">
                      <i class="icon-columns menu-icon"></i>
                      <span class="menu-title">Stok</span>
                      @php
                      $outOfStockCount = App\Models\Product::where('qty', 0)->count();
                  @endphp
                      @if($outOfStockCount > 0)
                    <span id="stock-indicator" class="badge badge-danger" style="position: relative; top: 0px; left: 10px;">{{$outOfStockCount}}</span>
                @endif
                    </a>
                  <li class="nav-item">
                    <a class="nav-link" href="/siparistakip">
                      <i class="icon-grid menu-icon"></i>
                      <span class="menu-title">Siparişler</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/iptaliade">
                      <i class="icon-grid menu-icon"></i>
                      <span class="menu-title">İptal/İade</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/urunlistele">
                      <i class="icon-grid menu-icon"></i>
                      <span class="menu-title">Ürünler</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/addproduct">
                      <i class="icon-paper menu-icon"></i>
                      <span class="menu-title">Ürün Ekle</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/charts">
                      <i class="icon-bar-graph menu-icon"></i>
                      <span class="menu-title">Grafikler</span>
                    </a>
                  </li>
        </ul>
      </nav>

 
      {{-- İçerik --}}


      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                @if(count($orderActions) > 0)
                    @foreach($orderActions as $action)
                        <div class="col-md-4 grid-margin">
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    {{-- İptal veya İade bilgisi --}}
                                    @php
                                        $orderType = ($action->type === 'cancel') ? 'İPTAL' : (($action->type === 'return') ? 'İADE' : '');
                                    @endphp
                                    @if($orderType)
                                        <div class="order-type text-right mb-3">
                                            <p class="mb-0 {{ strtolower($action->type) }}">{{ $orderType }}</p>
                                        </div>
                                    @endif
                                    {{-- Sipariş Numarası --}}
                                    <h4 class="card-title mb-3">Sipariş Numarası: {{ $action->order_id }}</h4>
                                    {{-- Ürün Listesi --}}
                                    <div class="product-list flex-grow-1">
                                        <p class="card-description">
                                            @php
                                                $products = json_decode($action->products, true);
                                            @endphp
                                            @if(is_array($products))
                                                @foreach($products as $productName => $productData)
                                                    @if(is_string($productName) && isset($productData['quantity']))
                                                        {{ $productName }} - <span class="badge bg-warning">Miktar: {{ $productData['quantity'] }}</span><br>
                                                    @endif
                                                @endforeach
                                            @else
                                                No products found
                                            @endif
                                        </p>
                                    </div>
                                    {{-- Kullanıcı bilgisi ve İptal/İade Nedeni --}}
                                    @php
                                        // Kullanıcıyı veritabanından çek
                                        $user = App\Models\User::find($action->user_id);
                                    @endphp
                                    @if($user)
                                        <div class="user-info">
                                            <p class="card-description"><strong>Kullanıcı:</strong> {{ $user->name }} {{ $user->surname }}</p>
                                            <p class="card-description"><strong>İptal/İade Nedeni:</strong> {{ $action->reason }}</p>
                                        </div>
                                    @else
                                        <p class="card-description">Bu kullanıcı bulunamadı veya bilgileri eksik.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                        <div class="alert alert-warning" role="alert">
                            Henüz iptal veya iade işlemi bulunmamaktadır.
                        </div>
                    </div>
                @endif
            </div>
        </div>
      </div>
    </div>
  {{-- script eklentileri --}}
    <script src="{{asset('/')}}admin/vendors/js/vendor.bundle.base.js"></script>
    <script src="{{asset('/')}}admin/vendors/chart.js/Chart.min.js"></script>
    <script src="{{asset('/')}}admin/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="{{asset('/')}}admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="{{asset('/')}}admin/js/dataTables.select.min.js"></script>
    <script src="{{asset('/')}}admin/js/off-canvas.js"></script>
    <script src="{{asset('/')}}admin/js/hoverable-collapse.js"></script>
    <script src="{{asset('/')}}admin/js/template.js"></script>
    <script src="{{asset('/')}}admin/js/settings.js"></script>
    <script src="{{asset('/')}}admin/js/todolist.js"></script>
    <script src="{{asset('/')}}admin/js/dashboard.js"></script>
    <script src="{{asset('/')}}admin/js/Chart.roundedBarCharts.js"></script>
    <script src="{{asset('/')}}admin/js/outOfStock.js"></script>
  </body>
  
  </html>
  <style>
    body {
        background-color: #f4f4f4;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
  
    .navbar {
        background-color: #6c757d;
    }
  
    .sidebar .nav-item .nav-link {
        color: #ffffff;
        background: #343a40;
        border-radius: 4px;
        margin: 5px 0;
    }
  
    .sidebar .nav-item .nav-link:hover {
        background: #495057;
    }
  
    .card {
    border: none; /* Remove border */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease; /* Smooth transition for box-shadow */
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Larger shadow on hover */
}

.card-title {
    color: #343a40;
    font-weight: bold;
    margin-bottom: 10px; /* Add some space below title */
}

.card-description {
    color: #6c757d; /* Dim the description text color */
    font-size: 0.9rem; /* Adjust description text size */
    margin-bottom: 15px; /* Add space below description */
}

.alert {
    border-radius: 10px; /* Rounded corners for alerts */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease; /* Smooth transition for box-shadow */
}

.alert:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Larger shadow on hover */
}

.alert-warning {
    color: #856404; /* Adjust text color for warning alerts */
    background-color: #fff3cd; /* Adjust background color for warning alerts */
    border-color: #ffeeba; /* Adjust border color for warning alerts */
    margin-bottom: 15px; /* Add space below alert */
}
  
    .form-group label {
        font-size: 1.1em;
        color: #495057;
    }
  
    .form-control {
        border-radius: 4px;
    }
  
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 4px;
    }
  
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
  
    .btn-light {
        border-radius: 4px;
    }
  
    .image-preview img {
        border-radius: 8px;
        margin-right: 10px;
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
    }
  
    .kategoriler label {
        font-weight: bold;
        margin-top: 10px;
        display: block;
    }
  
    .kategoriler input[type="checkbox"] {
        margin-right: 10px;
    }
  
    .kategoriler {
        margin-bottom: 15px;
    }
  
    .file-upload-info {
        border-radius: 4px;
    }
  
    .input-group .file-upload-browse {
        border-radius: 0 4px 4px 0;
    }
  
    footer.footer {
        background: #f8f9fa;
        padding: 20px 0;
    }
    .navbar-profile {
    display: flex;
    align-items: center;
  }
  
  .navbar-profile img {
    width: 32px;
    height: 32px;
    margin-right: 10px;
  }
  
  .navbar-profile-name {
    font-weight: bold;
  }
  
  .navbar-nav .dropdown-menu {
    width: 200px;
  }
  
  .navbar-nav .dropdown-item {
    display: flex;
    align-items: center;
  }
  
  .navbar-nav .dropdown-item i {
    margin-right: 10px;
  }
  #stock-indicator {
      position: relative;
      top: 30px; /* Yukarıya doğru hareket ettirir */
      right: 10px; /* Sağa doğru hareket ettirir */
      width: 24px; /* Genişliği artır */
      height: 24px; /* Yüksekliği artır */
      background-color: red; /* Daha yumuşak bir kırmızı ton */
      color: white; /* Yazı rengi beyaz */
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px; /* Yazı boyutu */
      font-weight: bold;
      border-radius: 50%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Daha belirgin gölge */
      transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animasyonlu geçiş */
      line-height: 1; /* Satır yüksekliği */
  }
  
  #stock-indicator:hover {
      transform: scale(1.2); /* Hover'da büyüme efekti */
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.7); /* Hover'da daha belirgin gölge */
  }
  .order-type p {
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
}

.order-type .cancel {
    background-color: #ff6347; /* Kırmızı */
}

.order-type .return {
    background-color: #20b2aa; /* Mavi */
}
    </style>
  