@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-grid gap-4">
    <button onclick="location.href='{{route('myprofile.index')}}'" class="btn btn-primary p-3">
      プロフィール
    </button>
    <button onclick="location.href='{{route('mypage.service.list')}}'" class="btn btn-primary p-3">
      出品サービス・見積もり提案中の管理
    </button>
    <button onclick="location.href='{{route('mypage.pubreq.list')}}'" class="btn btn-primary p-3">
      公開依頼・相談中案件の管理
    </button>
    <button onclick="location.href='{{route('mypage.favorite.follow')}}'" class="btn btn-primary p-3">
      フォロー・お気に入り
    </button>
    <button onclick="location.href='{{route('payment.information')}}'" class="btn btn-primary p-3">
      支払い情報
    </button>
    <button onclick="location.href='{{route('proceeds.information')}}'" class="btn btn-primary p-3">
      売上情報
    </button>
  </div>
</div>
@endsection