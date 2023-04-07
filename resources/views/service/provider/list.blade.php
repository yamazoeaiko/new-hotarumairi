@extends('layouts.app')

@section('content')
<div class="container">
  <div class="my-5">
    <h5>出品サービス管理画面</h5>
    <button class="btn btn-primary" onClick="location.href='{{ route('service.create') }}'">サービスを出品する</button>
    @if($items->isEmpty())
    <div>
      <span>現在あなたが出品しているサービスはございません</span>
    </div>
    @endif
    <div class="list-group">
      @foreach($items as $item)
      <button onClick="location.href='{{route('service.detail', ['service_id' => $item->id])}}'" class="list-group-item list-group-item-action">
        <div class="row">
          <div class="col-8 fw-bolder fs-5">{{$item->main_title}}</div>
          <div class="col-4">サービス価格：{{$item->price}}円（税別）</div>
        </div>
        <div class="row">
          <p class="text-muted small text-left ml-auto" style="text-align: left !important;">{{ $item->content }}</p>
        </div>
      </button>
      @endforeach
    </div>
  </div>
  <div class="my-5">
    <h5>公開した依頼</h5>
    @if($requests->isEmpty())
    <div>
      <span>現在あなたが公開している依頼はございません</span>
    </div>
    @endif
    <div class="list-group">
      @foreach($requests as $request)
      <button onClick="location.href='{{route('search.more', ['service_id' => $request->id])}}'" class="list-group-item list-group-item-action">
        <div class="row">
          <div class="col-8 fw-bolder fs-5">{{$request->main_title}}</div>
          <div class="col-4">予算：{{$request->price}}円（税別）</div>
        </div>
        <div class="row">
          <p class="text-muted small text-left ml-auto" style="text-align: left !important;">{{ $request->content }}</p>
        </div>
      </button>
      @endforeach
    </div>
  </div>
  <div class="my-3">
    <h5>見積もり・内容相談など</h5>
    @if(count($consults)== 0)
    <span>出品サービスへの相談はありません。</span>
    @else
    @foreach($consults as $consult)
    <button onClick="location.href='{{route('chat.room', ['room_id' => $room->id])}}'" class="list-group-item list-group-item-action">
      <div class="no-gutters">
        <div class="row">
          <div class="col-2">
            <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <img src="{{ asset($consult->profile_img) }}" alt="" class="w-100 h-100">
            </div>
          </div>
          <div class="col-6">
            <h5 class="font-weight-bold mb-0">{{ $consult->consulting_user_name }}</h5>
          </div>
          <div class="col-4 text-right">
            <p class="text-muted small">{{ date('Y年m月d日h時m分', strtotime($consult->created_at)) }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-2"></div>
          <div class="col-6">
            <p class="text-muted fw-bolder fs-5 text-left ml-auto">{{ $consult->service_name }}
            </p>
          </div>
          <div class="col-3 text-right">
            @if($consult->status =='pending')
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">相談中
            </small>
            @elseif($consult->status =='estimate')
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">正式な依頼あり
            </small>
            @elseif($consult->status =='approved')
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">依頼成立(支払い未対応)
            </small>
            @elseif($consult->status =='unapproved')
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">依頼お断り済み
            </small>
            @elseif($consult->status =='paid')
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">支払い対応完了
            </small>
            @elseif($consult->status =='deliverd')
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">納品完了
            </small>
            @endif
          </div>
        </div>
      </div>
    </button>
    @endforeach
    @endif
  </div>
</div>
@endsection