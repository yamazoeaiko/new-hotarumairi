@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <div>
      <h5>出品サービス管理画面</h5>
      @if($items->isEmpty())
      <span>現在あなたが出品しているサービスはございません</span>
      @endif
      <div class="list-group">
        @foreach($items as $item)
        <button onClick="location.href='{{route('service.detail', ['service_id' => $item->id])}}'" class="list-group-item list-group-item-action">
          <div class="row">
            <div class="col-8 fw-bolder fs-5">{{$item->main_title}}</div>
            <div class="col-4">サービス価格：{{$item->price}}円（税別）</div>
          </div>
          <div class="row">
            <p class="text-muted small text-left ml-auto" style="text-align: left !important;">{{ $item->content }}</p>
          </div>
        </button>
        @endforeach
      </div>
    </div>
  </div>
</body>