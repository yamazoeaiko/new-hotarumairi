@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-grid gap-4">
    <button onclick="location.href='{{route('service.request')}}'" class="btn btn-primary p-3">
     公開依頼を作成する
    </button>
    <button onclick="location.href='{{route('service')}}'" class="btn btn-primary p-3">
      サービスを探す
    </button>
  </div>
</div>
@endsection