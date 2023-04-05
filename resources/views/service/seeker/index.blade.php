@extends('layouts.app')
@section('content')
<div class="container">
  <h5>出品サービス一覧</h5>
  <!--検索する-->
  <form action="{{route('service.search')}}" method="get" class="form">
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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple >

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple >

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple >

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple >

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

                {{$area->name}}
              </label>
              @endif
              @endforeach
            </div>

            <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKyushu">九州エリア</button>
            <div class="collapse" id="collapseKyushu">
              @foreach($areas as $area)
              @if($area->category == '九州エリア')
              <label for="area_id" class="mr-1">
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

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
          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseCategory">ジャンルで絞る</button>
          <div class="collapse" id="collapseCategory">
            @foreach($categories as $category)
            <label for="plan_id" class="m-1">
              <input type="checkbox" name="category_ids[]" value="{{$category->id}}" multiple>{{$category->name}}
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
              <input type="number" name="price_min" class="mt-1">
            </label>
            円〜
            <label for="price_max" class="mr-1">
              <input type="number" name="price_max" class="mt-1">
            </label>
            で絞る
          </div>
        </td>
      </tr>
    </table>
    <div class="text-center">
      <button type="submit" class="btn btn-primary shadow-lg px-5 mx-3">検索</button>
      <a href="{{ route('service') }}" class="mx-3">検索条件をリセットする</a>
    </div>
  </form>
  <!--検索結果-->
  @foreach($items as $item)
  <button onClick="location.href='{{ route('service.detail',['service_id'=>$item->id]) }}'" class="card m-4 shadow card-point" style="max-width: 500px;">
    <div class="row no-gutters">
      <div class="col-md-4">
        <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img">
        <p class="card-text mb-0">{{$item->user_name}}</p>
        @if($item->favorite)
        <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success">お気に入り</small>
        @endif
        @if($item->follow)
        <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success">フォロー中</small>
        @endif
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <div>
            @foreach($item->categories as $value)
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
            @endforeach
          </div>
          <h5 class="card-title">{{$item->main_title}}</h5>
          <p class="card-text mb-0"><small class="text-muted">{{$item->price}}円</small></p>
          <a href="{{ route('service.detail',['service_id'=>$item->id]) }}" class="btn btn-primary stretched-link">詳細を見る</a>
        </div>
      </div>
    </div>
  </button>
  @endforeach
</div>
@endsection