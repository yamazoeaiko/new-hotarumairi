@extends('layouts.app')
@section('content')
<!-- Header -->
<header class="row justify-content-center">
    <div class="d-flex  col-lg-7 justify-content-lg-end order-lg-2 owl-carousel owl-theme">
        <div class="header-item" style="background-image: url('{{ asset('storage/images/toppage_1.png')}}');"></div>
        <div class="header-item" style="background-image: url('{{ asset('storage/images/toppage_2.png')}}');"></div>
        <div class="header-item" style="background-image: url('{{ asset('storage/images/toppage_3.png')}}');"></div>
        <div class="header-item" style="background-image: url('{{ asset('storage/images/toppage_4.png')}}');"></div>
    </div>
    <div class="d-flex col-lg-4 justify-content-lg-start order-lg-1">
        <table class="table">
            <tr>
                <td>お知らせ①</td>
            </tr>
            <tr>
                <td>お知らせ②</td>
            </tr>
            <tr>
                <td>お知らせ③</td>
            </tr>
        </table>
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
@endsection