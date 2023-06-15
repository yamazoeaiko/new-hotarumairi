@extends('layouts.app')
@section('content')
<div class="container">
  <h5>お気に入りしたサービス一覧</h5>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
    @foreach($favorites as $favorite)
    <div class="col">
      <div class="card mb-4">
        <div class="service-card">
          <img src="{{asset($favorite->photo_1)}}" class="card-img-top" alt="image_photo">
        </div>
        <div class="card-body">
          @foreach($favorite->categories as $value)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
          @endforeach
          <h5 class="fs-6 fw-bolder">{{$favorite->main_title}}</h5>
          <div class="row align-items-center">
            <div class="col-4 d-flex fs-7">
              {{$favorite->provider_name }}
            </div>
            <div class="col-4 fs-7 text-secondary text-md-center">{{ $favorite->price }}円</div>
            <div class="col-4 text-md-end">
              <a href="{{ route('service.detail',['service_id'=>$favorite->favorite_id]) }}" class="btn btn-primary fs-7">詳細</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <h5>フォローしたユーザーアカウント一覧</h5>
  <div class="list-group">
    @if($follows)
    @foreach($follows as $follow)
    <button class="list-group-item list-group-action " onClick="location.href='{{route('user.detail',['user_id'=>$follow->follow_id])}}'">
      <div class="no-gutters">
        <div class="row">
          <div class="col-2">
            <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <img src="{{ asset($follow->img_url) }}" alt="" class="w-100 h-100">
            </div>
          </div>
          <div class="col-4">
            <h5 class="font-weight-bold mb-0">{{ $follow->user_name }}</h5>
          </div>
          <div class="col-3">出品サービス数：{{ $follow->count_services }}</div>
      </div>
  </div>
  </button>
  @endforeach
  @elseif($follows->isEmpty())
  <div class="text-center">
    <span>フォローしているアカウントはありません</span>
  </div>
</div>
@endif
</div>
@endsection