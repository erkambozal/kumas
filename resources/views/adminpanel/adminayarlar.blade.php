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
              <a class="dropdown-item" href="/settings">
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
      <!-- içerik -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-md-5 grid-margin transparent">
                <div class="row justify-content-right">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-body">
                                <h2 class="card-title text-center mb-4">Şifre Değiştir</h2>
                                @if(session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                                <form method="POST" action="{{ route('changePassword') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="current_password">Şifre</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password">Yeni Şifre</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password_confirmation">Yeni Şifre Onayla</label>
                                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Şifre Değiştir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

  <!-- script eklentileri -->
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-title {
    color: #333;
}

.form-group {
    margin-bottom: 1.5rem;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

    .form-group label {
        font-size: 1.1em;
        color: #495057;
    }

    .form-control {
        border-radius: 4px;
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

  </style>



