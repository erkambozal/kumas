@extends('frontend.layout.layout')

@section('content')
<style>
.qty {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  flex-wrap: wrap;
  margin-top: 20px; /* Input ile üst arasındaki boşluğu ayarla */
  background-color: #ffffff; /* Beyaz arka plan */
  padding: 10px; /* Padding ekleme */
}

/* Label stilleri */
.qty label {
  margin-right: 10px; /* Label ile input arasındaki boşluğu ayarla */
}

/* Input stilleri */
.qty input {
  width: 7rem;
  height: 3rem;
  font-size: 1.3rem;
  text-align: center;
  border: 1px solid #ccc; /* Örnek bir kenarlık rengi */
  margin: 0 30px; /* Butonlar arasındaki boşluğu azalt */
  box-sizing: border-box; /* Kenarlık dahil kutu boyutu */
  margin-left: 0; /* Sol taraftan boşluk kaldırma */
}

/* Buton stilleri */
.qty button {
  width: 1.8rem;
  height: 1.8rem;
  font-size: 0.9rem; /* Buton yazı boyutu küçültüldü */
  background: #888; /* Örnek bir buton arka plan rengi */
  margin: 0.2rem 0.5rem; /* Butonlar arasındaki boşluğu ayarla */
  border: none;
  cursor: pointer;
  box-sizing: border-box; /* Kenarlık dahil kutu boyutu */
}

/* Artırma ve azaltma düğmelerinin konumlandırılması */
.qty .qtyminus {
  align-self: flex-start; /* Üst sol köşeye hizala */
  margin-right: 5px; /* Eksi butonu ile input arasındaki boşluğu ayarla */
  margin-left: auto; /* Sağa yaslanacak şekilde */
}

.qty .qtyplus {
  align-self: flex-start; /* Üst sağ köşeye hizala */
  margin-left: 2rem; /* Artı butonu ile input arasındaki boşluğu ayarla */

}

/* Ek olarak, mobil uyumluluk için eklemeler */
@media only screen and (max-width: 600px) {
  .qty input {
    width: 5rem;
    height: 2.5rem;
    font-size: 1.1rem;
    margin: 0 20px; /* Mobildeki input ile butonlar arasındaki boşluğu azalt */
  }

  .qty button {
    width: 1.5rem;
    height: 1.5rem;
    font-size: 0.9rem; /* Mobildeki buton yazı boyutunu küçült */
    margin: 0.1rem; /* Mobildeki butonlar arasındaki boşluğu azalt */
  }

  .qty .qtyminus {
    margin-right: -15px; /* Eksi butonu ile input arasındaki boşluğu azalt */
  }
}
	
	@media (max-width: 1000px) {
    .product-gallery-thumblist {
    display: flex; /* Öğeleri yatay olarak sıralar */
    justify-content: center; /* Öğeleri sol tarafta hizalar */
    overflow-x: auto; /* Eğer öğeler sığmazsa yatay kaydırma sağlar */
    gap: 10px; /* Öğeler arasında 10 piksel boşluk bırakır */
    /* Diğer istediğiniz stil özelliklerini buraya ekleyebilirsiniz */
}

/* Her bir ürün galerisi resmi öğesi */
.product-gallery-thumblist-item {
    flex: 0 0 auto; /* Öğelerin boyutlarını otomatik ayarlar */
    margin:10px;
}

/* Aktif olan ürün galerisi resmi öğesi için stil */
.product-gallery-thumblist-item.active {
    border: 2px solid #000; /* Aktif resme kenarlık ekler (örnek olarak siyah) */
    /* Diğer istediğiniz stil özelliklerini buraya ekleyebilirsiniz */
}

/* Ürün galerisi resimleri */

	.product-gallery-preview {
    display: flex; /* Öğeleri yatay olarak sıralar */
    flex-wrap: wrap; /* Yeterli yer olmadığında alt satıra geçiş yapar */
}

.product-gallery-preview-item {
    flex: 1 1 auto; /* Öğelerin genişliğini otomatik olarak ayarlar */
    margin-top: 10px; /* Öğeler arasında 10px boşluk bırakır */
    /* Diğer istediğiniz stil özelliklerini buraya ekleyebilirsiniz */
}	
}
</style>
    <section class="ps-lg-4 pe-lg-3 pt-4">
        <div class="px-3 pt-2">
            <!-- Page title + breadcrumb-->
            @php
                $productcategories = json_decode($product->categories, true);
                $productcategory = isset($productcategories[0]) ? $productcategories[0] : null;
                $firstcategory = isset($productcategory['name']) ? $productcategory['name'] : null;
                $productimages = json_decode($product->images, true);
                $firstimage = isset($productimages[0]) ? $productimages[0] : null;
                $secondimage = isset($productimages[1]) ? $productimages[1] : null;
                $thirdimage = isset($productimages[2]) ? $productimages[2] : null;
                $productcontent = $product->content;
                $productcontent = preg_replace('~&amp;lt;strong&amp;gt;Ürün Özellikleri&amp;lt;/strong&amp;gt;&amp;lt;br /&amp;gt;~', '', $productcontent);
                $decoded_content = htmlspecialchars_decode(html_entity_decode($productcontent));

            @endphp

            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb flex-lg-nowrap">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i
                                class="ci-home"></i>Anasayfa</a></li>
                    <li class="breadcrumb-item text-nowrap"><a href="{{ route('products') }}">{{ $firstcategory }}</a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
            <!-- Content-->
            <!-- Product Gallery + description-->
            <section class="row g-0 mx-n2 pb-5 mb-xl-3">
                <div class="col-xl-7 px-2 mb-3">
                    <div class="h-90 bg-light rounded-3 p-4">
                        <div class="product-gallery">
                            <div class="product-gallery-preview order-sm-2">

                                <div class="product-gallery-preview-item active" id="first"><img
                                        src="{{ asset('/') }}{{ $firstimage }}" id="preview" alt="Product image">
                                </div>
                                @if ($secondimage != null)
                                    <div class="product-gallery-preview-item" id="second"><img
                                            src="{{ asset('/') }}{{ $secondimage }}"id="preview" alt="Product image">
                                    </div>
                                @endif

                                @if ($thirdimage != null)
                                    <div class="product-gallery-preview-item" id="third"><img
                                            src="{{ asset('/') }}{{ $firstimage }}"id="preview" alt="Product image">
                                    </div>
                                @endif

                            </div>
                            <div class="product-gallery-thumblist order-sm-1"><a
                                    class="product-gallery-thumblist-item active" href="#first"><img
                                        src="{{ asset('/') }}{{ $firstimage }}" id="thumbnail"
                                        alt="Product thumb"></a>
                                @if ($secondimage != null)
                                    <a class="product-gallery-thumblist-item" href="#second"><img
                                            src="{{ asset('/') }}{{ $secondimage }}" id="thumbnail"
                                            alt="Product thumb"></a>
                                @endif
                                @if ($thirdimage != null)
                                    <a class="product-gallery-thumblist-item" href="#third"><img
                                            src="{{ asset('/') }}{{ $thirdimage }}" id="thumbnail"
                                            alt="Product thumb"></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 px-2 mb-3">
                    <div class="h-100 bg-light rounded-3 py-5 px-4 px-sm-5"><a class="product-meta d-block fs-sm pb-2"
                            href="{{ route('categoryproducts',$productcategory['name']) }}">{{ $productcategory['name'] }}</a>
                        <h1 class="h2">{{ $product->name }}</h1>
                        <div class="h2 fw-normal text-accent">{{ $product->price . '₺' }}</div>
                        <div class="d-flex flex-wrap align-items-center pt-4 pb-2 mb-3">
                        
                            <form method="POST" action="{{ route('addItem') }}" id="myform" enctype="multipart/form-data">
                                @csrf
								@if(session('uruneklendi'))
                                    <div class="alert alert-success">
                                        {{ session('uruneklendi') }}
                                    </div>
                                @endif

                                <!-- Ürün bulunamadığında gösterilecek bildirim -->
                                @if(session('stoktayok'))
                                    <div class="alert alert-danger">
                                        {{ session('stoktayok') }}
                                    </div>
                                @endif
                                <p class="qty">
                                    <label for="qty">Miktar:</label>
                                    <button class="qtyminus" type="button" aria-hidden="true">&minus;</button>
                                    <input type="text" name="quantity" id="qty" value="0" readonly>
                                    <button class="qtyplus" type="button" aria-hidden="true">&plus;</button>
                                </p>
                                
                                <input type="hidden" name="product" value="{{$product->id}}">
                                <button class="btn btn-primary btn-shadow me-3 mb-3" type="button" id="addToCartButton"><i class="ci-cart fs-lg me-2"></i>Sepete Ekle</button>
                                
                            </form>
                        </div>
                        <div class="h2 fw-normal text-accent">Stok Sayısı : {{ $product->qty}}</div>
                        <ul class="list-unstyled fs-sm pt-2 mb-0">
                            @php
                                echo $decoded_content;
                            @endphp
                        </ul>
                    </div>
                </div>
            </section>
            <!-- Related products-->
            <section class="pb-5 mb-2 mb-xl-4">
                <h2 class="h3 pb-2 mb-grid-gutter text-center">Şunlar da hoşunuza gidebilir.</h2>
                <div class="tns-carousel tns-controls-static tns-controls-outside tns-nav-enabled">
                    <div class="tns-carousel-inner" id="relatedcard"
                        data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}">

                        <!-- Product-->


                        @foreach ($randomproducts as $randomproduct)
                            @php
                                $randomproductimages = json_decode($randomproduct->images, true);
                                $firstimage = isset($randomproductimages[0]) ? $randomproductimages[0] : null;
                            @endphp
                            <div>
                                <div class="card product-card card-static pb-3" ><a
                                        class="card-img-top d-block overflow-hidden"
                                        href="{{ route('productdetail', $randomproduct->slug) }}"><img id="relatedimg"
                                            src="{{ $firstimage }}" alt="{{ $randomproduct->name }}"></a>
                                    <div class="card-body py-2" ><a class="product-meta d-block fs-xs pb-1"
                                            href="{{ route('categoryproducts',$productcategory['name']) }}">{{ $productcategory['name'] }}</a>
                                        <h3 class="product-title fs-sm text-truncate"><a
                                                href="{{ route('productdetail', $randomproduct->slug) }}">{{ $randomproduct->name }}</a>
                                        </h3>
                                        <div class="product-price"><span class="text-accent">{{ $product->price . '₺' }}
                                        </div>
                                    </div>
                                    <div class="product-floating-btn">
										  <form action="{{route("addItem")}}" method="post">
											  @csrf
											  <input type="hidden" name="product" value="{{$product->id}}">
											  <input type="hidden" name="quantity" value="1">
										  <button class="btn btn-primary btn-shadow btn-sm" type="submit">+<i
												  class="ci-cart fs-base ms-1"></i></button>
											  </form>
										</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            
        </div>
    </section>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qtyInput = document.getElementById('qty');
        const qtyMinusBtn = document.querySelector('.qtyminus');
        const qtyPlusBtn = document.querySelector('.qtyplus');
        const addToCartButton = document.getElementById('addToCartButton');
        const maxStock = {{ $product->qty }};

        qtyMinusBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (qtyInput.value > 1) {
                qtyInput.value = parseFloat(qtyInput.value) - 0.5;
            }
        });

        qtyPlusBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (qtyInput.value < maxStock) {
                qtyInput.value = parseFloat(qtyInput.value) + 0.5;
            }
        });

        addToCartButton.addEventListener('click', function () {
            // Formun sunucuya gönderilmesi için aşağıdaki satırı ekleyin
            document.getElementById('myform').submit();
        });
    });
</script>


<style>

.qty {
  position: relative;
  display: flex;
  align-items: center;
  font-family: Arial, sans-serif;
}

/* Miktar etiketi stil */
.qty label {
  margin-right: 5px;
}

/* Artı ve eksi butonları stil */
.qty button {
  background-color: #f0f0f0;
  border: none;
  color: #333;
  font-weight: bold;
  font-size: 1.2em;
  width: 25px;
  height: 25px;
  cursor: pointer;
}

/* Artı ve eksi butonları arasındaki input alanı stil */
.qty input[type="text"] {
  width: 50px;
  height: 25px;
  text-align: center;
}

/* Artı butonu konumu */
.qty .qtyplus {
  position: absolute;
  right: 0;
}
</style>