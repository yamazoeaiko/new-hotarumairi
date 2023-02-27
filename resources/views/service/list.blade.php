@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <div class="my-5">
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
    <div class="my-3">
      <h5>見積もり・内容相談など</h5>
      @if(count($consults)== 0)
      <span>出品サービスへの相談はありません。</span>
      @else
      @foreach($consults as $consult)
      <button onClick="location.href='{{route('service.fixed', ['fix_id' => $consult->fix_id])}}'" class="list-group-item list-group-item-action">
        <div class="no-gutters">
          <div class="row">
            <div class="col-2">
              <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <img src="{{ asset($consult->profile_img) }}" alt="" class="w-100 h-100">
              </div>
            </div>
            <div class="col-6">
              <h5 class="font-weight-bold mb-0">{{ $consult->consulting_user_name }}</h5>
            </div>
            <div class="col-4 text-right">
              <p class="text-muted small">{{ date('Y年m月d日h時m分', strtotime($consult->created_at)) }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-2"></div>
            <div class="col-6">
              <p class="text-muted small text-left ml-auto" style="text-align: left !important;">{{ $consult->first_chat }}
              </p>
            </div>
            <div class="col-3 text-right">
              @if($consult->estimate == true && $consult->contract == false)
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">見積もり提案中
              </small>
              @endif
              @if($consult->contract == true && $consult->payment == false)
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">契約成立中
              </small>
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">支払い待ち
              </small>
              @endif
              @if($consult->payment == true)
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">支払い完了
              </small>
              <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">作業完了報告待ち
              </small>
              @endif
            </div>
          </div>
        </div>
      </button>
      @endforeach
      @endif
    </div>
  </div>
</body>