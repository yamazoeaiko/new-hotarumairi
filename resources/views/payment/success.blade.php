@extends('layouts.app')
@section('content')
<div class="container">
  <div class="text-center">
    <p class="text-primary fs-5 fw-bolder">お支払いが完了しました。</p>
    <div class="my-4">
      <button class="btn btn-success" onClick="location.href='{{route('chat.room', ['room_id' => $room->id])}}'">チャットに戻る</button>
    </div>
  </div>
</div>
@endsection