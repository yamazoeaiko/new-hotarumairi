@extends('layouts.app')

@section('content')
<div class="container">
  <h4 class="fw-bold fs-5">【出品者側】チャットルーム一覧</h4>
  <button class="my-3 btn btn-primary" onClick="location.href='{{ route('chat.list') }}'">購入者側のチャットに切り替える</button>
  <div class="list-group">
    @if($items)
    @foreach($items as $item)
    <button class="list-group-item list-group-action" onClick="location.href='{{route('chat.room',['room_id'=>$item->id])}}'">
      <div class="no-gutters">
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
      </div>
    </button>
    @endforeach
    @else
    <div class="text-center">
      <span>現在チャットルームはございません</span>
    </div>
  </div>
  @endif
</div>
@endsection