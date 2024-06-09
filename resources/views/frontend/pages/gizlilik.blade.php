@extends('frontend.layout.layout')

@section('content')
<section class="container pt-5 pb-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-0 shadow">
        <div class="card-body p-5">
          <h2 class="h4 mb-4 text-center">Gizlilik ve Güvenlik</h2>
          <div class="mb-4">
            <p class="text-muted">Tanerk Kumaş olarak, müşterilerimizin gizliliğini ve güvenliğini en üst düzeyde korumak için çalışıyoruz. Bu Gizlilik ve Güvenlik Politikası, kişisel verilerinizin nasıl toplandığını, kullanıldığını, saklandığını ve korunduğunu açıklamaktadır.</p>
          </div>
          <hr>

          <h3 class="fs-base pt-4 pb-2">Toplanan Bilgiler</h3>
          <p class="text-muted">Kişisel veriler, siz müşterilerimiz tarafından sağlanan bilgilerdir ve bunlar şunları içerebilir:</p>
          <ul class="list-unstyled text-muted">
            <li><i class="ci-check me-2"></i>Ad ve Soyad</li>
            <li><i class="ci-check me-2"></i>İletişim Bilgileri (e-posta adresi, telefon numarası)</li>
            <li><i class="ci-check me-2"></i>Adres Bilgileri</li>
            <li><i class="ci-check me-2"></i>Ödeme Bilgileri</li>
            <li><i class="ci-check me-2"></i>IP Adresi ve Tarayıcı Bilgileri</li>
          </ul>

          <hr>
          <h3 class="fs-base pt-4 pb-2">Bilgilerin Kullanımı</h3>
          <p class="text-muted">Topladığımız kişisel veriler, şu amaçlarla kullanılabilir:</p>
          <ul class="list-unstyled text-muted">
            <li><i class="ci-check me-2"></i>Siparişlerinizi işleme koymak ve teslim etmek</li>
            <li><i class="ci-check me-2"></i>Müşteri hizmetleri sağlamak</li>
            <li><i class="ci-check me-2"></i>Sitenin kullanımını analiz etmek ve geliştirmek</li>
            <li><i class="ci-check me-2"></i>Promosyon ve kampanyalar hakkında bilgilendirme yapmak</li>
            <li><i class="ci-check me-2"></i>Yasal yükümlülükleri yerine getirmek</li>
          </ul>

          <hr>
          <h3 class="fs-base pt-4 pb-2">Bilgilerin Paylaşımı</h3>
          <p class="text-muted">Kişisel verileriniz, üçüncü şahıslarla şu durumlarda paylaşılabilir:</p>
          <ul class="list-unstyled text-muted">
            <li><i class="ci-check me-2"></i>Siparişlerin teslimatı için lojistik firmaları</li>
            <li><i class="ci-check me-2"></i>Ödeme işlemleri için finansal kuruluşlar</li>
            <li><i class="ci-check me-2"></i>Hukuki gereklilikler doğrultusunda resmi merciler</li>
          </ul>

          <hr>
          <h3 class="fs-base pt-4 pb-2">Veri Güvenliği</h3>
          <p class="text-muted">Tanerk Kumaş olarak, kişisel verilerinizi korumak için gerekli teknik ve idari önlemleri almaktayız. Verilerinizin yetkisiz erişim, kayıp veya kötüye kullanımını önlemek amacıyla güvenlik duvarları, şifreleme teknolojileri ve diğer güvenlik önlemleri kullanmaktayız.</p>

          <hr>
          <h3 class="fs-base pt-4 pb-2">Çerezler (Cookies)</h3>
          <p class="text-muted">Sitemizin işlevselliğini artırmak ve kullanıcı deneyimini iyileştirmek amacıyla çerezler kullanmaktayız. Çerezler, tarayıcınıza gönderilen ve cihazınızda saklanan küçük veri dosyalarıdır. Çerezleri kullanarak, sitemizi nasıl kullandığınızı anlayabilir ve size daha iyi hizmet sunabiliriz.</p>
          
          <hr>
          <h3 class="fs-base pt-4 pb-2">Haklarınız</h3>
          <p class="text-muted">Kişisel verilerinize ilişkin olarak şu haklara sahipsiniz:</p>
          <ul class="list-unstyled text-muted">
            <li><i class="ci-check me-2"></i>Bilgi talep etme</li>
            <li><i class="ci-check me-2"></i>Verilerinize erişim talep etme</li>
            <li><i class="ci-check me-2"></i>Verilerinizi düzeltme veya güncelleme</li>
            <li><i class="ci-check me-2"></i>Verilerinizin silinmesini talep etme</li>
            <li><i class="ci-check me-2"></i>Veri işleme faaliyetlerine itiraz etme</li>
          </ul>

          <hr>
          <h3 class="fs-base pt-4 pb-2">İletişim</h3>
          <p class="text-muted">Gizlilik ve Güvenlik Politikamız hakkında sorularınız varsa veya haklarınızı kullanmak isterseniz, bizimle iletişime geçebilirsiniz:</p>
          <ul class="list-unstyled text-muted">
            <li><strong>Telefon:</strong> +90 544 226 64 16</li>
            <li><strong>E-posta:</strong> info@tanerk.com</li>
            <li><strong>Adres:</strong> Başak Mah. Yunus Emre Cad. Başakşehir – İstanbul / TÜRKİYE</li>
          </ul>

          <hr>
          <div class="text-end pt-4">
            <button class="btn btn-primary" type="button" onclick="window.location.href='{{ url('/') }}'"><i class="ci-arrow-left me-2 ms-n21"></i>Ana Sayfaya Dön</button>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
