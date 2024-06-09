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
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="card-title">En Çok Satan Ürünler</p>
                            </div>
                            <p class="font-weight-500">
                              En çok satan ürünlerini görüyorsun. Stoklarına dikkat et!
                            </p>
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="card-title">İptal-İade Ürün Grafiği</p>
                            </div>
                            <p class="font-weight-500">
                              Daha hızlı gelişmek için tablodaki ürünlerin kalitesine dikkat et.
                            </p>
                            <canvas id="cancelledReturnedProductsChart"></canvas>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
          <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="card-title">Haftalık Satışlar</p>
                    </div>
                    <canvas id="weeklySalesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
              <div class="card-body">
                  <div class="d-flex justify-content-between">
                      <p class="card-title">Aylık Satışlar</p>
                  </div>
                  <canvas id="monthlySalesChart"></canvas>
              </div>
          </div>
      </div>

        </div>
    </div>
</div>
{{-- içerik bitimi --}}

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
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
  </body>
  
  </html>
  <script>
    document.addEventListener('DOMContentLoaded', function() {

        fetch('/top-selling-products')
            .then(response => response.json())
            .then(data => {
                const labels = Object.keys(data);
                const counts = Object.values(data);

                const ctx = document.getElementById('topProductsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)',
                                'rgba(201, 203, 207, 0.7)',
                                'rgba(100, 149, 237, 0.7)',
                                'rgba(255, 182, 193, 0.7)',
                                'rgba(144, 238, 144, 0.7)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(201, 203, 207, 1)',
                                'rgba(100, 149, 237, 1)',
                                'rgba(255, 182, 193, 1)',
                                'rgba(144, 238, 144, 1)',
                            ],
                            borderWidth: 1,
                            hoverOffset: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Top Selling Products',
                                font: {
                                    size: 18
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        return `${label}: ${value} sales`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
            });
    });
    
    fetch('/cancelled-returned-products')
            .then(response => response.json())
            .then(data => {
                const labels = Object.keys(data);
                const counts = Object.values(data);

                const ctx = document.getElementById('cancelledReturnedProductsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                                'rgba(255, 159, 64, 0.7)',
                                'rgba(201, 203, 207, 0.7)',
                                'rgba(100, 149, 237, 0.7)',
                                'rgba(255, 182, 193, 0.7)',
                                'rgba(144, 238, 144, 0.7)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(201, 203, 207, 1)',
                                'rgba(100, 149, 237, 1)',
                                'rgba(255, 182, 193, 1)',
                                'rgba(144, 238, 144, 1)',
                            ],
                            borderWidth: 1,
                            hoverOffset: 20
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Top Cancelled/Returned Products',
                                font: {
                                    size: 18
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        return `${label}: ${value} units`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
            });
                
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      // Function to format date to DD-MM-YYYY
      function formatDateToDDMMYYYY(date) {
          return moment(date).format('DD-MM-YYYY');
      }

      // Fetch weekly sales data
      fetch('/weekly-sales')
          .then(response => response.json())
          .then(data => {
              const dates = data.map(entry => formatDateToDDMMYYYY(entry.date));
              const totals = data.map(entry => entry.total);

              const ctx = document.getElementById('weeklySalesChart').getContext('2d');
              new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: dates,
                      datasets: [{
                          label: 'Toplam Satış Miktarı (₺)',
                          data: totals,
                          backgroundColor: 'rgba(54, 162, 235, 0.2)',
                          borderColor: 'rgba(54, 162, 235, 1)',
                          borderWidth: 1,
                          fill: true,
                      }]
                  },
                  options: {
                      responsive: true,
                      plugins: {
                          legend: {
                              position: 'top',
                          },
                          title: {
                              display: true,
                              text: 'Weekly Sales'
                          }
                      },
                      scales: {
                          x: {
                              type: 'category',
                              time: {
                                  unit: 'day'
                              }
                          },
                          y: {
                              beginAtZero: true
                          }
                      }
                  }
              });
          });

      // Fetch monthly sales data
      fetch('/monthly-sales')
          .then(response => response.json())
          .then(data => {
              const dates = data.map(entry => formatDateToDDMMYYYY(entry.date));
              const totals = data.map(entry => entry.total);

              const ctx = document.getElementById('monthlySalesChart').getContext('2d');
              new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: dates,
                      datasets: [{
                          label: 'Toplam Satış Miktarı (₺)',
                          data: totals,
                          backgroundColor: 'rgba(255, 99, 132, 0.2)',
                          borderColor: 'rgba(255, 99, 132, 1)',
                          borderWidth: 1,
                          fill: true,
                      }]
                  },
                  options: {
                      responsive: true,
                      plugins: {
                          legend: {
                              position: 'top',
                          },
                          title: {
                              display: true,
                              text: 'Monthly Sales'
                          }
                      },
                      scales: {
                          x: {
                              type: 'category',
                              time: {
                                  unit: 'day'
                              }
                          },
                          y: {
                              beginAtZero: true
                          }
                      }
                  }
              });
          });
  });
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
.chart-container {
            position: relative;
            height: 400px;
        }
        canvas {
            display: block;
            max-width: 100%;
        }
    </style>
  