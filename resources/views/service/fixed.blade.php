@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <div class="form-control">
      <div class="mb-3 row">
        <div class="col-md-4">
          <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img" style="max-width: 100%; height: auto;">
        </div>
        <div class="col-md-8">
          <div class="mb-3">
            <p class="fw-bolder fs-3">{{ $item->main_title }}</p>
          </div>

          <div class="mb-3">
            <p class="card-text mb-0">
              <small class="text-muted">ユーザー名：</small>
              {{$item->user_name}}
            </p>
            <p class="card-text mb-0">
              <small class="text-muted">年齢：</small>{{ $item->age }}歳
            </p>
            <p class="card-text mb-0">
              <small class="text-muted">住まい地域：</small>{{ $item->living_area }}
            </p>
          </div>
          <div class="mb-3">
            <label for="price" class="fw-bolder">サービス価格</label>
            <div class="input-group">
              <input type="number" name="price" class="form-control" value="{{$item->price}}" readonly>
              <div class="input-group-append">
                <span class="input-group-text">円（税別）</span>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="date_end" class="fw-bolder">納品期日</label>
            <div class="input-group">
              <input type="date" name="date_end" value="{{ $item->date_end }}" readonly>
            </div>
          </div>

          <div class="mb-3">
            <label for="content" class="fw-bolder">サービス内容</label>
            <textarea name="content" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->content }}</textarea>
          </div>
        </div>
      </div>

      <div class="text-center">
        <button type="button" class="btn btn-success" onClick="location.href='{{route('chat.room', ['room_id' => $room_id, 'theother_id'=> $theother->id])}}'">チャット画面へ</button>

        @if($user_id == $item->host_user)
        <button class="col btn btn-primary" onclick=location.href="{{route('service.fixed.edit',['fix_id'=>$item->id])}}">内容を編集する</button>

        @if($item->estimate == false)
        <form action="{{ route('service.estimate.post') }}" method="post">
          @csrf
          <input type="hidden" name="fix_id" value="{{ $item->id }}">
          <button class="btn btn-outline-primary">
            正式な見積もりとして送信する
          </button>
        </form>
        @else
        <form action="{{ route('service.estimate.post') }}" method="post">
          @csrf
          <input type="hidden" name="fix_id" value="{{ $item->id }}">
          <button class="btn btn-outline-primary">
            見積もり送信済み。<br><span>内容修正がある場合、再度送信できます。</span>
          </button>
        </form>
        @endif

        @else
        @if($item->estimate == true && $item->contract == false)
        <form action="{{ route('service.estimate.approve') }}" method="post">
          @csrf
          <input type="hidden" name="fix_id" value="{{ $item->id }}">
          <button class="btn btn-outline-primary">正式な見積もりを承認する</button>
        </form>
        @endif
        @if($item->contract == true && $item->payment == false)
        <button class="btn btn-danger" onClick="onClick();">
          仮払いを実行する
        </button>
        @endif
        @if($item->payment == true)
        <button class="btn btn-outline-danger" disabled>
          仮払い完了
        </button>
        @endif
        @endif
      </div>
</body>


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