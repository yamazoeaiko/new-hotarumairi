@extends('layouts.app')
@section('content')
<!-- Header -->
<header class="px-2 row justify-content-center mb-2">
    <div class="col-lg-7 d-flex justify-content-lg-end order-lg-2 d-flex">
        <input type="hidden" id="window-width" value="">
        <!-- 横幅が992px以上の場合の処理 -->
        <div class="owl-carousel owl-theme d-none d-lg-block">
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_hotarumairi_top_w1400xh400.jpeg')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_hakamairi1400_400.png')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_omamori1400_400.png')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_uranai1400_400.png')}}');"></div>
        </div>

        <!-- 横幅が991px以下の場合の処理 -->
        <div class="owl-carousel owl-theme d-lg-none mt-4">
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_hotarumairi_top_w576xh200.jpeg')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_hakamairi576_200.png')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_omamori576_200.png')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_uranai576_200.png')}}');"></div>
        </div>

    </div>
    <div class="col-lg-5 justify-content-lg-start order-lg-1">
        <div class="mb-2 text-info fs-5 border-bottom border-info">
            <i class="bi bi-book"></i></i><a class="" href="https://about.hotarumairi.com/" target="_blank">初めての方へ<span class="fs-7">〜『ほたる参り』とは？〜</span></a>
        </div>
        <div class="text-primary fw-bolder">運営からのお知らせ</div>
        <div class="">
            <div class="border-bottom border-1 mb-2 d-flex justify-content-between align-items-center">
                <label>{{$info_1->title}}</label>
                <div class="fs-7">
                    <button class="mx-2 btn btn-outline-primary p-0" id="informationButton1">詳細</button>
                    {{ \Carbon\Carbon::parse($info_1->created_at)->format('m月d日') }}
                </div>
            </div>
            <div class="border-bottom border-1 mb-2 d-flex justify-content-between align-items-center">
                <label>{{$info_2->title}}</label>
                <div class="fs-7">
                    <button class="mx-2 btn btn-outline-primary p-0" id="informationButton2">詳細</button>
                    {{ \Carbon\Carbon::parse($info_2->created_at)->format('m月d日') }}
                </div>
            </div>
            <div class="border-bottom border-1 mb-2 d-flex justify-content-between align-items-center">
                <label>{{$info_3->title}}</label>
                <div class="fs-7">
                    <button class="mx-2 btn btn-outline-primary p-0" id="informationButton3">詳細</button>
                    {{ \Carbon\Carbon::parse($info_3->created_at)->format('m月d日') }}
                </div>
            </div>
        </div>
    </div>
    <div id="informationPopup1" class="informationPopup p-3 rounded-2 border-primary border-3 fs-6">
        {{ $info_1->content }}
        <div>
            <button class="mx-2 btn btn-outline-primary" id="closeButton1">閉じる</button>
        </div>
    </div>
    <div id="informationPopup2" class="informationPopup p-3 rounded-2 border-primary border-3 fs-6">
        {{ $info_2->content }}
        <div>
            <button class="mx-2 btn btn-outline-primary" id="closeButton2">閉じる</button>
        </div>
    </div>
    <div id="informationPopup3" class="informationPopup p-3 rounded-2 border-primary border-3 fs-6">
        {{ $info_3->content }}
        <div>
            <button class="mx-2 btn btn-outline-primary" id="closeButton3">閉じる</button>
        </div>
    </div>
</header>
<!-- New Arrivals -->
<div class="container-fluid px-3 my-4 d-flex flex-wrap">
    <div class="row">
        <div class="col-lg-2 col-10 order-lg-1 order-3">
            <!-- Navbar Left -->
            <div class="navbar-left">
                <ul class="navbar-nav list-group">
                    @foreach($categories as $category)
                    <li class="nav-item px-2 list-group-item border-0 py-0">
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ asset($category->icon) }}" alt="Category Icon" class="category-icon">
                            </div>
                            <div class="col-8">
                                <a href="{{ route('service.search', ['category_ids[]' => $category->id]) }}" class="nav-link btn btn-link ps-7">
                                    {{ $category->name }}
                                </a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-10 order-lg-2 order-1">
            <!-- New Arrivals -->
            <section class="new-arrivals-section">

                <div class="row">
                    <div class="col-7">
                        <h2 class="section-title">出品サービスの新着案件</h2>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('service') }}">全ての出品サービスを見る</a>
                    </div>
                </div>
                <div class="card-items">
                    @foreach($items as $item)
                    <div class="card-item">
                        <a class="card mb-4 text-decoration-none" href="{{ route('service.detail',['service_id'=>$item->id]) }}">
                            <div class="service-card">
                                <img src="{{asset($item->photo_1)}}" class="card-img-top" alt="image_photo">
                            </div>
                            <div class="card-body">
                                <div class="category-parent">
                                    @foreach($item->categories as $value)
                                    <small class="text-ellipsis d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
                                    @endforeach
                                </div>

                                <p class="fw-bolder text-ellipsis">{{$item->main_title}}</p>

                                <div class="row align-items-center px-1">
                                    <div class="col-5">
                                        <div class="rounded-circle overflow-hidden d-flex" style="width: 40px; height: 40px; padding: 0;">
                                            <img src="{{ asset($item->profile_image) }}" alt="" style="max-width: 100%; max-height: 100%;" onclick="event.stopPropagation(); window.location.href='{{ route('user.detail', ['user_id' => $item->id]) }}'">
                                        </div>
                                    </div>

                                    <div class="col-7 fs-7 text-secondary">{{ $item->price }}円</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach

                </div>
                @if($items->count() >= 5)
                <div class="d-flex justify-content-end fs-7 text-danger">
                    ※右にスライドできます<i class="bi bi-arrow-right"></i>
                </div>
                @endif
            </section>
        </div>
        <div class="row order-lg-3 order-2">
            <div class="col-lg-2 d-lg-block d-none"></div>
            <!--公開依頼-->
            <div class="col-lg-10">
                <!-- New Arrivals -->
                <section class="new-arrivals-section">

                    <div class="row">
                        <div class="col-7">
                            <h2 class="section-title">公開依頼の新着案件</h2>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('pubreq.index') }}">もっと見る</a>
                        </div>
                    </div>

                    <div class="card-items">
                        @foreach($public_requests as $public_request)
                        <div class="card-pub-item">
                            <a class="card mb-4 text-decoration-none" href="{{ route('pubreq.detail',['service_id'=>$public_request->id]) }}">
                                <div class="card-body">
                                    <div class="category-parent">
                                        @foreach($public_request->categories as $value)
                                        <small class="text-ellipsis d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
                                        @endforeach
                                    </div>
                                    <p class="fw-bolder text-ellipsis">{{$public_request->main_title}}</p>
                                    <div class="row align-items-center px-1">
                                        <div class="col-5">
                                            <div class="rounded-circle overflow-hidden d-flex" style="width: 40px; height: 40px; padding: 0;">
                                                <img src="{{ asset($public_request->profile_image) }}" alt="" style="max-width: 100%; max-height: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-7 fs-7 text-secondary">{{ $public_request->price }}円</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @if($public_requests->count() >= 5)
                    <div class="d-flex justify-content-end fs-7 text-danger">
                        ※右にスライドできます<i class="bi bi-arrow-right"></i>
                    </div>
                    @endif

                </section>
            </div>
        </div>
    </div>
</div>


</html>

<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<style>
    /* Custom styles for the header carousel */


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

    .informationPopup {
        z-index: 9999;
        width: 80%;
        display: none;
        background-color: #f1f1f1;
        border: 1px solid #ccc;
        padding: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
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

    var deliveryButton1 = document.getElementById("informationButton1");
    var deliveryPopup1 = document.getElementById("informationPopup1");

    deliveryButton1.addEventListener("click", function() {
        if (deliveryPopup1.style.display === "none") {
            deliveryPopup1.style.display = "block";
        } else {
            deliveryPopup1.style.display = "none";
        }
    });

    var deliveryButton2 = document.getElementById("informationButton2");
    var deliveryPopup2 = document.getElementById("informationPopup2");

    deliveryButton2.addEventListener("click", function() {
        if (deliveryPopup2.style.display === "none") {
            deliveryPopup2.style.display = "block";
        } else {
            deliveryPopup2.style.display = "none";
        }
    });

    var deliveryButton3 = document.getElementById("informationButton3");
    var deliveryPopup3 = document.getElementById("informationPopup3");

    deliveryButton3.addEventListener("click", function() {
        if (deliveryPopup3.style.display === "none") {
            deliveryPopup3.style.display = "block";
        } else {
            deliveryPopup3.style.display = "none";
        }
    });

    var closeButton1 = document.getElementById("closeButton1");
    var popup1 = document.getElementById("informationPopup1");

    closeButton1.addEventListener("click", function() {
        informationPopup1.style.display = "none";
    });
    var closeButton2 = document.getElementById("closeButton2");
    var popup2 = document.getElementById("informationPopup2");

    closeButton2.addEventListener("click", function() {
        informationPopup2.style.display = "none";
    });
    var closeButton3 = document.getElementById("closeButton3");
    var popup3 = document.getElementById("informationPopup3");

    closeButton3.addEventListener("click", function() {
        informationPopup3.style.display = "none";
    });
</script>

@endsection