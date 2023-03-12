@extends('layouts.app')

@section('content')
<div class="container row">
  <div class="col-10">
    <h5>あなたが依頼している代行一覧</h5>
    @if($items->isEmpty())
    <span>現在応募者はいません。</span>
    @endif
    <div class="list-group">
      @foreach($items as $item)
      @if($item->approved_sign == true)
      <button onClick="location.href='{{route('mypage.myrequest.member_detail', ['request_id'=>$item->request_id, 
         'user_id' => $item->apply_user_id,
         'apply_id' => $item->id])}}'" class="list-group-item list-group-item-action bg-success">
        <div class="row">
          <div class="col-4"><img src="{{ asset($item->profile_img) }}" alt="Profile Image" class="card-img">
          </div>
          <div class="col-6">
            <div class="row fw-bolder fs-5">{{$item->nickname}}<span class="m-0">応募承認済み</span></div>
            <div class="row">応募日時：{{$item->created_at}}</div>
          </div>
        </div>
      </button>
      @else
      <button onClick="location.href='{{route('mypage.myrequest.member_detail', ['request_id'=>$item->request_id, 
         'user_id' => $item->apply_user_id,
         'apply_id' => $item->id])}}'" class="list-group-item list-group-item-action">
        <div class="row">
          <div class="col-4"><img src="{{ asset($item->profile_img) }}" alt="Profile Image" class="card-img">
          </div>
          <div class="col-6">
            <div class="row fw-bolder fs-5">{{$item->nickname}}</div>
            <div class="row">応募日時：{{$item->created_at}}</div>
          </div>
        </div>
      </button>
      @endif
      @endforeach
    </div>
  </div>
</div>
@endsection