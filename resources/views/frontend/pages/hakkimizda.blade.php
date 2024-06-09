@extends('frontend.layout.layout')

@section('content')
<section class="container pt-5 pb-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-0 shadow">
        <div class="card-body p-5">
          <h2 class="h4 mb-4 text-center">Hakkımızda</h2>
          <div class="mb-4">
            <p class="text-muted">Tanerk Kumaş olarak, moda ve tekstil dünyasına tutkumuzla yola çıktık. Yüksek kaliteli kumaşları siz değerli müşterilerimizle buluşturmak amacıyla kurulan şirketimiz, yılların verdiği tecrübe ve güvenle hizmet vermektedir.</p>
          </div>
          <hr>

          <h3 class="fs-base pt-4 pb-2">Hikayemiz</h3>
          <p class="text-muted">2010 yılında, İstanbul'un kalbinde küçük bir atölyede başladık. Başlangıçta yerel müşterilere hizmet verirken, zamanla kalite ve müşteri memnuniyetine verdiğimiz önem sayesinde büyüdük ve uluslararası bir marka haline geldik. Şimdi, en iyi kumaşları dünya genelindeki müşterilerimize sunmanın gururunu yaşıyoruz.</p>
          
          <hr>
          <h3 class="fs-base pt-4 pb-2">Misyonumuz</h3>
          <p class="text-muted">Misyonumuz, müşterilerimize en yüksek kalitede kumaşları en uygun fiyatlarla sunmaktır. Modayı ve kaliteyi bir araya getirerek, her projeye özel çözümler üretmekteyiz. Müşterilerimizin hayallerini gerçekleştirmelerine yardımcı olmak en büyük hedefimizdir.</p>
          
          <hr>
          <h3 class="fs-base pt-4 pb-2">Vizyonumuz</h3>
          <p class="text-muted">Vizyonumuz, tekstil sektöründe lider bir marka olarak tanınmak ve dünya çapında en çok tercih edilen kumaş tedarikçisi olmaktır. Sürekli yenilik ve gelişim ile sektörde fark yaratmak için çalışıyoruz.</p>
          
          <hr>
          <h3 class="fs-base pt-4 pb-2">Değerlerimiz</h3>
          <ul class="list-unstyled text-muted">
            <li><strong>Kalite:</strong> En iyi hammaddeleri kullanarak, yüksek kaliteli ürünler sunuyoruz.</li>
            <li><strong>Güven:</strong> Müşterilerimizin güvenini kazanmak için şeffaflık ve dürüstlükle çalışıyoruz.</li>
            <li><strong>İnovasyon:</strong> Sürekli olarak yeni trendleri ve teknolojileri takip ederek, ürün yelpazemizi geliştiriyoruz.</li>
            <li><strong>Müşteri Memnuniyeti:</strong> Müşterilerimizin ihtiyaç ve beklentilerini her zaman ön planda tutuyoruz.</li>
          </ul>
          
          <hr>
          <h3 class="fs-base pt-4 pb-2">Ürünlerimiz</h3>
          <p class="text-muted">Çeşitli kumaş seçeneklerimizle her türlü ihtiyaca uygun çözümler sunuyoruz:</p>
          <ul class="list-unstyled text-muted">
            <li><strong>Pamuklu Kumaşlar:</strong> Doğal ve nefes alabilen seçenekler.</li>
            <li><strong>İpek Kumaşlar:</strong> Lüks ve zarif dokunuşlar.</li>
            <li><strong>Polyester Kumaşlar:</strong> Dayanıklı ve uzun ömürlü alternatifler.</li>
            <li><strong>Dantel Kumaşlar:</strong> Şık ve estetik detaylar.</li>
          </ul>
          
          <hr>
          <h3 class="fs-base pt-4 pb-2">Ekibimiz</h3>
          <p class="text-muted">Tanerk Kumaş ekibi, tekstil ve moda sektöründe deneyimli profesyonellerden oluşmaktadır. Her biri kendi alanında uzman olan çalışanlarımız, en iyi hizmeti sunmak için büyük bir özveri ile çalışmaktadır.</p>
          
          <hr>
          <h3 class="fs-base pt-4 pb-2">İletişim</h3>
          <p class="text-muted">Her türlü soru ve ihtiyaçlarınız için bizimle iletişime geçmekten çekinmeyin. Sizi mağazamızda ağırlamaktan ve projelerinize ilham vermekten mutluluk duyarız.</p>
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
