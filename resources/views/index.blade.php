<!DOCTYPE html>
<html lang=" {{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <script src="path/to/alpine.js" defer></script>

</head>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav" style="background-image: url('{{ asset('storage/others/hotaru_bannar5.png')}}');">
    <div class="container px-5">
        <a class="navbar-brand fw-bold" href="/">ほたる参り</a>
        @auth
        <div class="nav-item">
            <a href="{{ route('announcement.index') }}">
                <span class="position-relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                    </svg>
                    <span class="position-absolute top-2 start-150 translate-middle badge rounded-pill bg-danger">
                        <span class="visually-hidden">未読の通知数</span>
                        <!-- 未読の通知数 -->
                        {{count($announcements)}}
                    </span>
                </span>
            </a>
        </div>
        @endauth
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('seeker.index')}}">商品(サービス)を探す・依頼する</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('provider.index')}}">商品(サービス)を出品・提案する</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('chat.list')}}">チャット</a></li>
                <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('mypage.index')}}">マイページ</a></li>
                @guest
                <li class="nav-item"><a class="nav-link me-lg-3" href="/login">ログイン</a></li>
                @endguest
                @auth
                <li class="nav-item"><a class="nav-link me-lg-3" href="/logout">ログアウト</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
<!-- Header -->
<header class="header-section">
    <div class="owl-carousel owl-theme">
        <div class="header-item" style="background-image: url('{{ asset('storage/images/toppage_1.png')}}');"></div>
        <div class="header-item" style="background-image: url('{{ asset('storage/images/toppage_2.png')}}');"></div>
        <div class="header-item" style="background-image: url('{{ asset('storage/images/toppage_3.png')}}');"></div>
        <div class="header-item" style="background-image: url('{{ asset('storage/images/toppage_4.png')}}');"></div>
    </div>
</header>

<!-- New Arrivals -->
<section class="new-arrivals-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">新着の案件情報</h2>
            </div>
        </div>
        <div class="row">
            @foreach($items as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card mb-4">
                    <img src="{{asset($item->photo_1)}}" class="card-img-top" alt="image_photo">
                    <div class="card-body">
                        <h5 class="card-title">{{$item->main_title}}</h5>
                        <a href="{{ route('service.detail',['service_id'=>$item->id]) }}" class="btn btn-primary">詳細を見る</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

</html>

<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<style>
    /* Custom styles for the header carousel */
    .header-section {
        position: relative;
        height: 400px;
    }

    .header-item {
        height: 400px;
        background-size: cover;
        background-position: center;
    }

    .owl-nav button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    }

    .owl-prev {
        left: 0;
    }

    .owl-next {
        right: 0;
    }
</style>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
    $(function() {
        // Initialize the header carousel
        $('.owl-carousel').owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            nav: true,
            navText: ['<i class="bi-chevron-left"></i>', '<i class="bi-chevron-right"></i>']
        });
    });
</script>