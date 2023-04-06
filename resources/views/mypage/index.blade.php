@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-grid gap-4">
    <button onclick="location.href='{{route('myprofile.index')}}'" class="btn btn-primary p-3">
      プロフィール
    </button>
    <button onclick="location.href='{{route('mypage.service.list')}}'" class="btn btn-primary p-3">
      出品サービスの管理
    </button>
  </div>
</div>
@endsection