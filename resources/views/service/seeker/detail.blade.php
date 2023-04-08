@extends('layouts.app')

@section('content')
<div class="container">
  <div class="form-control">
    <div class="mb-3 row">
      <div class="col-md-4">
        <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img" style="max-width: 100%; height: auto;">
        @if($item->favorite == false)
        <form method="POST" action="{{ route('favorite', ['service_id'=> $item->id]) }}">
          @csrf
          <button type="submit" class="btn btn-primary my-1">
            <small>サービスをお気に入り登録</small>
          </button>
        </form>
        @else
        <form action="{{route('unfavorite',['service_id'=> $item->id])}}" method="post">
          @csrf
          <button type="submit" class="btn btn-outline-primary my-1">
            <small>サービスをお気に入り解除</small>
          </button>
        </form>
        @endif

        @if($item->follow == false)
        <form method="POST" action="{{ route('follow',['follower_id'=> $item->offer_user_id]) }}">
          @csrf
          <button type="submit" class="btn btn-success my-1">
            <small>{{$item->user_name}}をフォローする</small>
          </button>
        </form>
        @else
        <form action="{{route('unfollow',['follower_id'=>$item->offer_user_id])}}" method="post">
          @csrf
          <button class="btn btn-outline-success my-1">
            <small>{{$item->user_name}}のフォローを解除する</small>
          </button>
        </form>
        @endif
      </div>
      <div class="col-md-8">
        <div class="mb-3">
          <p class="fw-bolder fs-3">{{ $item->main_title }}</p>
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
            <small class="text-muted">ユーザー名：</small>
            {{$item->user_name}}
          </p>
          <p class="card-text mb-0">
            <small class="text-muted">年齢：</small>{{ $item->age }}歳
          </p>
          <p class="card-text mb-0">
            <small class="text-muted">住まい地域：</small>{{ $item->living_area }}
          </p>
        </div>
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
          <label for="area_id" class="fw-bolder">対応可能エリア</label>
          @foreach($item->area_ids as $area_id)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success">{{ $area_id->name}}</small>
          @endforeach
        </div>
        @endif

        <div class="mb-3">
          <label for="attention" class="fw-bolder">購入時の注意事項</label>
          <textarea name="attention" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->attention }}</textarea>
        </div>

        <div class="mb-3">
          <label for="public_sign" class="fw-bolder">公開状況</label>
          <div>{{ $item->public }}</div>
        </div>
      </div>
    </div>
    @if($item->offer_user_id !== $user_id)
    <div class="text-center">
      @if($room_id)
      <button class="btn btn-success" onclick=location.href="{{route('chat.room',['room_id'=>$room_id])}}">チャット画面</button>
      @if($entry->status == 'pending')
      <form action="{{route('service.estimate')}}" method="post">
        @csrf
        <input type="hidden" name="entry_id" value="{{$entry->id}}">
        <input type="hidden" name="service_id" value="{{$item->id}}">
        <input type="hidden" name="buy_user" value="{{$entry->buy_user}}">
        <input type="hidden" name="sell_user" value="{{$entry->sell_user}}">
        <button type="submit" class="btn btn-outline-danger mt-2">現在の内容で正式に応募する</button>
      </form>
      @elseif($entry->status == 'estimate')
      <button disabled="disabled" class="btn btn-outline-danger">正式な応募完了</button>
      @elseif($entry->status == 'approved')
      <div class="d-flex align-items-center justify-content-center">
        <div class="mx-2"><button class="btn btn-danger" onClick="location.href='{{route('payment', ['entry_id' => $entry->id])}}'">お支払い画面</button>
        </div>
        <div class="mx-2"><button class="btn btn-outline-danger">キャンセルする</button></div>
      </div>
      <span class="fs-4">※依頼が引き受けられました</span>
      <div>

      </div>
      @elseif($entry->status == 'unapproved')
      <button disabled="disabled" class="btn btn-outline-danger">応募は否認されました</button>
      @endif
      @else
      <button type="button" class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#collapseConsult">お見積りやサービス内容の相談をする</button>

      <div class="collapse" id="collapseConsult">
        <form action="{{route('service.consult')}}" method="post">
          @csrf
          <input type="hidden" name="buy_user" value="{{$user_id}}">
          <input type="hidden" name="sell_user" value="{{ $item->offer_user_id }}">
          <input type="hidden" name="service_id" value="{{ $item->id }}">
          <textarea name="first_chat" id="first_chat" cols="80" rows="10" class="text-start m-3">※必ず記載してください。
            </textarea>
          <button type="submit" class="btn btn-primary col-3">送信する</button>
        </form>
      </div>
    </div>
    @endif

    @elseif($item->offer_user_id == $user_id)
    @if($item->edit == true)
    <div class="text-center my-1">
      <button class=" btn btn-primary" onclick=location.href="{{route('mypage.service.edit',['service_id'=>$item->id])}}">編集する</button>
    </div>
    @else
    <div class="text-center my-1">
      <button class=" btn btn-primary" disabled>編集する</button>
      <span>進行中の依頼があるためサービスの内容を編集できません</span>
    </div>
    @endif
    @if($entry)
    <div class="text-center">
      <a href="{{route('service.entried', ['service_id'=> $item->id])}}" class="fs-4">正式な依頼が届いています</a>
    </div>
    @endif
    @endif


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
    @endsection