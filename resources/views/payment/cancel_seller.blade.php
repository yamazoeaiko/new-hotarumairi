@extends('layouts.app')
@section('content')
<div class="container">
  <h5>キャンセル申請画面</h5>
  <h6 class="fw-bolder mt-3">予約内容</h6>
  <table class="table">
    <tr>
      <th>出品サービス名</th>
      <td>{{ $item->main_title }}</td>
    </tr>
    <tr>
      <th>見積もり金額（税込）</th>
      <td>{{ $item->include_tax_price }}円</td>
    </tr>
    <tr>
      <th>購入者支払い日</th>
      <td>{{ $item->create }}</td>
    </tr>
  </table>
  <div class="text-center">
    <form action="{{ route('cancel.offer.seller') }}" method="post">
      @csrf
      <input type="hidden" name="user_id" value="{{ $item->user_id }}">
      <input type="hidden" name="entry_id" value="{{ $item->entry_id}}">
      <input type="hidden" name="agreement_id" value="{{ $item->id }}">
      <input type="hidden" name="payment_id" value="{{ $item->payment_id }}">
      <button type="submit" class="btn btn-danger p-2">キャンセルを申請する</button>
      <div class="fs-7 text-danger">購入者との合意のもと、キャンセル申請をしてください。<br>運営側で問題ないことを確認した後、返金対応いたします。</div>
    </form>
  </div>
</div>
@endsection