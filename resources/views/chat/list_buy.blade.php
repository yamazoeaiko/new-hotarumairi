@extends('layouts.app')

@section('content')
<div class="container">
  <h4 class="fw-bold fs-5">【購入者側】チャットルーム一覧</h4>
  <button class="btn btn-primary my-3" onClick="location.href='{{ route('chat.list.sell') }}'">出品者側のチャットに切り換える</button>

  @if($items)
  <div class="list-group">
    @foreach($items as $item)
    <button class="list-group-item list-group-action " onClick="location.href='{{route('chat.room',['room_id'=>$item->id])}}'" @if($item->status=='stopping') disabled @endif />
      <div class="row">
        <div class="col-2">
          <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
            <img src="{{ asset($item->theother_profile) }}" alt="" class="w-100 h-100">
          </div>
        </div>
        <div class="col-2">
          <p class="fw-bold mb-0">{{ $item->theother_name }}</p>
        </div>
        <div class="col-4">
          <p class="fw-bold mb-0">{{ $item->service_name }}</p>
        </div>
        <div class="col-4 text-right">
          <p class="text-muted small">{{ $item->create }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-1"></div>
        <div class="col-7">
          <p class="text-muted small text-left ml-auto" style="text-align: left !important;">{{ $item->latest_message }}
          </p>
        </div>
        <div class="col-3">
          <div class="row">
            @if($item->entry_status)
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success fw-bolder">{{ $item->entry_status }}</small>
            @endif
          </div>
          <div class="row">
            <div class="d-flex justify-content-between">
              @if ($item->user_type == 'sell_user')
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border border-primary mb-1 p-1 bg-primary text-white fw-bolder">出品者側</small>
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border border-light mb-1 p-1 text-secondary fw-bolder">購入者側</small>
              @elseif ($item->user_type == 'buy_user')
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border border-light mb-1 p-1 text-secondary fw-bolder">出品者側</small>
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border border-primary mb-1 p-1 bg-primary text-white fw-bolder">購入者側</small>
              @endif
            </div>

          </div>
        </div>
      </div>
      @if($item->status=='stopping')
      <div class="row">
        <small class=" col-4 d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-danger">チャット停止中</small>
        <div class="col-7 fs-7">※運営者判断で現在停止中です</div>
      </div>
      @endif
    </button>
    @endforeach
  </div>
  @else
  <div class="text-center">
    <span>現在チャットルームはございません</span>
  </div>
@endif
</div>
@endsection