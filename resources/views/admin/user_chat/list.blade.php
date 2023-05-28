@extends('layouts.admin')

@section('content')
<div class="container">
  <h4>【管理画面】ユーザー同士のチャットルーム一覧</h4>
  <div class="list-group">
    @if($items)
    @foreach($items as $item)
    <button class="list-group-item list-group-action " onClick="location.href='{{route('admin.user.chat.room',['room_id'=>$item->id])}}'">
      <div class="no-gutters">
        <div class="row">
          <div class="col-8">
            <h6 class="font-weight-bold mb-0">{{ $item->service_name }}</h6>
          </div>
          <div class="col-4 text-right">
            <p class="text-muted small">{{ $item->create }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <p class="fs-6 text-primary">販売者：{{ $item->sell_user }}
            </p>
            <p class="fs-6 text-success">購入者：{{ $item->buy_user }}
            </p>
          </div>
          <div class="col-4">
            @if($item->stopping)
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 px-2 py-1 bg-danger fw-bolder text-white">{{ $item->stopping }}</small>
            @endif
            <div>
            @if($item->entry_status)
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success fw-bolder">{{ $item->entry_status }}</small>
            @endif
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