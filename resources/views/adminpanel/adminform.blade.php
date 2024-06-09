<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Tanerk Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('/')}}admin/vendors/feather/feather.css">
  <link rel="stylesheet" href="{{asset('/')}}admin/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="{{asset('/')}}admin/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('/')}}admin/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('/')}}img/tanerkmini.png" />
  <style>
    .error-message {
      color: red;
      font-weight: bold;
      font-size: 1.1em;
      margin-top: 10px;
    }
    .brand-logo img {
      max-width: 200px;
      height: auto;
    }
    .auth-form-light {
      background-color: #f8f9fa;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .auth-form-light h4 {
      margin-bottom: 20px;
    }
    .auth-form-light h6 {
      margin-bottom: 30px;
    }
    .auth-form-light .form-group {
      margin-bottom: 20px;
    }
    .auth-form-light .btn {
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-6 mx-auto">
            <div class="auth-form-light text-left py-5 px-4">
              <div class="brand-logo text-center">
                <img src="{{asset('/')}}img/tanerkadmin.png" alt="logo">
              </div>
              <h4 class="text-center">Admin Oluştur</h4>
              <h6 class="font-weight-light text-center">Yeni Admin eklemek çok basit. Sadece birkaç dakikanızı alacak.</h6>
              <form class="pt-3" method="POST" action="{{ route('admin.ekle') }}" onsubmit="return validateForm()">
                @csrf
                @if(session('email'))
                <div class="alert alert-danger">
                  {{ session('email') }}
                </div>
                @endif
                @if(session('phoneNumber'))
                <div class="alert alert-danger">
                  {{ session('phoneNumber') }}
                </div>
                @endif
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="surname" name="surname" placeholder="Surname">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="phoneNumber" name="phoneNumber" placeholder="Phone Number">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="reg-password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                  <input class="form-control form-control-lg" type="password" name="password_confirmation" id="password-confirm" placeholder="Confirm Password">
                  <div id="password-mismatch" class="error-message" style="display: none;">Şifreler eşleşmiyor.</div>
                </div>
                <div class="mb-4">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input" required>
                      I agree to all Terms & Conditions
                    </label>
                  </div>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">ADMİN OLUŞTUR</button>
                  <button type="button" class="btn btn-block btn-secondary btn-lg font-weight-medium auth-form-btn" onclick="history.back()">İPTAL</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
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
  <script>
    function validateForm() {
      var password = document.getElementById("reg-password").value;
      var confirmPassword = document.getElementById("password-confirm").value;
      var passwordMismatchMessage = document.getElementById("password-mismatch");

      if (password !== confirmPassword) {
        passwordMismatchMessage.style.display = "block";
        return false; // Prevent form submission
      } else {
        passwordMismatchMessage.style.display = "none";
        return true; // Submit the form
      }
    }
  </script>
</body>

</html>
