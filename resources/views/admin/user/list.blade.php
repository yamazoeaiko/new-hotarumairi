@extends('layouts.admin')
@section('content')
<div class="container">
  <h5>【管理画面】ユーザー（一覧）</h5>
  <div class="list-group">
    @if($items == null)
    登録しているユーザーはいません
    @endif
    @foreach($items as $item)
    <button class="list-group-item list-group-action" onClick="location.href='{{route('admin.user.detail',['user_id'=>$item->id])}}'">
      <div class="no-gutters">
        <div class="row">
          <div class="col-2">
            <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <img src="{{ asset($item->img_url) }}" alt="profile_image" class="w-100 h-100">
            </div>
          </div>
          <div class="col-2 fs-5">
            ID：{{ $item->id }}
          </div>
          <div class="col-4">
            <p class="font-weight-bold mb-0">{{ $item->nickname }}</p>
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