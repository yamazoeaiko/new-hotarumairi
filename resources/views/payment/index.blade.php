@extends('layouts.app')
@section('content')
<div class="container">
  <h5>支払い画面</h5>
  <div class="form-control">
    <div class="form-control mb-3">
      <label for="experience_name" class="fw-bolder">依頼タイトル</label>
      <input class="form-control" value="{{ $entry->main_title }}" readonly>
    </div>
    <div class="form-control mb-3">
      <label for="provider_name" class="fw-bolder">ご依頼ユーザー名</label>
      <input class="form-control" value="{{ $entry->sell_user }}" readonly>
    </div>
    <div class="form-control mb-3">
      <label for="include_tax_price" class="fw-bolder">支払い金額(税込)</label>
      <div class="input-group">
        <input type="number" class="form-control" value="{{$entry->include_tax_price}}" readonly>
        <div class="input-group-append">
          <span class="input-group-text">円（税込）</span>
        </div>
      </div>
    </div>
    <div class="form-control mb-3">
      <label for="" class="fw-bolder">注意事項</label>
      <div>支払いにあたっての注意事項やキャンセルポリシーを記載する</div>
    </div>
  </div>
  <div class="text-center my-3">
    <button class="btn btn-danger" onClick="onClick();">支払いを実行する</button>
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