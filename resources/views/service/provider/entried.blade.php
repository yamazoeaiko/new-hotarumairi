@extends('layouts.app')

@section('content')
<div class="container">
  <h4>正式な依頼が届いています</h4>
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
            <p class="text-muted small">依頼日：{{\Carbon\Carbon::parse($entried->created_at)->format('Y年m月d日') }}</p>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-1"></div>
          <div class="col-10 fw-bolder">
            出品サービス名：{{ $service->main_title }}
          </div>
        </div>
        @if($entried->status == 'estimate')
        
          @elseif($entried->status == 'approved')
          <div class="row">
            <span>承認しました。相手方の支払い対応待ちです。</span>
          </div>
          <div class="d-flex">
            <div class="mx-2"><button class="btn btn-outline-danger">キャンセルする</button></div>
          </div>
          @elseif($entried->status == 'unapproved')
          <div class="text-center">
            <span>お断り済みです</span>
          </div>
          @elseif($entried->status == 'paid')
          <div class="text-center">
            <div class="row">
              <span>相手方の支払い対応が完了しました。期日までに納品連絡を行なって下さい。</span>
            </div>
            <div class="d-flex">
              <button class="btn btn-success">納品報告をする</button>
            </div>
          </div>
          @endif
          <div class="mx-2">
            <button class="btn btn-secondary" onclick=location.href="{{route('user.profile',['user_id'=>$entried->buy_user])}}">プロフィールを確認する</button>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endsection