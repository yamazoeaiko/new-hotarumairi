@extends('layouts.app')

@section('content')
<div class="container">
  <div>
    <h5 class="my-2 fw-bold">あなたが依頼している代行一覧</h5>
    @if($items->isEmpty())
    <span>現在あなたが依頼している代行はございません</span>
    @endif
    <div class="list-group">
      @foreach($items as $item)
      <button onClick="location.href='{{route('mypage.myrequest.detail', ['service_id' => $item->id])}}'" class="list-group-item list-group-item-action">
        <div class="row">
          <div class="col-8 fw-bolder fs-5">{{$item->plan_name}}</div>
          <div class="col-8">日程：{{$item->date_begin}}〜{{$item->date_end}}</div>
          <div class="col-4">費用：{{$item->price}}円（税別）</div>
          <span class="col-8 fs-6">
            @if($item->status_id == 1)
            {{$item->apply_count}}名からの応募があります【募集中】
            @elseif($item->status_id == 2)
            応募者は確定しております。<br>お支払いが完了すると応募者は作業できる状態になります。
            @elseif($item->status_id == 3)
            支払い手続きが完了しています。
            @else
            未設定の状況
            @endif
          </span>
        </div>

      </button>
      @endforeach
    </div>
  </div>
</div>
@endsection