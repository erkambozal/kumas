<footer class="footer bg-dark pt-5">
  <div class="px-lg-3 pt-2 pb-4">
    <div class="mx-auto px-3" style="max-width: 80rem;">
      <div class="row mobilStyle">

        <div class="col-xl-3 col-lg-4 col-sm-4 mx-1">
          <div class="widget widget-links widget-light pb-2 mb-4">
            <h3 class="widget-title text-light">Kategorilerimiz</h3>
            <ul class="widget-list">
              @foreach ($categories as $category)
              @if ($category->cat_ust == null)
              <li class="widget-list-item"><a class="widget-list-link" href="{{ route('categoryproducts', $category->name) }}">{{$category->name}}</a></li>
              @endif
              @endforeach


            </ul>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-4">
          <div class="widget widget-links widget-light pb-2 mb-4">
            <h3 class="widget-title text-light">Kurumsal</h3>
            <ul class="widget-list">
              <li class="widget-list-item"><a class="widget-list-link" href="{{ route('hakkimizda') }}">Hakkımızda</a></li>
              <li class="widget-list-item"><a class="widget-list-link" href="{{ route('gizlilik') }}">Gizlilik ve Güvenlik</a></li>
              <li class="widget-list-item"><a class="widget-list-link" href="{{ route('sartlarVeKosullar') }}">Şartlar ve Koşullar</a></li>
              <li class="widget-list-item"><a class="widget-list-link" href="{{ route('iletisim') }}">İletişim</a></li>
            </ul>
          </div>
          <div class="widget widget-light pb-2 mb-4">
            <h3 class="widget-title text-light">Sosyal Medya</h3><a class="btn-social bs-light bs-twitter me-2 mb-2" href="#"><i class="ci-twitter"></i></a><a class="btn-social bs-light bs-facebook me-2 mb-2" href="#"><i class="ci-facebook"></i></a><a class="btn-social bs-light bs-instagram me-2 mb-2" href="#"><i class="ci-instagram"></i></a><a class="btn-social bs-light bs-youtube me-2 mb-2" href="#"><i class="ci-youtube"></i></a>
          </div>
        </div>
        <div class="col-xl-4 col-sm-8">
          <div class="widget pb-2 mb-4">
            <h3 class="widget-title text-light pb-1">Abone Ol</h3>
            <form class="subscription-form validate" action="https://studio.us12.list-manage.com/subscribe/post?u=c7103e2c981361a6639545bd5&amp;amp;id=29ca296126" method="post" name="mc-embedded-subscribe-form" target="_blank" novalidate>
              <div class="input-group flex-nowrap"><i class="ci-mail position-absolute top-50 translate-middle-y text-muted fs-base ms-3"></i>
                <input class="form-control rounded-start" type="email" name="EMAIL" placeholder="Email adresiniz" required>
                <button class="btn btn-primary" type="submit" name="subscribe">Abone Ol</button>
              </div>
              <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
              <div style="position: absolute; left: -5000px;" aria-hidden="true">
                <input class="subscription-form-antispam" type="text" name="b_c7103e2c981361a6639545bd5_29ca296126" tabindex="-1">
              </div>
              <div class="form-text text-light opacity-50">*Yeni ürünlerden, kampanyalardan haberdan olmak için abone ol.</div>
              <div class="subscription-status"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-darker px-lg-3 py-3">
    <div class="d-sm-flex justify-content-between align-items-center mx-auto px-3" style="max-width: 80rem;">
      <div class="fs-xs text-light opacity-50 text-center text-sm-start py-3">© All rights reserved. Made by <a class="text-light" href="#" target="_blank" rel="noopener">Tanerk Kumas</a></div>
      <div class="py-3"><img class="d-block mx-auto mx-sm-start" src="img/cards-alt.png" width="187" alt="Payment methods"></div>
    </div>
  </div>
</footer>
