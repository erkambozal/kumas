@extends('frontend.layout.layout')

@section('content')
    <section class="ps-lg-4 pe-lg-3 pt-4">
        <div class="px-3 pt-2">
            <!-- Page title + breadcrumb-->
            <!-- Content-->
            <!-- Slider-->
            <section class="tns-carousel mb-3 mb-md-5">
                <div class="tns-carousel-inner"
                    data-carousel-options="{&quot;items&quot;: 1, &quot;mode&quot;: &quot;gallery&quot;, &quot;nav&quot;: false, &quot;responsive&quot;: {&quot;0&quot;: {&quot;nav&quot;: true, &quot;controls&quot;: false}, &quot;576&quot;: {&quot;nav&quot;: false, &quot;controls&quot;: true}}}">
                        <!-- Slide 1-->
                     <div><img src="img/grocery/slider/slide1.png" alt="Image"></div>
                     <!-- Slide 2-->
                    <div><img src="img/grocery/slider/slide2.png" alt="Image"></div>
                    <div><img src="img/grocery/slider/slide3.png" alt="Image"></div>
                    <div><img src="img/grocery/slider/slide4.png" alt="Image"></div>
                    <div><img src="img/grocery/slider/slide5.png" alt="Image"></div>
                </div>
            </section>
            <!-- How it works-->
            <section class="pt-4 mb-4 mb-md-5">
                <h2 class="h3 text-center mb-grid-gutter pt-2">Nasıl Çalışıyoruz?</h2>
                <div class="row g-0 bg-light rounded-3">
                    <div class="col-xl-4 col-lg-12 col-md-4 border-end">
                        <div class="py-3">
                            <div class="d-flex align-items-center mx-auto py-3 px-3" style="max-width: 362px;">
                                <div class="display-3 fw-normal opacity-15 me-4">01</div>
                                <div class="ps-2"><img class="d-block my-2" src="img/grocery/steps/01.png" width="72"
                                        alt="Order online">
                                    <p class="mb-3 pt-1">En sevdiğiniz ürünü sepete ekliyorsunuz.</p>
                                </div>
                            </div>
                            <hr class="d-md-none d-lg-block d-xl-none">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-4 border-end">
                        <div class="py-3">
                            <div class="d-flex align-items-center mx-auto py-3 px-3" style="max-width: 362px;">
                                <div class="display-3 fw-normal opacity-15 me-4">02</div>
                                <div class="ps-2"><img class="d-block my-2" src="img/grocery/steps/02.png" width="72"
                                        alt="Grocery collected">
                                    <p class="mb-3 pt-1">Personelimiz siparişi paketliyor.</p>
                                </div>
                            </div>
                            <hr class="d-md-none d-lg-block d-xl-none">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12 col-md-4">
                        <div class="py-3">
                            <div class="d-flex align-items-center mx-auto py-3 px-3" style="max-width: 362px;">
                                <div class="display-3 fw-normal opacity-15 me-4">03</div>
                                <div class="ps-2"><img class="d-block my-2" src="img/grocery/steps/03.png" width="72"
                                        alt="Delivery">
                                    <p class="mb-3 pt-1">En hızlı şekilde size teslim ediyoruz.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- İndirimli ürünler (Carousel)-->

            <section class="pt-4 mb-4 mb-md-5">
                <!-- Heading-->
                <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
                    <h2 class="h3 mb-0 pt-3 me-3">İndirimli ürünler</h2>
                    <div class="pt-3"><a class="btn btn-outline-accent btn-sm" href="{{ route('products') }}">Diğer
                            ürünler<i class="ci-arrow-right ms-1 me-n1"></i></a></div>
                </div>
                <div class="tns-carousel tns-controls-static tns-controls-outside tns-nav-enabled pt-2">
                    <div class="tns-carousel-inner"
                        data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}">
                        <!-- Product-->

                        @foreach ($products as $product)
                            @php
                                $productcategories = json_decode($product->categories, true);
                                $productcategory = isset($productcategories[0]) ? $productcategories[0] : null;
                                $firstcategory = isset($productcategory['name']) ? $productcategory['name'] : null;
                                $productimages = json_decode($product->images, true);
                                $firstimage = isset($productimages[0]) ? $productimages[0] : null;
								$imageUrl = $firstimage ? url("img/products/{$firstimage}") : null;

                            @endphp

                            @foreach ($productcategories as $productcategory)
                                @if ($productcategory['name'] == 'İndirimli Ürünler')
                                    <div>
                                        <div class="card product-card card-static pb-3"><a
                                                class="card-img-top d-block overflow-hidden"
                                                href="{{ route('productdetail', $product->slug) }}"><img id="indirimliresim"
                                                    src="{{ $firstimage }}" alt="Product"></a>
                                            <div class="card-body py-2"><a class="product-meta d-block fs-xs pb-1"
                                                    href="{{ route('categoryproducts', $productcategory['name']) }}">{{ $productcategory['name'] }}</a>
                                                <h3 class="product-title fs-sm text-truncate"><a
                                                        href="{{ route('productdetail', $product->slug) }}">{{ $product->name }}</a></h3>
                                                <div class="product-price"><span
                                                        class="text-accent">{{ $product->price . '₺' }}</span>
                                                    {{-- <del class="fs-sm text-muted">$2.<small>99</small></del> --}}
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
                                @endif
                            @endforeach
                        @endforeach

                    </div>
                </div>
            </section>
            <form method="POST" action="{{ route('addItem') }}" id="myform" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product" value="{{ $productiscampaing->id }}">
            <section class="container py-0">
                <div class="row align-items-center py-1 py-md-4">
                        @php
                            
                            $productimages = json_decode($productiscampaing->images, true);
                            $firstimage = isset($productimages[0]) ? $productimages[0] : null;
							$imageUrl = $firstimage ? url("img/products/{$firstimage}") : null;
                            $productcontent = $productiscampaing->content;
                            $productcontent = preg_replace('~&amp;lt;strong&amp;gt;Ürün Özellikleri&amp;lt;/strong&amp;gt;&amp;lt;br /&amp;gt;~', '', $productcontent);
                            $decoded_content = htmlspecialchars_decode(html_entity_decode($productcontent));

                        @endphp
                        

                    <div class="col-sm-6">
                        <div class="mb-5 mb-sm-0 text-center text-sm-start" id="colorOptions">
                            <div class="radio-tab-pane active" id="color-1" role="tabpanel"><img
                                    class="d-block mx-auto"
                                    src="{{ asset('/') }}{{ $firstimage }}" alt="Color 1">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 text-center text-sm-start">
                        <h2 class="pb-0 pt-4">Haftanın Fırsatı</h2>
                        <div class="pt-1">
                            @php
                            echo $decoded_content;
                             @endphp
                        </div>

                        <div class="d-flex flex-wrap align-items-center pt-4 pb-2 mb-3">
                            <select class="form-select me-3 mb-3" name="quantity" style="width: 5rem;">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <button class="btn btn-primary btn-shadow me-3 mb-3" type="submit"><i
                                    class="ci-cart fs-lg me-2"></i>Sepete Ekle</button>
                        </div>
                        {{-- <div class="mb-3"><span class="fs-sm text-heading fw-medium me-1"
                            id="colorOptionText">Kampanyalı fiyat</span><span>&nbsp;&mdash;&nbsp; {{$product->price.'₺'}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <a class="btn btn-primary" href="#"><i class="ci-cart fs-lg me-2"></i>Sepete Ekle</a>
                        </div> --}}

                    </div>
                    
                    

                </div>
            </section>
        </form>

            <!-- Tükenmekte olan ürünler (Carousel)-->
            <section class="pt-5 pb-4">
                <!-- Heading-->
                <div class="d-flex flex-wrap justify-content-between align-items-center pt-1 border-bottom pb-4 mb-4">
                    <h2 class="h3 mb-0 pt-3 me-3">Tükenmekte olan ürünler</h2>
                    <div class="pt-3"><a class="btn btn-outline-accent btn-sm" href="{{ route('products') }}">Diğer
                            ürünler<i class="ci-arrow-right ms-1 me-n1"></i></a></div>
                </div>
                <div class="tns-carousel tns-controls-static tns-controls-outside tns-dots-enabled pt-2">
                    <div class="tns-carousel-inner"
                        data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}">
                        <!-- Product-->

                        @foreach ($products as $product)
                            @php
                                $productcategories = json_decode($product->categories, true);
                                $firstcategory = isset($productcategories[0]) ? $productcategories[0] : null;
                                $productimages = json_decode($product->images, true);
                                $firstimage = isset($productimages[0]) ? $productimages[0] : null;

                            @endphp

                            @if ($product->qty > 1 && $product->qty < 5)
                                <div>
                                    <div class="card product-card card-static pb-3"><a
                                            class="card-img-top d-block overflow-hidden" href="{{ route('productdetail', $product->slug) }}"><img
                                                id="indirimliresim" src="{{ $firstimage }}" alt="Product"></a>
                                        <div class="card-body py-2"><a class="product-meta d-block fs-xs pb-1"
                                                href="{{ route('categoryproducts',$firstcategory['name']) }}">{{ $firstcategory['name'] }}</a>
                                            <h3 class="product-title fs-sm text-truncate"><a
                                                    href="{{ route('productdetail', $product->slug) }}">{{ $product->name }}</a></h3>
                                            <div class="product-price"><span
                                                    class="text-accent">{{ $product->price . '₺' }}</span>
                                                {{-- <del class="fs-sm text-muted">$2.<small>99</small></del> --}}
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
                            @endif
                        @endforeach

                    </div>
                </div>
            </section>


            <div class="pb-3"></div>
        </div>
    </section>
@endsection

