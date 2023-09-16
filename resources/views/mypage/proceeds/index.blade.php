@extends('layouts.app')
@section('content')
<div class="container">
  <div class="my-4">
    <h5 class="fw-bold fs-5 text-primary">売上情報</h5>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">購入者</th>
          <th scope="col">サービス</th>
          <th scope="col">購入日</th>
          <th scope="col">金額（振り込まれる金額）</th>
          <th scope="col">返金(キャンセルの場合)</th>
          <th scope="col">振込</th>
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
          <td>{{ $proceed->transfer_status }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="my-4">
    <h6 class="fw-bold fs-5 text-primary">未振込の売り上げ金額</h6>
    <table class="table">
      <tr>
        <th>振込申請可能金額</th>
        <td>{{ $before_transfer_proceeds }}円</td>
      </tr>
      <tr>
        <th class="fw-normal">振込申請済み金額</th>
        <td>{{ $applied_transfer_proceeds }}円</td>
      </tr>
    </table>
    @if($before_transfer_proceeds > 999)
    <div class="my-4 text-center">
      <form action="{{route('offer.transfer')}}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{$user_id}}">
        <button type="submit" class="btn btn-primary" onclick="return confirm('申請すると取り消しできないですが、よろしいですか？')">
          振り込み申請する
        </button>
      </form>
      <div class="fs-7 text-danger">
        ※申請すると取り消しはできません。<br>
        ※振込手数料が一律２００円差し引かれます。
      </div>
    </div>
    @else
    <div class="my-4 text-center">
      <button class="btn btn-primary" disabled>
        振り込み申請する
      </button>
      <div class="fs-7 text-danger">
        振込申請可能金額が1,000円以上で申請可能になります。
      </div>
    </div>
    @endif
  </div>
  <div class="my-4 text-center">
    <a href="{{route('mypage.bank.index')}}" class="link-primary"><u>振込先口座情報を確認する</u></a>
  </div>
</div>
@endsection