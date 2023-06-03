@extends('layouts.admin')
@section('content')
<div class="container">
  <h5>【管理画面】キャンセルリクエスト一覧</h5>
  <div class="list-group">
    @if($items->isEmpty())
    未対応のキャンセルリクエストはありません。
    @endif
    @foreach($items as $item)
    <button class="list-group-item list-group-action" onClick="location.href='{{route('admin.cancel.offer.detail',['agreement_id'=>$item->id])}}'">
      <div class="no-gutters">
        <div class="row">
          <div class="col-8">
            <span class="fs-7">サービス名</span>
            <span class="fs-5 fw-bolder">{{$item->main_title}}</span>
          </div>
          <div class="col-4 text-right">
            <p class="text-muted small">キャンセル申請日：<br>{{ \Carbon\Carbon::parse($item->created)->format('Y年m月d日 H時i分') }}</p>
          </div>
        </div>
        <div class="row px-2">
          <div class="col d-flex"><span class="fs-7 fw-bolder">購入者：</span><span class="fs-6">{{$item->buy_user_name}}</span></div>

          <div class="col d-flex"><span class="fs-7 fw-bolder offset-2">販売者：</span><span class="fs-6">{{$item->sell_user_name}}</span></div>
        </div>
      </div>
    </button>
    @endforeach
  </div>
</div>
</div>
@endsection