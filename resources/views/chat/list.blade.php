@extends('layouts.app')

@section('content')
<div class="container">
  <h4>チャットグループ一覧</h4>
  <div class="list-group">
    @foreach($items as $item)
    <button class="list-group-item list-group-action" onClick="location.href='{{route('chat.room',['room_id'=>$item->id, 'theother_id'=>$item->theother_id])}}'">
      <div class="no-gutters">
        <div class="row">
          <div class="col-2">
            <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <img src="{{ asset($item->theother_profile) }}" alt="" class="w-100 h-100">
            </div>
          </div>
          <div class="col-6">
            <h5 class="font-weight-bold mb-0">{{ $item->theother_name }}</h5>
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
          <div class="col-2">
            @if($item->status_name == '取引中')
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success fw-bolder">{{ $item->status_name }}</small>
            @else
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $item->status_name }}</small>
            @endif
          </div>
        </div>
      </div>
    </button>
    @endforeach
  </div>
</div>
@endsection