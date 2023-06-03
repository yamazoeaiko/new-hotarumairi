@extends('layouts.admin')
@section('content')
<div class="container">
  <h5>【管理画面】サービス（一覧）</h5>
  <div class="list-group">
    @if($items == null)
    登録しているサービスはありません
    @endif
    @foreach($items as $item)
    <button class="list-group-item list-group-action" onClick="location.href='{{route('admin.service.detail',['service_id'=>$item->id])}}'">
      <div class="no-gutters">
        <div class="row">
          <div class="col-2 fs-7">
            ID：{{ $item->id }}
          </div>
          <div class="col-6">
            <p class="fw-bold mb-0">タイトル：{{ $item->main_title }}</p>
            <p class=" mb-0">ユーザー：{{ $item->provider_name }}</p>
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