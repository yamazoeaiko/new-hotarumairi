@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container row">
    <div class="col-10">
      <h5>あなたが応募している代行一覧</h5>
      @if($items->isEmpty())
      <span>現在あなたが応募している案件はございません</span>
      @endif
      <div class="list-group">
        @foreach($items as $item)
        <button onClick="location.href='{{route('search.more', ['request_id' => $item->id])}}'" class="list-group-item list-group-item-action">
          <div class="row">
            <div class="col-8 fw-bolder fs-5">{{$item->plan_name}}</div>
            <div class="col-7">日程：{{$item->date_begin}}〜{{$item->date_end}}</div>
            <div class="col-5">受取り金額：{{$item->price_net}}円</div>
          </div>
        </button>
        @endforeach
      </div>
    </div>
  </div>
</body>