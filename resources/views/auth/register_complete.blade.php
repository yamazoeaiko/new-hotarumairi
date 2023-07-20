@extends('layouts.app')
@section('content')
<div class="container">
  <div class="text-center">
    <p class="fs-4 text-primary fw-bold">
      新規登録が完了しました！
    </p>
    <button class="btn btn-outline-primary my-4" onClick="location.href='{{route('toppage')}}'">ホーム画面に戻る</button>
  </div>
</div>
@endsection