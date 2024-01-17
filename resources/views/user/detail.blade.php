@extends('layouts.app')

@section('content')
<div class="container">
  <button class="btn btn-primary" onClick="location.href='{{route('mypage.favorite.follow')}}'">お気に入り・フォローリスト</button>
  <div>
    @if($item->follow == false)
    <form method="POST" action="{{ route('follow',['follower_id'=> $item->id]) }}">
      @csrf
      <button type="submit" class="btn btn-success my-1">
        <small>{{$item->nickname}}をフォローする</small>
      </button>
    </form>
    @else
    <form action="{{route('unfollow',['follower_id'=>$item->id])}}" method="post">
      @csrf
      <button class="btn btn-outline-success my-1">
        <small>{{$item->nickname}}のフォローを解除する</small>
      </button>
    </form>
    @endif
  </div>
  <table class="table">
    <div>
      @if($item->img_url == null)
      <p>イメージ画像なし</p>
      @else
      <img src="{{ asset($item->img_url) }}" alt="" class="profile-img">
      @endif
    </div>
    <tr>
      <th>アカウント名</th>
      <td>
        {{$item->nickname}}（フォロワー：{{$follower_count}} 販売実績：{{$sales_record_count}}件）
      </td>
    </tr>
    <tr>
      <th>年齢</th>
      <td>
        @if ($item->age >= 10 && $item->age < 20) 10代 @elseif ($item->age >= 20 && $item->age < 30) 20代 @elseif ($item->age >= 30 && $item->age < 40) 30代 @elseif ($item->age >= 40 && $item->age < 50) 40代 @elseif ($item->age >= 50 && $item->age < 60) 50代 @elseif ($item->age >= 60 && $item->age < 70) 60代 @elseif ($item->age >= 70 && $item->age < 80) 70代 @elseif ($item->age >= 80 && $item->age < 90) 80代 @elseif ($item->age >= 90 && $item->age < 100) 90代 @else その他の年齢 @endif </td>
    </tr>
    <tr>
      <th>性別</th>
      <td>
        {{$item->gender_name}}
      </td>
    </tr>
    <tr>
      <th>住んでいる地域</th>
      <td>
        {{$item->living_area}}
      </td>
    </tr>
    <tr>
      <th>自己紹介</th>
      <td>
        {{$item->message}}
      </td>
  </table>
  <div class="mt-3">
    <div class="col-lg-10 order-lg-2 order-1">
      <!-- New Arrivals -->
      <section class="new-arrivals-section">

        <div class="row">
          <div class="col-7">
            <h2 class="section-title fw-bold">{{$item->nickname}}さんの出品サービス</h2>
          </div>

        </div>
        <div class="card-items">
          @foreach($supply_services as $supply_service)
          <div class="card-item">
            <a class="card mb-4 text-decoration-none" href="{{ route('service.detail',['service_id'=>$supply_service->id]) }}">
              <div class="service-card">
                <img src="{{asset($supply_service->photo_1)}}" class="card-img-top" alt="image_photo">
              </div>
              <div class="card-body">
                <div class="category-parent">
                  @foreach($supply_service->categories as $value)
                  <small class="text-ellipsis d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
                  @endforeach
                </div>

                <p class="fw-bolder text-ellipsis">{{$supply_service->main_title}}</p>

                <div class="row align-items-center px-1">
                  <div class="col-5">
                    <div class="rounded-circle overflow-hidden d-flex" style="width: 40px; height: 40px; padding: 0;">
                      <img src="{{ asset($item->profile_image) }}" alt="" style="max-width: 100%; max-height: 100%;">
                    </div>
                  </div>

                  <div class="col-7 fs-7 text-secondary">{{ $supply_service->price }}円</div>
                </div>
              </div>
            </a>
          </div>
          @endforeach

        </div>
        @if($supply_services->count() >= 5)
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
              <h2 class="section-title fw-bold">{{$item->nickname}}さんの公開依頼</h2>
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
                        <img src="{{ asset($item->profile_image) }}" alt="" style="max-width: 100%; max-height: 100%;">
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
@endsection