@extends('frontend.layout.layout')

@section('content')
<section class="container pt-5 pb-5">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card border-0 shadow">
        <div class="card-body p-5">
          <h2 class="h4 mb-4 text-center">Şartlar ve Koşullar</h2>
          <div class="mb-4">
            <p class="text-muted">Bu web sitesine erişerek ve kullanarak, aşağıdaki şartlar ve koşulları kabul etmiş olursunuz. Lütfen dikkatle okuyun.</p>
          </div>
          <hr>

          <h3 class="fs-base pt-4 pb-2">1. Genel</h3>
          <p class="text-muted">Bu web sitesi, Tanerk Kumaş tarafından işletilmektedir. Siteye erişim ve kullanımınız, aşağıdaki şartlar ve koşullara tabidir. Bu şartlar ve koşullar, zaman zaman güncellenebilir ve değişiklikler yayınlandığında yürürlüğe girer.</p>

          <hr>
          <h3 class="fs-base pt-4 pb-2">2. Kullanım Koşulları</h3>
          <p class="text-muted">Bu siteyi yalnızca yasal amaçlarla ve aşağıdaki koşullara uygun olarak kullanmayı kabul edersiniz:</p>
          <ul class="list-unstyled text-muted">
            <li><i class="ci-check me-2"></i>Yasa dışı, zararlı, tehdit edici, taciz edici, iftira niteliğinde, müstehcen veya başka şekilde sakıncalı içerik göndermemek veya iletmemek.</li>
            <li><i class="ci-check me-2"></i>Başka bir kişinin gizliliğini ihlal edecek bilgi toplamamak veya yaymamak.</li>
            <li><i class="ci-check me-2"></i>Siteye zarar verebilecek veya siteye müdahale edebilecek virüs veya diğer zararlı kodlar göndermemek.</li>
            <li><i class="ci-check me-2"></i>Siteye yetkisiz erişim sağlamaya çalışmamak.</li>
          </ul>

          <hr>
          <h3 class="fs-base pt-4 pb-2">3. Fikri Mülkiyet</h3>
          <p class="text-muted">Bu sitedeki tüm içerik, Tanerk Kumaş'a veya içerik sağlayıcılarına aittir ve telif hakkı, ticari marka ve diğer fikri mülkiyet yasaları ile korunmaktadır. İçerikler, Tanerk Kumaş'ın yazılı izni olmaksızın kopyalanamaz, yeniden üretilemez veya dağıtılamaz.</p>

          <hr>
          <h3 class="fs-base pt-4 pb-2">4. Siparişler ve Ödemeler</h3>
          <p class="text-muted">Sitemiz üzerinden verilen tüm siparişler, stok durumuna ve onaya tabidir. Siparişinizi verdikten sonra, ödeme bilgileriniz doğrulanacak ve siparişiniz işleme alınacaktır. Tanerk Kumaş, herhangi bir siparişi reddetme veya iptal etme hakkını saklı tutar.</p>

          <hr>
          <h3 class="fs-base pt-4 pb-2">5. İade ve İptal Politikası</h3>
          <p class="text-muted">İade ve iptal politikamız, müşteri memnuniyetini sağlamak amacıyla oluşturulmuştur.</p>

          <hr>
          <h3 class="fs-base pt-4 pb-2">6. Gizlilik</h3>
          <p class="text-muted">Gizliliğinizi korumak için çaba sarf ediyoruz. Kişisel verilerinizin nasıl toplandığı, kullanıldığı ve korunduğu hakkında daha fazla bilgi için Gizlilik ve Güvenlik Politikası sayfamızı inceleyebilirsiniz.</p>

          <hr>
          <h3 class="fs-base pt-4 pb-2">7. Sorumluluk Reddi</h3>
          <p class="text-muted">Bu site ve içerikleri "olduğu gibi" sağlanmaktadır. Tanerk Kumaş, site içeriğinin doğruluğu, eksiksizliği veya güncelliği konusunda herhangi bir garanti vermez. Siteyi kullanmanızdan doğabilecek her türlü zarardan siz sorumlusunuz.</p>

          <hr>
          <h3 class="fs-base pt-4 pb-2">8. Değişiklikler</h3>
          <p class="text-muted">Tanerk Kumaş, bu şartlar ve koşulları herhangi bir zamanda değiştirme hakkını saklı tutar. Yapılan değişiklikler, yayınlandığı tarihten itibaren geçerli olacaktır. Bu nedenle, şartları ve koşulları düzenli olarak kontrol etmenizi öneririz.</p>

          <hr>
          <h3 class="fs-base pt-4 pb-2">9. İletişim</h3>
          <p class="text-muted">Şartlar ve koşullar hakkında herhangi bir sorunuz varsa, bizimle iletişime geçmekten çekinmeyin:</p>
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
