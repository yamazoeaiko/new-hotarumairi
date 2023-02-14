@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <form action="{{route('search.post')}}" method="post" class="form">
      @csrf
      <table class="table">
        <tr>
          <th>エリア</th>
          <td>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseArea">エリアで絞る</button>
            <div class="collapse" id="collapseArea">

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseHokkaido">北海道エリア</button>
              <div class="collapse" id="collapseHokkaido">
                @foreach($areas as $area)
                @if($area->category == '北海道エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}

                </label>
                @endif
                @endforeach
              </div>

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseTohoku">東北エリア</button>
              <div class="collapse" id="collapseTohoku">
                @foreach($areas as $area)
                @if($area->category == '東北エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}
                </label>
                @endif
                @endforeach
              </div>

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKanto">関東エリア</button>
              <div class="collapse" id="collapseKanto">
                @foreach($areas as $area)
                @if($area->category == '関東エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}
                </label>
                @endif
                @endforeach
              </div>

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseChubu">中部エリア</button>
              <div class="collapse" id="collapseChubu">
                @foreach($areas as $area)
                @if($area->category == '中部エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}
                </label>
                @endif
                @endforeach
              </div>

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKinki">近畿エリア</button>
              <div class="collapse" id="collapseKinki">
                @foreach($areas as $area)
                @if($area->category == '近畿エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}
                </label>
                @endif
                @endforeach
              </div>

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseChugoku">中国エリア</button>
              <div class="collapse" id="collapseChugoku">
                @foreach($areas as $area)
                @if($area->category == '中国エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}
                </label>
                @endif
                @endforeach
              </div>

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseShikoku">四国エリア</button>
              <div class="collapse" id="collapseShikoku">
                @foreach($areas as $area)
                @if($area->category == '四国エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}
                </label>
                @endif
                @endforeach
              </div>

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKyushu">関東エリア</button>
              <div class="collapse" id="collapseKyushu">
                @foreach($areas as $area)
                @if($area->category == '九州エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}
                </label>
                @endif
                @endforeach
              </div>

              <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseOkinawa">沖縄エリア</button>
              <div class="collapse" id="collapseOkinawa">
                @foreach($areas as $area)
                @if($area->category == '沖縄エリア')
                <label for="area_id" class="mr-1">
                  <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                  @endif />

                  {{$area->name}}
                </label>
                @endif
                @endforeach
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th>ジャンル</th>
          <td>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapsePlan">ジャンルで絞る</button>
            <div class="collapse" id="collapsePlan">
              @foreach($plans as $plan)
              <label for="plan_id" class="m-1">
                <input type="checkbox" name="plan_id[]" value="{{$plan->id}}" multiple @if(is_array(old('plan_id')) && in_array($plan->id, old('plan_id')))checked
                @endif />{{$plan->name}}
              </label>
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <th>報酬金額</th>
          <td>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapsePrice">報酬金額で絞る</button>
            <div class="collapse" id="collapsePrice">
              <label for="price_min" class="mr-1">
                <input type="number" name="price_min" value="{{old('price_min')}}" class="mt-1">
              </label>
              円〜
              <label for="price_max" class="mr-1">
                <input type="number" name="price_max" value="{{old('price_max')}}" class="mt-1">
              </label>
              で絞る
            </div>
          </td>
        </tr>
      </table>
      <div class="text-center">
        <button type="submit" class="btn btn-primary shadow-lg px-5">検索</button>
      </div>
    </form>

    <!--検索結果表示-->
    <div class="mb-5 mb-lg-0 text-center text-lg-start">
      @foreach($items as $item)
      @if($items == null)
      <p>検索結果に該当するラウンドはありませんでした。</p>
      @endif
      @if($item->applied !==null)
      <button onClick="location.href='{{ route('search.more',['request_id'=>$item->id]) }}'" class="card m-4 shadow card-point bg-success" style="max-width: 500px;">
        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="{{ asset($item->profile_img) }}" alt="Profile image" class="card-img">
            <p class="card-text mb-0">{{$item->user_name}}</p>
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">{{$item->plan_name}}</h5>
              <p class="card-text mb-0"><small class="text-muted">代行期日：</small>{{$item->date_end}}</p>
              <p class="card-text mb-0"><small class="text-muted">エリア：</small>{{$item->area_name}}</p>
              <p class="card-text mb-0"><small class="text-muted">見積り：</small>{{$item->price_net}}円</p>
              <a href="{{ route('search.more',['request_id'=>$item->id]) }}" class="btn btn-secondary stretched-link">詳細を見る</a>
              <span class="ml-auto mb-2 fs-6 fw-bolder"><i class="bi bi-check-circle"></i> 応募済み</span>
            </div>
          </div>
        </div>
      </button>
      @else

      <button onClick="location.href='{{ route('search.more',['request_id'=>$item->id]) }}'" class="card m-4 shadow card-point" style="max-width: 500px;">
        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="{{ asset($item->profile_img) }}" alt="Profile image" class="card-img">
            <p class="card-text mb-0">{{$item->user_name}}</p>
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">{{$item->plan_name}}</h5>
              <p class="card-text mb-0"><small class="text-muted">代行期日：</small>{{$item->date_end}}</p>
              <p class="card-text mb-0"><small class="text-muted">エリア：</small>{{$item->area_name}}</p>
              <p class="card-text mb-0"><small class="text-muted">見積り：</small>{{$item->price_net}}円</p>
              <a href="{{ route('search.more',['request_id'=>$item->id]) }}" class="btn btn-primary stretched-link">詳細を見る</a>
            </div>
          </div>
        </div>
      </button>
      @endif
      @endforeach
    </div>
  </div>
</body>