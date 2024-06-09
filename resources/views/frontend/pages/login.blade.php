@extends('frontend.layout.layout')

@section('content')
<section class="ps-lg-4 pe-lg-3 pt-4">
<div class="row pt-5 pb-5">
    <div class="col-md-6">
      <div class="card border-0 shadow">
        <div class="card-body">
          <h2 class="h4 mb-1">Giriş Yap</h2>
          <div class="py-3">
          </div>
          <hr>
          <h3 class="fs-base pt-4 pb-2">Giriş Bilgileri</h3>
          <form action="{{route("userLogin")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-3"><i class="ci-mail position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
              <input class="form-control rounded-start" type="email" placeholder="Email" name="email" required>
            </div>
            <div class="input-group mb-3"><i class="ci-locked position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
              <div class="password-toggle w-100">
                <input class="form-control" type="password" name="password" placeholder="Şifre" required style="width: 100%;">
                <label class="password-toggle-btn" aria-label="Show/hide password">
                  <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                </label>
              </div>
            </div>
            <!--<div class="d-flex flex-wrap justify-content-between">
              <div class="form-check">
              </div><a class="nav-link-inline fs-sm" href="account-password-recovery.html">Şifreni Mi Unuttun?</a>
            </div>-->
            <hr class="mt-4">
            <div class="text-end pt-4">
              <button class="btn btn-primary" type="submit"><i class="ci-sign-in me-2 ms-n21"></i>Giriş Yap</button>
            </div>
          </form>
      
          @if(session('login'))
          <div class="alert alert-danger">
              {{ session('login') }}
                 </div>
                 @endif

        </div>
      </div>
    </div>
    <div class="col-md-6 pt-4 mt-3 mt-md-0">
      <h2 class="h4 mb-3">Hesabın yok mu? Kayıt ol</h2>
      <p class="fs-sm text-muted mb-4">Kayıt ol ve birbirinden güzel ürünlerimize sahip ol.</p>
      <form action="{{route("createUser")}}" method="post" onsubmit="return validateForm()">
        @csrf <!-- CSRF koruması için Laravel'den gelen özel işareti ekleyin -->
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
        <div class="row gx-4 gy-3">
          <div class="col-sm-6">
            <label class="form-label" for="reg-fn">İsim</label>
            <input class="form-control" type="text" name="name" required id="reg-fn">
            <div class="invalid-feedback">Lütfen isim giriniz!</div>
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="reg-ln">Soyisim</label>
            <input class="form-control" type="text"name="surname" required id="reg-ln">
            <div class="invalid-feedback">Lütfen soyisim giriniz!</div>
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="reg-email">E-mail Adresi</label>
            <input class="form-control" type="email"name="email" required id="reg-email">
            <div class="invalid-feedback">Lütfen geçerli bir mail adresi girin!</div>
          </div>
          <div class="col-sm-6">
    <label class="form-label" for="reg-phone">Telefon Numarası</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">+90</span> <!-- Alan kodunu burada ekledik -->
        </div>
        <input class="form-control" type="text" name="phoneNumber" required id="reg-phone">
        <div class="invalid-feedback">Lütfen telefon numaranızı girin!</div>
    </div>
</div>
          <div class="col-sm-6">
            <label class="form-label" for="reg-password">Şifre</label>
            <input class="form-control" type="password" name="password" required id="reg-password">
            <div class="invalid-feedback">Lütfen şifreni gir!</div>
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="password-confirm">Şifre Doğrula</label>
            <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
            <div id="password-mismatch" class="error-message" style="display: none;">Şifreler eşleşmiyor.</div>
          </div>
          <div class="col-12 text-end">
            <button class="btn btn-primary" type="submit"><i class="ci-user me-2 ms-n1"></i>Kayıt ol</button>
          </div>
        </div>
      </form>
      @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
      @endif
    </div>
  </div>
</section>
  @endsection


  <script>
    function validateForm() {
        var password = document.getElementById("reg-password").value;
        var confirmPassword = document.getElementById("password-confirm").value;
        var passwordMismatchMessage = document.getElementById("password-mismatch");

        if (password !== confirmPassword) {
            document.getElementById("password-mismatch").style.display = "block";
            return false; // Prevent form submission
        } else {
            document.getElementById("password-mismatch").style.display = "none";
            return true; // Submit the form
        }
    }
</script>
<style>
    .error-message {
      display: none;
      color: #d9534f; /* Red color for error message */
      font-size: 14px;
      margin-top: 5px;
    }
  </style>