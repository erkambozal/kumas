@extends('frontend.layout.layout')

@section('content')
<section class="container pt-5 pb-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card border-0 shadow">
        <div class="card-body p-5">
          <h2 class="h4 mb-4 text-center">Bizimle İletişime Geçin</h2>
          <div class="mb-4 text-center">
            <p class="text-muted">Herhangi bir sorunuz, geri bildiriminiz veya öneriniz varsa lütfen bizimle iletişime geçmekten çekinmeyin. Size yardımcı olmaktan memnuniyet duyarız.</p>
          </div>
          <hr>

          <div class="row">
            <div class="col-md-6 mb-4">
              <h3 class="fs-base pb-2">İletişim Bilgilerimiz</h3>
              <ul class="list-unstyled">
                <li><strong>Telefon:</strong> +90 544 226 64 16</li>
                <li><strong>E-posta:</strong> info@tanerk.com</li>
                <li><strong>Adres:</strong> Başak Mah. Yunus Emre Cad. Başakşehir – İstanbul / TÜRKİYE</li>
              </ul>
            </div>
            <div class="col-md-6 mb-4">
              <h3 class="fs-base pb-2">Çalışma Saatlerimiz</h3>
              <ul class="list-unstyled">
                <li><strong>Pazartesi - Cuma:</strong> 09:00 - 20:00</li>
                <li><strong>Cumartesi:</strong> 10:00 - 19:00</li>
                <li><strong>Pazar:</strong> 10:00 - 19:00</li>
              </ul>
            </div>
          </div>

          <hr>

          <h3 class="fs-base pt-4 pb-2 text-center">Konumumuz</h3>
          <!-- Google Maps iframe -->
          <div class="ratio ratio-16x9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d243647.46477507444!2d28.872097659093157!3d41.00549583296188!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caba1b64d45b75%3A0x1e0f27d7c69d2c0!2sBaşakşehir%2C%20İstanbul%2C%20Türkiye!5e0!3m2!1str!2sus!4v1621345663582!5m2!1str!2sus" width="100%" height="auto" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
