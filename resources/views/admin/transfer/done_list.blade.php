@extends('layouts.admin')
@section('content')
<div class="container">
  <h5 class="my-2 fw-bold fs-5">【管理画面】振込一覧（振込済み）</h5>
  <div class="d-flex justify-content-around my-2">
    <button class="btn btn-outline-primary" onClick="location.href='{{ route('admin.transfer.offer.list') }}'">
      リクエスト
    </button>
    <button class="btn btn-primary" onClick="location.href='{{ route('admin.transfer.done.list') }}'" disabled>
      振込済み
    </button>
    <button class="btn btn-outline-primary" onClick="location.href='{{ route('admin.transfer.list') }}'">
      すべて
    </button>
  </div>
  <div class="list-group">
    @if($items->isEmpty())
    振込履歴はありません。
    @endif
    @foreach($items as $item)
    <button class="list-group-item list-group-action" onClick="location.href='{{route('admin.transfer.detail',['user_id'=>$item->sell_user])}}'">
      <div class="no-gutters">
        <div class="row">
          <div class="col-8">
            <span class="fs-7">アカウント名</span>
            <span class="fs-5 fw-bolder">{{$item->nickname}}</span>
          </div>
          <div class="col-4 text-right">
            <p class="text-muted small">振込申請日：<br>{{ \Carbon\Carbon::parse($item->updated_at)->format('Y年m月d日 H時i分') }}</p>
          </div>
        </div>
        <div class="row px-2">
          <div class="col d-flex"><span class="fs-7 fw-bolder">振込金額：</span><span class="fs-6">{{$item->transfer_price}}</span></div>
        </div>
        <div>
          <small class="rounded-pill border mb-1 p-1">{{ $item->status_name}}</small>
        </div>
      </div>
    </button>
    @endforeach
  </div>
</div>
</div>
@endsection