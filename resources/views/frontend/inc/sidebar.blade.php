<aside class="offcanvas offcanvas-expand w-100 border-end zindex-lg-5 pt-lg-5" id="sideNav"
    style="max-width: 21.875rem;">
    <div class="pt-2 d-none d-lg-block"></div>
    <ul class="nav nav-tabs nav-justified mt-4 mt-lg-5 mb-0" role="tablist" style="min-height: 3rem;">
        <li class="nav-item"><a class="nav-link fw-medium active" href="#categories" data-bs-toggle="tab"
                role="tab">Kategoriler</a></li>
        <li class="nav-item d-lg-none"><a class="nav-link fs-sm" href="#" data-bs-dismiss="offcanvas"
                role="tab"><i class="ci-close fs-xs me-2"></i>Kapat</a></li>
    </ul>
    <div class="offcanvas-body px-0 pt-3 pb-0" data-simplebar>
        <div class="tab-content">
            <!-- Categories-->
               <div class="sidebar-nav tab-pane fade show active" id="categories" role="tabpanel">
                <div class="widget widget-categories">
                    <div class="accordion" id="shop-categories">
                        @foreach ($categories as $category)
                            @if ($category->cat_ust == null)
                                @if (in_array($category->id, [51, 52, 53]))
                                    <div class="accordion-item border-bottom">
                                        <div class="accordion-header px-grid-gutter">
                                            <a href="{{ route('categoryproducts', $category->name) }}"
                                               class="accordion-button  collapsed py-3" role="button">
                                                <span class="d-flex align-items-center">{{ $category->name }}</span>
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="accordion-item border-bottom">
                                        <div class="accordion-header px-grid-gutter">
                                            <button class="accordion-button collapsed py-3" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#{{ $category->slug }}"
                                                    aria-expanded="false" aria-controls="{{ $category->slug }}">
                                                <span class="d-flex align-items-center">{{ $category->name }}</span>
                                            </button>
                                        </div>
                                        <div class="collapse" id="{{ $category->slug }}" data-bs-parent="#shop-categories">
                                            <div class="px-grid-gutter pt-1 pb-4">
                                                <div class="widget widget-links">
                                                    <ul class="widget-list">
                                                        @foreach ($categories as $subcategory)
                                                            @if ($subcategory->cat_ust == $category->id)
                                                                <li class="widget-list-item">
                                                                    <a class="widget-list-link"
                                                                       href="{{ route('categoryproducts', $subcategory->name) }}">
                                                                        {{ $subcategory->name }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer d-block px-grid-gutter pt-4 pb-4 mb-2">
        <div class="d-flex mb-3"><span><img style="width: 30px; height:30px;" src="img/whatsapp.png"></span>
            <div class="ps-2">
                <div class="text-muted fs-sm">İletişim</div><a class="nav-link-style fs-md"
                    href="https://wa.me/905442266416">{{$settings['iletisim']}}</a>
            </div>
        </div>
        <div class="d-flex mb-3"><span><img style="width: 30px; height:30px;" src="img/message.png"></span>
            <div class="ps-2">
                <div class="text-muted fs-sm">Email</div><a class="nav-link-style fs-md"
                    href="mailto:info@tanerk.com">{{$settings['email']}}</a>
            </div>
        </div>
        <h6 class="pt-2 pb-1">Sosyal Medya</h6><a class="btn-social bs-outline bs-twitter me-2 mb-2"
            href="#"><i class="ci-twitter"></i></a><a class="btn-social bs-outline bs-facebook me-2 mb-2"
            href="#"><i class="ci-facebook"></i></a><a class="btn-social bs-outline bs-instagram me-2 mb-2"
            href="#"><i class="ci-instagram"></i></a><a class="btn-social bs-outline bs-youtube me-2 mb-2"
            href="#"><i class="ci-youtube"></i></a>
    </div>
</aside>
