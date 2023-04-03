@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card mb-4">
    <div class="row g-0 align-items-center">
      <div class="col-md-3 text-center">
        @if($item->img_url == null)
        <p>イメージ画像なし</p>
        @else
        <img src="{{ asset($item->img_url) }}" alt="" class="img-fluid rounded-circle profile-img" style="max-width: 150px;">
        @endif
      </div>
      <div class="col-md-9">
        <div class="card-body">
          <h5 class="card-title mb-4">{{ $item->nickname }}</h5>
          <ul class="list-unstyled">
            <li class="mb-3 flex">
              <h6 class="fw-bold mb-0">年齢</h6>
              <p class="mb-0">{{ $item->age }}歳</p>
            </li>
            <li class="mb-3 flex">
              <h6 class="fw-bold mb-0">性別</h6>
              <p class="mb-0">{{ $item->gender }}</p>
            </li>
            <li class="mb-3">
              <h6 class="fw-bold mb-0">住んでいる地域</h6>
              <p class="mb-0">{{ $item->living_area }}</p>
            </li>
            <li class="mb-3">
              <h6 class="fw-bold mb-0">自己紹介</h6>
              <p class="mb-0">{{ $item->message }}</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="card mb-2">
    <div class="card-body">
      <h5 class="card-title">依頼詳細</h5>
      <ul class="list-unstyled mb-0">
        <li class="mb-3">
          <h6 class="fw-bold mb-0">プラン名</h6>
          <p class="mb-0">{{ $plan_name }}</p>
        </li>
        <li class="mb-3">
          <h6 class="fw-bold mb-0">依頼期間</h6>
          <p class="mb-0">{{ date('Y年m月d日', strtotime($hotaru_request->date_begin)) }} 〜 {{ date('Y年m月d日', strtotime($hotaru_request->date_end)) }}</p>
        </li>
        <li>
          <h6 class="fw-bold mb-0">費用</h6>
          <p class="mb-0">{{ $hotaru_request->price }}円</p>
        </li>
      </ul>
    </div>
  </div>

  @if($exist == true)
  <button disable class="btn btn-outline-secondary">承認済み</button>
  @if($paid_sign == false)
  <button class="btn btn-danger" onClick="onClick();">
    仮払いを実行する
  </button>
  @else
  <button class="btn btn-danger" disabled>
    支払い済み
  </button>
  @endif
  @else
  <div class="btn-group me-3">
    <button class="btn btn-primary col-3 px-4" onClick="location.href='{{route('myrequest.member.approval',[
                  'apply_id'=>$apply_id,
                  'service_id' => $service_id,
                  'user_id'=>$item->user_id])}}'">承認</button>
    <button class="btn btn-danger col-3 px-4" onClick="location.href='{{route('myrequest.member.reject', [
                    'apply_id'=>$apply_id,
                    'service_id' => $service_id,
                  'user_id'=>$item->user_id])}}'">否認</button>
  </div>
  <div class="btn-group">
    @if($hotaru_request->plan_id == 1)
    <button type="button" class="col-3 btn btn-outline-primary" onclick="location.href='{{route('mypage.myrequest.edit.ohakamairi',['service_id' => $hotaru_request->id])}}'">修正</button>
    @elseif($hotaru_request->plan_id == 2)
    <button type="button" class="col-3 btn btn-outline-primary" onclick="location.href='{{route('mypage.myrequest.edit.omamori',['service_id' => $hotaru_rewquest->id])}}'">修正</button>
    @elseif($hotaru_request->plan_id == 3)
    <button type="button" class="col-3 btn btn-outline-primary" onclick="location.href='{{route('mypage.myrequest.edit.sanpai',['service_id' => $hotaru_request->id])}}'">修正</button>
    @elseif($hotaru_request->plan_id == 4)
    <button type="button" class="btn btn-outline-primary" onclick="location.href='{{route('mypage.myrequest.edit.others',['service_id' => $hotaru_Request->id])}}'">修正</button>
    @endif
    <button type="button" class=" btn btn-outline-secondary" onClick="history.back();">戻る</button>
    <button class="btn btn-info" onClick="location.href='{{route('chat.room',['room_id'=>$room->id, 'theother_id'=>$user_id])}}'">チャット</button>
  </div>
  @endif
</div>
@endsection

<script src="https://js.stripe.com/v3/"></script>
<script>
  const publicKey = '<?= $publicKey ?>';
  var stripe = Stripe(publicKey);
  // 4. 決済ボタンが押下されたら決済画面にリダイレクトする
  function onClick() {
    stripe.redirectToCheckout({
      sessionId: '<?= $session->id ?>'
    }).then(function(result) {
      //
    });
  }
</script>