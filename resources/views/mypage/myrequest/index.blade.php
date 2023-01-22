@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>
  <div class="container row">
    <div class="col-10">
      <h5>あなたが依頼している代行一覧</h5>
      @if($items->isEmpty())
      <span>現在あなたが依頼している代行はございません</span>
      @endif
      <div class="list-group">
        @foreach($items as $item)
        <button onClick="location.href='{{route('mypage.myrequest.detail', ['request_id' => $item->id])}}'" class="list-group-item list-group-item-action">
          <div class="row">
            <div class="col-8 fw-bolder fs-5">{{$item->plan_name}}</div>
            <div class="col-8">日程：{{$item->date_begin}}〜{{$item->date_end}}</div>
            <div class="col-4">費用：{{$item->price}}円</div>
            <div class="col-8">{{$item->apply_count}}名からの応募があります</div>
          </div>

        </button>
        @endforeach
      </div>
    </div>
  </div>
</body>