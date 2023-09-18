@extends('layouts.admin')
@section('content')
<div class="container">
  <h5 class="my-2 fw-bold">【管理画面】キャンセル申請（詳細）</h5>
  <div class="form-control">
    <div class="form-control mb-3">
      <label for="experience_name" class="fw-bolder">サービスタイトル</label>
      <input class="form-control" value="{{ $item->main_title }}" readonly>
    </div>
    <div class="form-control mb-3">
      <label for="sell_user_name" class="fw-bolder">販売アカウント名</label>
      <input class="form-control" value="{{ $item->sell_user_name }}" readonly>
    </div>
    <div class="form-control mb-3">
      <label for="buy_user_name" class="fw-bolder">購入アカウント名</label>
      <input class="form-control" value="{{ $item->buy_user_name }}" readonly>
    </div>
    <div class="form-control mb-3">
      <label for="include_tax_price" class="fw-bolder">お支払い金額(税込)</label>
      <div class="input-group">
        <input type="number" class="form-control" value="{{$item->include_tax_price}}" readonly>
        <div class="input-group-append">
          <span class="input-group-text">円（税込）</span>
        </div>
      </div>
    </div>
    <div class="form-control mb-3">
      <label for="payment_id" class="fw-bolder">支払いNo.</label>
      <input class="form-control" value="{{ $item->payment_id }}" readonly>
    </div>
    <!--
    <div class="form-control mb-3">
      <label for="provider_name" class="fw-bolder">キャンセル申請者</label>
      <input class="form-control" value="{{ $item->cancel_user_name }}" readonly>
    </div>
-->
  </div>
  @if($item->status_name == 'cancel_pending')
  <div class="d-flex">
    <form action="{{ route('admin.cancel.approved') }}" method="post">
      @csrf
      <input type="hidden" name="cancel_id" value="{{$item->id}}">
      <div class="text-center my-3 mx-1">
        <button class="btn btn-danger" type="submit" onclick="return confirm('キャンセルを承認しますか？')">キャンセル処理する（承認）</button>
      </div>
    </form>
    <form action="{{ route('admin.cancel.unapproved') }}" method="post">
      @csrf
      <input type="hidden" name="cancel_id" value="{{$item->id}}">
      <div class="my-3 text-center mx-1">
        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('キャンセルを否認しますか？')">
          キャンセル不可（否認）
        </button>
      </div>
    </form>
  </div>
  @endif
  @if($item->status_name == 'canceled')
  <div class="text-center">
    <p class="fs-6 fw-bolder text-danger">キャンセル承認済み</p>
  </div>
  @endif
  @if($item->status_name == 'paid')
  <div class="text-center">
    <p class="fs-6 fw-bolder text-danger">キャンセルを取り消しました</p>
  </div>
  @endif
  <button class="btn btn-secondary" onClick="location.href='{{route('admin.cancel.offer.list')}}'">戻る</button>
</div>
@endsection