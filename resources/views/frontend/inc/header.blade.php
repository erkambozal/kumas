<header class="bg-light shadow-sm fixed-top" data-fixed-element>
    <div class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand d-none d-sm-block me-3 me-xl-4 flex-shrink-0" href="{{route('index')}}">
                <img src="img/tanerk.png" width="162" alt="Kuponkumas">
            </a>
            <!-- Search-->
            <div class="input-group d-none d-lg-flex flex-nowrap mx-4" style="background-color: white;">
                <i class="ci-search position-absolute top-50 start-0 translate-middle-y ms-4"></i>
                <form class="form-inline my-2 my-lg-0 col-sm-10" type="get" action="{{ route('search') }}" style="margin-left: 15px;width: 750px;">
                    <div class="input-group">
                        <input class="form-control rounded-start flex-grow-3" type="text" name="query" style="background-color: white; width: 100px;"> <!-- Adjusted width -->
                        <button class="btn btn-outline-light d-block bg-dark" type="submit" style="background-color: white;">Ara</button>
                    </div>
                </form>
                <a href="{{ route('userOrder') }}" class="btn btn-outline-dark ms-3" style="left: 200px">Geçmiş Siparişlerim</a>
            </div>
            <!-- Toolbar -->
            <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center ms-xl-2">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sideNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-tool d-flex d-lg-none" href="#searchBox" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="searchBox">
                    <span class="navbar-tool-tooltip">Arama</span>
                    <div class="navbar-tool-icon-box">
                        <i class="navbar-tool-icon ci-search"></i>
                    </div>
                </a>
                <div class="user-menu">
                    @if (auth()->check())
                        <div class="user-dropdown navbar-tool-icon ci-user">
                            <span class="user-name" onmouseover="openUserDropdown()"> {{ $username ?? '' }}</span>
                            <div class="dropdown-content" id="userDropdown">
                                <a href="{{ route('userLogout') }}">Çıkış Yap</a>
                            </div>
                        </div>
                    @else
                        <div class="navbar-tool-icon ci-user">
                            <a href="{{ route('login') }}">Giriş Yap</a>
                        </div>
                    @endif
                </div>
                @php
                $userTotalPrice = 0;
                $cartCount = 0 ;
                @endphp
                @foreach ($carts as $cart)
                    @if (auth()->check() && $cart->user_id == auth()->user()->id)
                        @php
                            $cartimages = json_decode($cart->images, true);
                            $firstimage = isset($cartimages[0]) ? $cartimages[0] : null;
                            $productTotalPrice = $cart->price * $cart->quantity;
                            $userTotalPrice += $productTotalPrice;
                            $cartCount++;
                        @endphp
                    @endif
                @endforeach
                <div class="navbar-tool ms-5">
                    <a class="navbar-tool-icon-box bg-secondary" href="{{route('checkout')}}">
                        <span class="navbar-tool-label">{{$cartCount}}</span>
                        <i class="navbar-tool-icon ci-cart"></i>
                    </a>
                    <a class="navbar-tool-text" href="{{route('checkout')}}">
                        <small>Sepetim</small>{{ number_format($userTotalPrice, 2) }}₺
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Search collapse-->
    <div class="collapse" id="searchBox">
        <div class="card pt-2 pb-4 border-0 rounded-0">
            <div class="container">
                <form class="form-inline my-2 my-lg-0" type="get" action="{{route('search')}}">
                    <input class="form-control mr-sm-2" name="query" type="search" placeholder="Ürün Ara">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Ürün Ara</button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    // JavaScript kullanarak dropdown'ı açma ve kapatma
function openUserDropdown() {
    var dropdownContent = document.getElementById('userDropdown');
    if (dropdownContent.style.display === 'block') {
        dropdownContent.style.display = 'none';
    } else {
        dropdownContent.style.display = 'block';
    }
}
</script>
<style>
    .widget-cart-item {
        margin-top: 20px; /* Ürünlerin üst kısmına eklemek istediğiniz boşluğu burada ayarlayabilirsiniz */
        position: relative;
    }
    .widget-cart-item:hover {
        margin-left: 20px; /* Ürünü sağa kaydırmak için kullanabilirsiniz */
    }

    .delete-button {
        display: none;
        position: absolute;
        left: -3px; /* Ürün resminin solunda olacak */
        top: 10px; /* Ürünün üzerine gelince görünecek */
    }

    .widget-cart-item:hover .delete-button {
        display: inline-block;
        margin-right: 5px; /* Ürünü sağa kaydırmak için kullanabilirsiniz */
    }

    .delete-button a {
        display: inline-block;
        padding: 1px 2px; /* Silme düğmesinin boyutunu ayarlayabilirsiniz */
        background-color: white; /* Silme düğmesinin varsayılan arka plan rengi */
        color: white; /* Silme düğmesinin varsayılan metin rengi */
        border: 1px solid white; /* Silme düğmesinin kenarlık rengi */
        border-radius: 50%; /* Silme düğmesinin köşe yuvarlatması */
        text-decoration: none;
    }

    .delete-button a:hover {
        background-color: white; /* Silme düğmesinin üzerine gelindiğinde arka plan rengini değiştirin */
        color: red; /* Silme düğmesinin üzerine gelindiğinde metin rengini değiştirin */
    }

    .delete-icon {
        font-size: 15px; /* Silme simgesinin boyutunu ayarlayabilirsiniz */
        color:red;
    }

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group input {
        width: 100px; /* Adjusted width for the search bar */
    }

    .btn-outline-dark {
        background-color: white;
        border-color: #6c757d;
        color: #6c757d;
    }

    .btn-outline-dark:hover {
        background-color: #6c757d;
        color: white;
    }

    /* Dropdown menüyü gizle */
    #userDropdown {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 100px;
        box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
    }

    /* Dropdown açıldığında görünmesi */
    .user-dropdown:hover #userDropdown {
        display: block;
    }

    /* Dropdown menü öğelerinin stil ayarları */
    #userDropdown a {
        padding: 3px 5px;
        text-decoration: none;
        display: block;
        color: red;
    }

    /* Dropdown menü öğelerinin hover rengi */
    #userDropdown a:hover {
        background-color: #ddd;
    }
</style>
