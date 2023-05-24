@extends('layouts.app')
@section('content')
<div class="container">
  <h5 class="mb-3">売上情報</h5>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">購入者</th>
        <th scope="col">サービス</th>
        <th scope="col">購入日</th>
        <th scope="col">金額（振り込まれる金額）</th>
        <th scope="col">返金(キャンセルの場合)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($proceeds as $index => $proceed)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $proceed->buyer_name }}</td>
        <td>{{ $proceed->service_name }}</td>
        <td>{{ \Carbon\Carbon::parse($proceed->created_at)->format('Y年m月d日') }}</td>
        <td>{{ $proceed->price_net }}円</td>
        <td>{{ $proceed->cancel_fee ? $proceed->cancel_fee . '円' : '0円' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection