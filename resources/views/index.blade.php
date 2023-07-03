@extends('layouts.app')
@section('content')
<!-- Header -->
<header class="row justify-content-center mb-2">
    <div class="col-xl-7 d-flex justify-content-xl-end order-xl-2 d-flex">
        <input type="hidden" id="window-width" value="">
        <!-- 横幅が992px以上の場合の処理 -->
        <div class="owl-carousel owl-theme d-none d-md-block">
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_hakamairi1400_400.png')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_omamori1400_400.png')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_uranai1400_400.png')}}');"></div>
        </div>

        <!-- 横幅が991px以下の場合の処理 -->
        <div class="owl-carousel owl-theme d-md-none">
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_hakamairi576_200.png')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_omamori576_200.png')}}');"></div>
            <div class="header-item" style="background-image: url('{{ asset('storage/images/slider_uranai576_200.png')}}');"></div>
        </div>

    </div>
    <div class="d-flex col-xl-4 justify-content-xl-start order-xl-1">
        <table class="table">
            <tr>
                <th>{{$info_1->title}}</th>
                <td>{{ \Carbon\Carbon::parse($info_1->created_at)->format('m月d日 H時') }}
                    <button class="mx-2 btn btn-primary" id="informationButton1">詳細</button>
                </td>
            </tr>
            <tr>
                <th>{{$info_2->title}}</th>
                <td>{{ \Carbon\Carbon::parse($info_2->created_at)->format('m月d日 H時') }}
                    <button class="mx-2 btn btn-primary" id="informationButton2">詳細</button>
                </td>

            </tr>
            <tr>
                <th>{{$info_3->title}}</th>
                <td>{{ \Carbon\Carbon::parse($info_3->created_at)->format('m月d日 H時') }}
                    <button class="mx-2 btn btn-primary" id="informationButton3">詳細</button>
                </td>

            </tr>
        </table>
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
<div class="container-fluid px-3 my-4">
    <div class="row">
        <div class="col-lg-2 d-lg-block d-none">
            <!-- Navbar Left -->
            <div class="navbar-left">
                <ul class="navbar-nav list-group">
                    @foreach($categories as $category)
                    <li class="nav-item px-2 list-group-item border-0">
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ asset($category->icon) }}" alt="Category Icon" class="category-icon">
                            </div>
                            <div class="col-8">
                                <a href="{{ route('service.search', ['category_ids[]' => $category->id]) }}" class="nav-link btn btn-link">
                                    {{ $category->name }}
                                </a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-lg-10">
            <!-- New Arrivals -->
            <section class="new-arrivals-section">
                <div class="container">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="section-title">出品サービスの新着案件</h2>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('service') }}">もっと見る</a>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($items as $item)
                        <div class="col-md-6 col-lg-3 card-all">
                            <div class="card mb-4">
                                <div class="service-card">
                                    <img src="{{asset($item->photo_1)}}" class="card-img-top" alt="image_photo">
                                </div>
                                <div class="card-body">
                                    @foreach($item->categories as $value)
                                    <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
                                    @endforeach
                                    <h5 class="fs-6 fw-bolder">{{$item->main_title}}</h5>
                                    <div class="row align-items-center">
                                        <div class="col-4 d-flex fs-7">
                                            {{$item->provider_name }}
                                        </div>
                                        <div class="col-4 fs-7 text-secondary text-md-center">{{ $item->price }}円</div>
                                        <div class="col-4 text-md-end">
                                            <a href="{{ route('service.detail',['service_id'=>$item->id]) }}" class="btn btn-primary fs-7">詳細</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 d-lg-block d-none"></div>
        <!--公開依頼-->
        <div class="col-lg-10">
            <!-- New Arrivals -->
            <section class="new-arrivals-section">
                <div class="container">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="section-title">公開依頼の新着案件</h2>
                        </div>
                        <div class="col-4">
                            <a href="{{ route('pubreq.index') }}">もっと見る</a>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($public_requests as $public_request)
                        <div class="col-md-6 col-lg-3 card-all">
                            <div class="card mb-2 p-2">
                                <div class="px-2">
                                    <p class="text-muted small">依頼投稿日：{{\Carbon\Carbon::parse($public_request->created_at)->format('Y年m月d日')}}</p>
                                </div>
                                <div class="row">
                                    <div class="offset-1 col-3">
                                        <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <img src="{{ asset($public_request->profile_image) }}" alt="" class="w-100 h-100">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <p class="fs-6 mb-0">{{ $public_request->seeker_name }}</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @foreach($public_request->categories as $value)
                                    <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
                                    @endforeach
                                    <h5 class="fs-6 fw-bolder">{{$public_request->main_title}}</h5>
                                    <div class="row align-items-center">
                                        <div class="col-4 d-flex fs-7">
                                            {{$public_request->provider_name }}
                                        </div>
                                        <div class="col-4 fs-7 text-secondary text-md-center">{{ $public_request->price }}円</div>
                                        <div class="col-4 text-md-end">
                                            <a href="{{ route('pubreq.detail',['service_id'=>$public_request->id]) }}" class="btn btn-primary fs-7">詳細</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
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

    //デバイス横幅取得
    function getWindowWidth() {
        return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    }
    document.getElementById('window-width').value = getWindowWidth();
</script>

@endsection