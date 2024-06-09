@extends('frontend.layout.layout')

@section('content')
    <section class="ps-lg-4 pe-lg-3 pt-4">
        <div class="px-3 pt-2">
            <!-- Page title + breadcrumb-->
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb flex-lg-nowrap">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i class="ci-home"></i>Home</a></li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Sipariş</li>
                </ol>
            </nav>
            <!-- Content-->
            <!-- Checkout form-->
            <form action="{{ route('pay') }}" method="post" class="needs-validation" novalidate>
                @csrf
                <div class="row g-0 pb-5 mb-xl-3">
                    <!-- Delivery details-->
                    <div class="col-xl-6 mb-3">
                        <h1 class="h2 mb-4">Sipariş</h1>
                        <h2 class="h5 mb-4">Teslimat Detayları</h2>
                        <div class="row gx-4 gy-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="co-fn">Ad <span class='text-danger'>*</span></label>
                                <input class="form-control" type="text" name="delivery_name" id="co-fn" required>
                                <div class="invalid-feedback">Ad girilmedi!</div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="co-ln">Soyadı <span class='text-danger'>*</span></label>
                                <input class="form-control" type="text" name="delivery_surname" id="co-ln" required>
                                <div class="invalid-feedback">Soyadı girilmedi!</div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="co-phone">Telefon Numarası <span class='text-danger'>*</span></label>
                                <input class="form-control" type="tel" name="delivery_phone" id="co-phone" required>
                                <div class="invalid-feedback">Telefon numarası girilmedi!</div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="co-email">E-mail</label>
                                <input class="form-control bg-image-none" type="email" name="delivery_email" id="co-email">
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="co-address">Adres <span class='text-danger'>*</span></label>
                                <input class="form-control" type="text" name="delivery_address" id="co-address" required>
                                <div class="invalid-feedback">Adres eksik veya hatalı!</div>
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="co-note">Sipariş notu</label>
                                <textarea class="form-control bg-image-none" name="delivery_note" id="co-note" rows="6" placeholder="Eklemek istediğiniz detay varsa yazınız."></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Order summary + payment-->
                    <div class="col-xl-5 offset-xl-1 mb-2">
                        <div class="bg-light rounded-3 py-5 px-4 px-xxl-5">
                            <h2 class="h5 pb-3">Siparişin</h2>
                            @if (auth()->check() && auth()->user()->isAdmin == 0)
                                @php
                                    $totalPrice = 0;
                                    $cartCount = 0;
                                    $subtotal = 0;
                                    $shippingCost = 0;
                                @endphp
                                <!-- Oturum açmış bir kullanıcı için kodlar burada yer alır -->
                                @foreach ($carts as $cart)
                                    @if ($cart->user_id == auth()->user()->id)
                                        @php
                                            $cartimages = json_decode($cart->images, true);
                                            $firstimage = isset($cartimages[0]) ? $cartimages[0] : null;
                                            $productTotalPrice = $cart->price * $cart->quantity;
                                            $totalPrice += $productTotalPrice;
                                            $cartCount++;
                                        @endphp
                                        <div class="widget-cart-item pb-2 border-bottom" style="position: relative;">
                                            <div class="delete-button">
                                                <a href="{{ route('deleteCartCheckout', $cart->id) }}" class="btn btn-danger btn-sm">
                                                    <span class="delete-icon">X</span>
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a class="d-block" href="{{ route('productdetail', $cart->slug) }}">
                                                    <img src="{{ asset('/').$firstimage }}" width="64" alt="Product">
                                                </a>
                                                <div class="ps-2">
                                                    <h6 class="widget-product-title">
                                                        <a href="{{ route('productdetail', $cart->slug) }}">{{ $cart->productName }}</a>
                                                    </h6>
                                                    <div class="widget-product-meta">
                                                        <span class="text-accent me-2">{{ $cart->price }}₺</span>
                                                        <span class="text-muted">x {{ $cart->quantity }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @php
                                    if ($totalPrice < 1000) {
                                        $shippingCost = 75;
                                    } else {
                                        $shippingCost = 0;
                                    }
                                    $subtotal = $totalPrice + $shippingCost;
                                @endphp
                            @else
                                <p>Sepetinizi görmek için giriş yapın veya hesap oluşturun.</p>
                            @endif

                            <ul class="list-unstyled fs-sm pt-4 pb-2 border-bottom">
                                <li class="d-flex justify-content-between align-items-center"><span class="me-2">Toplam:</span><span class="text-end fw-medium">{{ number_format($totalPrice, 2) }}₺</span></li>
                                <li class="d-flex justify-content-between align-items-center"><span class="me-2">Kargo Ücreti:</span><span class="text-end fw-medium">{{ number_format($shippingCost, 2) }}₺</span></li>
                            </ul>
                            <h3 class="fw-normal text-center my-4 py-2">{{ number_format($subtotal, 2) }}₺</h3>

                            <div class="collapse show" id="credit-card" data-bs-parent="#payment-methods">
                                <div class="accordion-body py-2">
                                    <input class="form-control bg-image-none mb-3" type="text" name="CardHolderName" placeholder="Kart Üzerindeki İsim" value="">
                                    <input class="form-control bg-image-none mb-3" type="text" name="CardNumber" placeholder="Kart Numarası" value="">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <input class="form-control bg-image-none" type="text" name="CardExpireDateMonth" placeholder="Ay" value="">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <input class="form-control bg-image-none" type="text" name="CardExpireDateYear" placeholder="Yıl" value="">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <input class="form-control bg-image-none" type="text" name="CardCVV2" placeholder="CVC" value="">
                                        </div>
                                        <input type="hidden" name="Amount" id="amount" value="{{ $subtotal }}">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="total_amount" id="total_amount" value="{{ number_format($subtotal, 2) }}">
                            <div class="pt-2">
                                <button class="btn btn-primary d-block w-100" type="submit">Sipariş Ver</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        @if(session('payment_completed'))
            console.log('Ödeme işlemi tamamlandı!');
        @endif
    });
</script>