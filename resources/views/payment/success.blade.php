@extends('layouts.app')
@section('content')
<div class="container">
  <div class="text-center">
    <p>（文字大きくする）支払い処理が完了しました。</p>
    <div class="my-4">
      <button class="btn btn-success" onClick="location.href='{{route('pubreq.entried', ['service_id' => $entry->service_id])}}'">体験イベント詳細を確認する</button>
    </div>
  </div>
</div>
@endsection