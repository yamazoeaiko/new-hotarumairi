@extends('layouts.app')
@section('content')
<div class="container">
  <h5 class="mb-3">支払い情報</h5>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">支払い先</th>
        <th scope="col">サービス</th>
        <th scope="col">支払い日</th>
        <th scope="col">金額(税込)</th>
        <th scope="col">返金(キャンセルの場合)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payments as $index => $payment)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $payment->provider_name }}</td>
        <td>{{ $payment->service_name }}</td>
        <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('Y年m月d日') }}</td>
        <td>{{ $payment->include_tax_price }}円</td>
        <td>{{ $payment->cancel_fee ? $payment->cancel_fee . '円' : '0円' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection