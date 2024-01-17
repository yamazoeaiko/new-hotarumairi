@extends('layouts.app')
<script>
  $(document).ready(function() {
    // カルーセルの設定
    $("#carouselExampleIndicators").carousel();
  });
</script>
@section('meta_tags')
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset($item->photo_1) }}">
<meta name="twitter:title" content="サムネイル画像">
<meta name="twitter:description" content="出品サービスのサムネイル画像を表示">
<meta property="og:image" content="{{ asset($item->photo_1) }}">
@endsection

@section('content')
<div class="container">
  <h6 class="my-2 fw-bold">出品サービス詳細</h6>
  <div class="form-control">
    <div class="mb-3 row">
      <div class="col-2">
        <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img" style="max-width: 100%; height: auto;" onclick="event.stopPropagation(); window.location.href='{{ route('user.detail', ['user_id' => $item->provider_id]) }}'">
        @if($item->favorite == false)
        <form method="POST" action="{{ route('favorite', ['service_id'=> $item->id]) }}">
          @csrf
          <button type="submit" class="btn btn-outline-primary my-1">
            <small>お気に入り</small>
          </button>
        </form>
        @else
        <form action="{{route('unfavorite',['service_id'=> $item->id])}}" method="post">
          @csrf
          <button type="submit" class="btn btn-primary my-1">
            <small>お気に入り解除</small>
          </button>
        </form>
        @endif
        @if($item->follow == false)
        <form method="POST" action="{{ route('follow',['follower_id'=> $item->offer_user_id]) }}">
          @csrf
          <button type="submit" class="btn btn-outline-success my-1">
            <small>フォロー</small>
          </button>
        </form>
        @else
        <form action="{{route('unfollow',['follower_id'=>$item->offer_user_id])}}" method="post">
          @csrf
          <button class="btn btn-success my-1">
            <small>フォロー解除</small>
          </button>
        </form>
        @endif
      </div>
      <div class="col-10">
        <div class="mb-3">
          <p class="fw-bolder fs-3">{{ $item->main_title }}</p>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
            @if($item->photo_1)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            @endif
            @if($item->photo_2)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            @endif
            @if($item->photo_3)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            @endif
            @if($item->photo_4)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            @endif
            @if($item->photo_5)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            @endif
            @if($item->photo_6)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
            @endif
            @if($item->photo_7)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="6" aria-label="Slide 7"></button>
            @endif
            @if($item->photo_8)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="7" aria-label="Slide 8"></button>
            @endif
          </div>
          <div class="carousel-inner">
            @if($item->photo_1)
            <div class="carousel-item active">
              <img src="{{ asset($item->photo_1) }}" class="d-block w-100" alt="photo_1">
            </div>
            @endif
            @if($item->photo_2)
            <div class="carousel-item">
              <img src="{{ asset($item->photo_2) }}" class="d-block w-100" alt="photo_2">
            </div>
            @endif
            @if($item->photo_3)
            <div class="carousel-item">
              <img src="{{ asset($item->photo_3) }}" class="d-block w-100" alt="photo_3">
            </div>
            @endif
            @if($item->photo_4)
            <div class="carousel-item">
              <img src="{{ asset($item->photo_4) }}" class="d-block w-100" alt="photo_4">
            </div>
            @endif
            @if($item->photo_5)
            <div class="carousel-item">
              <img src="{{ asset($item->photo_5) }}" class="d-block w-100" alt="photo_5">
            </div>
            @endif
            @if($item->photo_6)
            <div class="carousel-item">
              <img src="{{ asset($item->photo_6) }}" class="d-block w-100" alt="photo_6">
            </div>
            @endif
            @if($item->photo_7)
            <div class="carousel-item">
              <img src="{{ asset($item->photo_7) }}" class="d-block w-100" alt="photo_7">
            </div>
            @endif
            @if($item->photo_8)
            <div class="carousel-item">
              <img src="{{ asset($item->photo_8) }}" class="d-block w-100" alt="photo_8">
            </div>
            @endif
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
        @if($item->categories)
        <div>
          @foreach($item->categories as $value)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
          @endforeach
        </div>
        @endif
        <div class="mb-3">
          <p class="card-text mb-0">
            <small class="text-muted">アカウント名：</small>
            {{$item->user_name}}
          </p>
          <p class="card-text mb-0">
            <small class="text-muted">年齢：</small>@if ($item->age >= 10 && $item->age < 20) 10代 @elseif ($item->age >= 20 && $item->age < 30) 20代 @elseif ($item->age >= 30 && $item->age < 40) 30代 @elseif ($item->age >= 40 && $item->age < 50) 40代 @elseif ($item->age >= 50 && $item->age < 60) 50代 @elseif ($item->age >= 60 && $item->age < 70) 60代 @elseif ($item->age >= 70 && $item->age < 80) 70代 @elseif ($item->age >= 80 && $item->age < 90) 80代 @elseif ($item->age >= 90 && $item->age < 100) 90代 @else その他の年齢 @endif </p>
                              <p class="card-text mb-0">
                                <small class="text-muted">住まい地域：</small>{{ $item->living_area }}
                              </p>
        </div>
        <!--
        <div class="mb-3">
          <div class="owl-carousel owl-theme">
            @foreach (range(1, 8) as $i)
            @php
            $photo = "photo_" . $i;
            @endphp
            @if ($item->$photo !== null)
            <img src="{{asset($item->$photo)}}" style=" width: 300px; height: 200px;">
            @endif
            @endforeach
          </div>
        </div>
        -->
        <div class="mb-3">
          <label for="price" class="fw-bolder">サービス価格</label>
          <div class="input-group">
            <input type="number" name="price" class="form-control" value="{{$item->price}}" readonly>
            <div class="input-group-append">
              <span class="input-group-text">円（税別）</span>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="content" class="fw-bolder">サービス内容</label>
          <textarea name="content" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->content }}</textarea>
        </div>

        @if($item->area_ids)
        <div class="mb-3">
          <label for="area_id" class="fw-bolder">対応可能エリア<span class="fs-7 text-secondary">※任意</span></label>
          @foreach($item->area_ids as $area_id)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success">{{ $area_id->name}}</small>
          @endforeach
        </div>
        @endif

        <div class="mb-3">
          <label for="attention" class="fw-bolder">購入時の注意事項<span class="fs-7 text-secondary">※任意</span></label>
          <textarea name="attention" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->attention }}</textarea>
        </div>

        <div class="form-group mb-3">
          <label class="fw-bolder" for="free">自由記入欄<span class="fs-7 text-secondary">※任意</span></label>
          <textarea class="form-control" name="free" readonly>{{ $item->free }}</textarea>
        </div>

        <div class="mb-3">
          <label for="status" class="fw-bolder">公開状況</label>
          <div>{{ $item->status_name }}</div>
        </div>
      </div>
    </div>

    @if($item->offer_user_id !== $user_id)
    <div class="text-center">
      @if($room_id)
      <button class="btn btn-success" onclick=location.href="{{route('chat.room',['room_id'=>$room_id])}}">チャット画面</button>
      @else
      <button type="button" class="btn btn-primary my-2" data-bs-toggle="collapse" data-bs-target="#collapseConsult">購入、見積もり、質問をする</button>

      <div class="collapse" id="collapseConsult">
        <form action="{{route('service.consult')}}" method="post">
          @csrf
          <input type="hidden" name="buy_user" value="{{$user_id}}">
          <input type="hidden" name="sell_user" value="{{ $item->offer_user_id }}">
          <input type="hidden" name="service_id" value="{{ $item->id }}">
          <div class="input-group">
            <textarea name="first_chat" class="text-start form-control" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" oninput="resizeTextarea(this)" placeholder="Enterで改行されます。"></textarea>
          </div>
          <button type="submit" class="btn btn-success col-3">送信する</button>
        </form>
      </div>
    </div>
    @endif

    @elseif($item->offer_user_id == $user_id)
    <div class="d-flex justify-content-around">
      <button class=" btn btn-primary" onclick=location.href="{{route('mypage.service.edit',['service_id'=>$item->id])}}">編集する</button>
    </div>

    <div class="text-center bg-light my-2 py-2">
      <p class="fs-6 fw-bolder">ご自身の出品サービスをSNSでアピールしよう！</p>
      <div class="d-flex justify-content-around">
        <!-- Twitterの共有ボタン -->
        <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text=ほたる参りで「{{ urlencode($item->main_title) }}」サービスを出品中！" class="btn btn-twitter my-1" target="_blank">
          <small>Twitterでシェア</small>
        </a>
        <!-- Instagramの共有ボタン -->
        <a href=" https://www.instagram.com/sharer.php?u={{ urlencode(Request::url()) }}&title=ほたる参りで「{{ urlencode($item->main_title) }}」サービスを出品中！&image={{ urlencode(asset($item->photo_1)) }}" class="btn btn-instagram my-1" target="_blank">
          <small>Instagramでシェア</small>
        </a>
        <!-- Facebookの共有ボタン -->
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}" class="btn btn-facebook my-1" target="_blank">
          <small>Facebookでシェア</small>
        </a>
        <button class="btn btn-outline-primary my-1" id="copyButton">
          <small>リンクをコピー</small>
        </button>
        <!-- リンクの表示用テキストエリア -->
        <textarea id="linkTextArea" style="display: none;">{{ Request::url() }}</textarea>
      </div>

    </div>
    @endif
  </div>
</div>

@endsection
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
  document.getElementById('copyButton').addEventListener('click', function() {
    var linkTextArea = document.getElementById('linkTextArea');
    linkTextArea.style.display = 'block';
    linkTextArea.select();
    document.execCommand('copy');
    linkTextArea.style.display = 'none';
    alert('リンクがコピーされました！');
  });

  function resizeTextarea(textarea) {
    textarea.style.height = '70px';
    textarea.style.height = textarea.scrollHeight + 'px';
  }

  const textarea = document.querySelector('textarea');
  textarea.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      const startPos = textarea.selectionStart;
      const endPos = textarea.selectionEnd;
      textarea.value = textarea.value.substring(0, startPos) + '\n' + textarea.value.substring(endPos, textarea.value.length);
      resizeTextarea(textarea);
    }
  });
</script>