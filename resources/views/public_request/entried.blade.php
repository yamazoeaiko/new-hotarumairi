@extends('layouts.app')

@section('content')
<div class="container">
  <h4>応募者一覧</h4>
  <div class="list-group">
    @foreach($entrieds as $entried)
    <div class="card list-group-item list-group-action">
      <div class="no-gutters">
        <div class="row">
          <div class="col-2">
            <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
              <img src="{{ asset($entried->profile_image) }}" alt="" class="w-100 h-100">
            </div>
          </div>
          <div class="col-4">
            <h5 class="font-weight-bold mb-0">{{ $entried->user_name }}</h5>
          </div>
          <div class="col-4 text-right">
            <p class="text-muted small">応募日：{{\Carbon\Carbon::parse($entried->created_at)->format('Y年m月d日') }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-1"></div>
          <div class="col-7">
            <p class="text-muted small text-left ml-auto" style="text-align: left !important;">{{ $entried->message }}
            </p>
          </div>
        </div>
        @if($entried->status == 'estimate')
        <div class="d-flex">
          <div class="mx-2">
            <form action="{{route('pubreq.approve')}}" method="post">
              @csrf
              <input type="hidden" name="entry_id" value="{{$entried->id}}">
              <input type="hidden" name="service_id" value="{{$service->id}}">
              <input type="hidden" name="buy_user" value="{{$user_id}}">
              <input type="hidden" name="sell_user" value="{{$entried->sell_user}}">
              <button type="submit" class="btn btn-primary">正式に依頼する</button>
            </form>
          </div>

          <div class="mx-2">
            <form action="{{route('pubreq.unapprove')}}" method="post">
              @csrf
              <input type="hidden" name="entry_id" value="{{$entried->id}}">
              <input type="hidden" name="service_id" value="{{$service->id}}">
              <input type="hidden" name="buy_user" value="{{$user_id}}">
              <input type="hidden" name="sell_user" value="{{$entried->sell_user}}">
              <button type="submit" class="btn btn-outline-danger">お断りする</button>
            </form>
          </div>
          @elseif($entried->status == 'approved')
          <div class="row">
            <span>承認済みです。お支払いの対応をして下さい。</span>
          </div>
          <div class="d-flex">
            <div class="mx-2"><button class="btn btn-danger" onClick="location.href='{{route('payment', ['entry_id' => $entried->id])}}'">お支払い画面</button>
          </div>
            <div class="mx-2"><button class="btn btn-outline-danger">キャンセルする</button></div>
          </div>
          @elseif($entried->status == 'unapproved')
          <div class="text-center">
            <span>お断り済みです</span>
          </div>
          @elseif($entried->status == 'paid')
          <div class="text-center">
            <div class="row">
              <span>お支払い済みです。対応者からの実施連絡をお待ちください。</span>
            </div>
            <div class="d-flex">
              <button class="btn btn-danger" disabled>お支払い完了</button>
              <button class="btn btn-outline-danger">キャンセルする</button>
            </div>
          </div>
          @endif
          <div class="mx-2">
            <button class="btn btn-secondary" onclick=location.href="{{route('user.profile',['user_id'=>$entried->id])}}">プロフィールを確認する</button>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endsection