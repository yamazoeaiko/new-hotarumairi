@extends('layouts.admin')
@section('content')
<div class="container">
  <div class="d-flex">
    <button class="btn btn-outline-primary mx-2" onClick="location.href='{{route('admin.identification.offer.list')}}'">未対応リスト</button>
    <button class="btn btn-outline-danger mx-2" onClick="location.href='{{route('admin.identification.unapproved.list')}}'">否認済みリスト</button>
  </div>
  <h5 class="my-3">【管理画面】本人確認証明書　承認済み（一覧）</h5>
  <div class="list-group">
    @if($items == null)
    承認済みの本人確認証明書の申請はありません。
    @endif
    @foreach($items as $item)
    <button class="list-group-item list-group-action" onClick="location.href='{{route('admin.identification.detail',['identification_id'=>$item->id])}}'">
      <div class="no-gutters">
        <div class="row">
          <div class="col-2">
            <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <img src="{{ asset($item->profile_image) }}" alt="profile_image" class="w-100 h-100">
            </div>
          </div>
          <div class="col-2 fs-5">
            ユーザーID：{{ $item->user_id }}
          </div>
          <div class="col-4">
            <p class="fs-5 fw-bold mb-0">ご本人氏名{{ $item->user_name }}</p>
            <p class="fs-7  mb-0">ニックネーム{{ $item->user_nickname }}</p>

          </div>
          <div class="col-4 text-right">
            <p class="text-muted small">登録日：<br>{{ \Carbon\Carbon::parse($item->created_at)->format('Y年m月d日 H時i分') }}</p>
          </div>
        </div>
      </div>
    </button>
    @endforeach
  </div>
</div>
@endsection