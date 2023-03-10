@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-grid gap-4">
    <button onclick="location.href='{{route('myprofile.index')}}'" class="btn btn-primary p-3">
      プロフィール
    </button>
    <button onclick="location.href='{{route('mypage.myrequest.index')}}'" class="btn btn-primary p-3">
      依頼している案件の確認
    </button>
    <button onclick="location.href='{{route('mypage.myapply.index')}}'" class="btn btn-primary p-3">
      代行を引き受ける案件の確認
    </button>
    <button onclick="location.href='{{route('mypage.service.list')}}'" class="btn btn-primary p-3">
      出品サービスの管理
    </button>
  </div>
</div>
@endsection