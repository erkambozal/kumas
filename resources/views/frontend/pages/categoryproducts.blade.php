@extends('frontend.layout.layout')

@section('content')
    <section class="ps-lg-4 pe-lg-3 pt-4">
        <div class="px-3 pt-2">
            
            <!-- Page title + breadcrumb-->
            <nav class="mb-4" aria-label="breadcrumb">
                <ol class="breadcrumb flex-lg-nowrap">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="{{ route('index') }}"><i
                                class="ci-home"></i>Anasayfa</a></li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">{{$name}}</li>
                </ol>
            </nav>
            

            <!-- Content-->
            <!-- Sorting-->
            <section class="d-md-flex justify-content-between align-items-center mb-4 pb-2">
                <h1 class="h2 mb-3 mb-md-0 me-3">Ürünler</h1>
              <!--  <div class="d-flex align-items-center">
                    <div class="d-none d-sm-block py-2 fs-sm text-muted text-nowrap me-2">Sırala:</div>
                    <ul class="nav nav-tabs fs-sm mb-0">
                        <li class="nav-item"><a class="nav-link active" href="#">En yeni</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Fiyata göre artan</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Fiyata göre azalan</a></li>
                    </ul>
                </div>-->
            </section>
            <!-- Product grid-->
            <div class="row g-0 mx-n2">
                <!-- Product-->
                    @foreach ($categoryproducts as $categoryproduct)
                        @php
                            $productcategories = json_decode($categoryproduct->categories, true);
                            $productcategory = isset($productcategories[0]) ? $productcategories[0] : null;
                            $firstcategory = isset($productcategory['name']) ? $productcategory['name'] : null;
                            $productimages = json_decode($categoryproduct->images, true);
                            $firstimage = isset($productimages[0]) ? $productimages[0] : null;

                        @endphp

                        <div class="col-xl-3 col-lg-6 col-md-4 col-sm-6 px-2 mb-3">
                            <div class="card product-card card-static pb-3"><a
                                    class="card-img-top d-block overflow-hidden"
                                    href="{{ route('productdetail', $categoryproduct->slug) }}">
                                    <img id="urunlerresim" src="{{ $firstimage }}" alt="{{ $categoryproduct->name }}"></a>
                                <div class="card-body py-2"><a class="product-meta d-block fs-xs pb-1"
                                        href="#">{{ $name }}</a>
                                    <h3 class="product-title fs-sm text-truncate"><a
                                            href="{{ route('productdetail', $categoryproduct->slug) }}">{{ $categoryproduct->name }}
                                        </a></h3>
                                    <div class="product-price"><span
                                            class="text-accent">{{ $categoryproduct->price . '₺' }}</span>
                                    </div>
                                </div>
                                
                                <div class="product-floating-btn">
                                    <form action="{{route("addItem")}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product" value="{{$categoryproduct->id}}">
                                        <input type="hidden" name="quantity" value="1">
                                    <button class="btn btn-primary btn-shadow btn-sm" type="submit">+<i
                                            class="ci-cart fs-base ms-1"></i></button>
                                        </form>
                                </div>
                            
                            </div>
                        </div>
                    @endforeach

            </div>
            <div class="py-4 pb-md-5 mb-4">
                <!-- Pagination-->


                    <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item{{ $categoryproducts->currentPage() === 1 ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $categoryproducts->previousPageUrl() }}"
                                    aria-label="Previous">
                                    <i class="ci-arrow-left me-2"></i>Önceki
                                </a>
                            </li>
                        </ul>
                        <ul class="pagination">
                            <li class="page-item d-sm-none">
                                <span class="page-link page-link-static">{{ $categoryproducts->currentPage() }} /
                                    {{ $categoryproducts->lastPage() }}</span>
                            </li>
                            @for ($page = 1; $page <= $categoryproducts->lastPage(); $page++)
                                <li class="page-item{{ $page === $categoryproducts->currentPage() ? ' active' : '' }} d-none d-sm-block"
                                    aria-current="page">
                                    <a class="page-link"
                                        href="{{ $categoryproducts->url($page) }}">{{ $page }}</a>
                                </li>
                            @endfor
                        </ul>
                        <ul class="pagination">
                            <li
                                class="page-item{{ $categoryproducts->currentPage() === $categoryproducts->lastPage() ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $categoryproducts->nextPageUrl() }}" aria-label="Next">
                                    Sonraki<i class="ci-arrow-right ms-2"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
            </div>
        </div>
    </section>
@endsection
