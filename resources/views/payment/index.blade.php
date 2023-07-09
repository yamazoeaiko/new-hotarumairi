@extends('layouts.app')
@section('content')
<div class="container">
  <h5 class="my-2 fw-bold">支払い画面</h5>
  <div class="form-control">
    <div class="form-control mb-3">
      <label for="experience_name" class="fw-bolder">サービスタイトル</label>
      <input class="form-control" value="{{ $agreement->main_title }}" readonly>
    </div>
    <div class="form-control mb-3">
      <label for="provider_name" class="fw-bolder">お支払い先ユーザー名</label>
      <input class="form-control" value="{{ $agreement->sell_user }}" readonly>
    </div>
    <div class="form-control mb-3">
      <label for="include_tax_price" class="fw-bolder">お支払い金額(税込)</label>
      <div class="input-group">
        <input type="number" class="form-control" value="{{$agreement->include_tax_price}}" readonly>
        <div class="input-group-append">
          <span class="input-group-text">円（税込）</span>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center my-3">
    <button class="btn btn-primary" onClick="onClick();">支払いを実行する</button>
    <div>
      <span class="red small">※こちらをクリックするとクレジットカードでの決済画面にリダイレクトします。</span>
    </div>
  </div>
</div>

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
@endsection