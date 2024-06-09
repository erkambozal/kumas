<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Tanerk Kumas | Kumaş Mağazası</title>
    <base href="http://127.0.0.1:8000">
    <!-- SEO Meta Tags-->
    <meta name="description" content="Online Kumaş Mağazası, Parça Kumaş, Döşemelik Kumaş, Elbiselik Kumaş">
    <meta name="keywords" content="Kumaş mağazası, Elbiselik,Abiye,Astar,Baskılı,Bebek,Brokar,Dantel,Gömleklik,İpek,Poliviskon,Poplin,Saten,Şifon,Tafta,Vual,Kesim">
    <meta name="author" content="Erkam Talha Kuşdil, Tan Yaşar">
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" color="#fe6a6a" href="safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="{{asset('/')}}vendor/simplebar/dist/simplebar.min.css"/>
    <link rel="stylesheet" media="screen" href="{{asset('/')}}vendor/tiny-slider/dist/tiny-slider.css"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{asset('/')}}css/theme.min.css">

    <style>

            #slider{
                width: 100%;
                max-height: 100px;
                overflow: hidden;
            }

            #indirimliresim{
                height: 175px;
            }

            #urunlerresim{
                height: 175px;
            }

            #thumbnail{
                height: 80px;
            }

            #preview{
                height: 258px;
            }

            #relatedcard{
                height: 238px;
            }

            #relatedimg{
                height: 139px;
            }



    </style>

  </head>
  <!-- Body-->
  <body class="bg-secondary">
   @include('frontend.inc.header')

   @include('frontend.inc.sidebar')


   <main class="offcanvas-enabled" style="padding-top: 5rem;">
    @yield('content')
   @include('frontend.inc.footer')
    </main>
    <!-- Back To Top Button--><a class="btn-scroll-top" href="#top" data-scroll data-fixed-element><span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span><i class="btn-scroll-top-icon ci-arrow-up">   </i></a>
    <!-- Vendor scrits: js libraries and plugins-->
    <script src="{{asset('/')}}vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('/')}}vendor/simplebar/dist/simplebar.min.js"></script>
    <script src="{{asset('/')}}vendor/tiny-slider/dist/min/tiny-slider.js"></script>
    <script src="{{asset('/')}}vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
    <!-- Main theme script-->
    <script src="{{asset('/')}}js/theme.min.js"></script>
  </body>
</html>
