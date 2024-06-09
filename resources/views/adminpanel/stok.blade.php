<!DOCTYPE html>
<html lang="en">
  <?php

  use Illuminate\Support\Facades\Auth;
  
  ?>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
      <!-- İçerik -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-3">Stok Durumu</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th>ID</th>
                                      <th>Ürün Adı</th>
                                      <th>Stok</th>
                                      <th>Ücret</th>
                                      <th>Stok Durumu &amp; Güncelle</th> <!-- Güncelle butonunu ekleyin --> 
                                    </tr>  
                                  </thead>
                                  <tbody>
                                    @foreach($products as $product)
                                    <tr data-product-id="{{$product->id}}" class="admin-detail-link">
                                      <td>{{$product->id}}</td>
                                      <td>{{$product->name}}</td>
                                      <td>{{$product->qty}}</td>
                                      <td>{{$product->price}}</td>
                                      <td style="position: relative;">
                                        <span class="badge 
                                            @if($product->qty == 0)
                                                badge-danger
                                            @elseif($product->qty <= 30)
                                                badge-warning
                                            @else
                                                badge-success
                                            @endif">
                                            @if($product->qty == 0)
                                                Stokta Yok
                                            @elseif($product->qty <= 30)
                                                Stok Sayısı Az
                                            @else
                                                Yeterli Stok
                                            @endif
                                        </span>
                                        <button class="update-btn" onclick="showQuantityInput({{$product->id}}, {{$product->qty}})" style="position: absolute; right: 50px;">Güncelle</button>
                                        <div id="quantity-input-{{$product->id}}" class="quantity-input" style="display: none;">
                                            <button onclick="decreaseQuantity({{$product->id}})">-</button>
                                            <input type="number" id="quantity-{{$product->id}}" value="{{$product->qty}}" min="0">
                                            <button onclick="increaseQuantity({{$product->id}})">+</button>
                                            <button onclick="stokGuncelle({{$product->id}})">Tamam</button>
                                        </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                              
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="d-flex justify-content-center">
                        {{ $products->links('vendor.pagination.bootstrap-4') }}
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
<script>
    function showQuantityInput(productId, currentQty) {
      // Input alanını göster ve mevcut miktarı input alanına yaz
      document.getElementById('quantity-input-' + productId).style.display = 'inline-flex';
      document.getElementById('quantity-' + productId).value = currentQty;
    }

    function decreaseQuantity(productId) {
      // Miktarı azalt
      var quantityInput = document.getElementById('quantity-' + productId);
      if (parseInt(quantityInput.value) > 0) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
      }
    }

    function increaseQuantity(productId) {
      // Miktarı artır
      var quantityInput = document.getElementById('quantity-' + productId);
      quantityInput.value = parseInt(quantityInput.value) + 1;
    }

    function stokGuncelle(productId) {
    // Miktarı güncelleme işlemi
    var newQty = document.getElementById('quantity-' + productId).value;
    console.log('Ürün ID: ' + productId + ', Yeni Stok: ' + newQty);
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
$.ajax({
    url: '/stokguncelle/' + productId,
    type: 'POST',
    headers: {
        'X-CSRF-TOKEN': csrfToken
    },
    data: {
        productId: productId,
        newQty: newQty
    },
    success: function(response) {
    // Başarılı yanıt
    console.log(response);
    // Burada gelen yanıta göre gerekli işlemleri yapabilirsiniz
    document.getElementById('quantity-input-' + productId).style.display = 'none';
    // Tabloyu yenileme işlemi
    location.reload();
},
    error: function(xhr, status, error) {
        // Hata durumu
        console.error(xhr.responseText);
        // Hata durumunda kullanıcıya bildirim gösterebilirsiniz
        alert('Bir hata oluştu. Lütfen tekrar deneyin.');
    }
});
} 

</script>

	
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
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .card-title {
      color: #343a40;
      font-weight: bold;
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
.table {
  width: 100%;
  margin-bottom: 1rem;
  background-color: #fff;
  border-collapse: collapse;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-primary,
.table-primary > th,
.table-primary > td {
  background-color: #b8daff;
}

.table-hover .table-primary:hover {
  background-color: #9fcdff;
}

.table-hover .table-primary:hover > td,
.table-hover .table-primary:hover > th {
  background-color: #9fcdff;
}

.table-secondary,
.table-secondary > th,
.table-secondary > td {
  background-color: #d6d8db;
}

.table-hover .table-secondary:hover {
  background-color: #c8cbcf;
}

.table-hover .table-secondary:hover > td,
.table-hover .table-secondary:hover > th {
  background-color: #c8cbcf;
}

.table-success,
.table-success > th,
.table-success > td {
  background-color: #c3e6cb;
}

.table-hover .table-success:hover {
  background-color: #b1dfbb;
}

.table-hover .table-success:hover > td,
.table-hover .table-success:hover > th {
  background-color: #b1dfbb;
}

.table-info,
.table-info > th,
.table-info > td {
  background-color: #bee5eb;
}

.table-hover .table-info:hover {
  background-color: #abdde5;
}

.table-hover .table-info:hover > td,
.table-hover .table-info:hover > th {
  background-color: #abdde5;
}

.table-warning,
.table-warning > th,
.table-warning > td {
  background-color: #ffeeba;
}

.table-hover .table-warning:hover {
  background-color: #ffe8a1;
}

.table-hover .table-warning:hover > td,
.table-hover .table-warning:hover > th {
  background-color: #ffe8a1;
}

.table-danger,
.table-danger > th,
.table-danger > td {
  background-color: #f5c6cb;
}

.table-hover .table-danger:hover {
  background-color: #f1b0b7;
}

.table-hover .table-danger:hover > td,
.table-hover .table-danger:hover > th {
  background-color: #f1b0b7;
}

.table-light,
.table-light > th,
.table-light > td {
  background-color: #fdfdfe;
}

.table-hover .table-light:hover {
  background-color: #ececf6;
}

.table-hover .table-light:hover > td,
.table-hover .table-light:hover > th {
  background-color: #ececf6;
}

.table-dark,
.table-dark > th,
.table-dark > td {
  background-color: #c6c8ca;
}

.table-hover .table-dark:hover {
  background-color: #b9bbbe;
}

.table-hover .table-dark:hover > td,
.table-hover .table-dark:hover > th {
  background-color: #b9bbbe;
}

.table-active,
.table-active > th,
.table-active > td {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover > td,
.table-hover .table-active:hover > th {
  background-color: rgba(0, 0, 0, 0.075);
}

.table .thead-dark th {
  color: #fff;
  background-color: #343a40;
  border-color: #454d55;
}

.table .thead-light th {
  color: #495057;
  background-color: #e9ecef;
  border-color: #dee2e6;
}

.table-dark {
  color: #fff;
  background-color: #343a40;
}

.table-dark th,
.table-dark td,
.table-dark thead th {
  border-color: #454d55;
}

.table-dark.table-bordered {
  border: 0;
}

.table-dark.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(255, 255, 255, 0.05);
}

.table-dark.table-hover tbody tr:hover {
  background-color: rgba(255, 255, 255, 0.075);
}
/* Güncelle butonu */
.update-btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    font-size: 14px;
    font-weight: bold;
}

.update-btn:hover {
    background-color: #0056b3;
}

/* Artırma ve azaltma butonları */
.quantity-btn {
    padding: 6px 10px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.quantity-btn:hover {
    background-color: #218838;
}

.quantity-input button {
    padding: 6px 10px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.quantity-input button:hover {
    background-color: #218838;
}

/* Açılan input alanının genişliğini düzeltme */
.quantity-input input[type="number"] {
    width: 60px; /* İstenilen genişliği ayarlayın */
}

/* Yukarı Aşağı Okları Gizleme */
.quantity-input input[type="number"]::-webkit-inner-spin-button,
.quantity-input input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-input input[type="number"] {
    -moz-appearance: textfield;
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
