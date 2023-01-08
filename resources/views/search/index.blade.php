@component('components.app')
@endcomponent
@component('components.header_wide')
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
              @foreach($areas as $area)
              <label for="area_id" class="mr-1">
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
                @endif />

                {{$area->name}}

              </label>
              @endforeach
            </div>
          </td>
        </tr>
        <tr>
          <th>ジャンル</th>
          <td>
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapsePlan">ジャンルで絞る</button>
            <div class="collapse" id="collapsePlan">
              @foreach($plans as $plan)
              <label for="plan_id" class="mr-1">
                <input type="checkbox" name="plan_id[]" value="{{$plan->id}}" multiple @if(is_array(old('plan_id')) && in_array($plan->id, old('plan_id')))checked
                @endif />{{$plan->name}}
              </label>
              @endforeach
            </div>
          </td>
        </tr>
      </table>
      <button type="submit" class="btn btn-primary shadow-lg">検索</button>
    </form>

    <!--検索結果表示-->
    <div class="mb-5 mb-lg-0 text-center text-lg-start">
      @foreach($items as $item)
      @if($items == null)
      <p>検索結果に該当するラウンドはありませんでした。</p>
      @else
      <button onClick="location.href='{{route('search.more',['request_id'=>$item->id])}}'" class="card m-4 p-4 shadow card-point">
        <div class="row no-gutters">
          <div class="col-lg-3">
            <img src="{{ asset($item->profile_img) }}" alt="Profile image" class="card-img">
          </div>
          <div class="col-lg-9">
            <p>ジャンル：{{$item->plan_name}}</p>
            <p>実施希望期日：{{$item->date_end}}</p>
            <p>エリア：{{$item->area_name}}</p>
            <p>金額：{{$item->price}}</p>
          </div>
        </div>
      </button>
      @endif
      @endforeach
    </div>
  </div>
</body>