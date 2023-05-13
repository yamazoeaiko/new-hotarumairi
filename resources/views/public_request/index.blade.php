@extends('layouts.app')

@section('content')
<div class="container">
  <h5 class="fw-bolder">公開依頼</h5>
  <form action="{{route('pubreq.search')}}" method="get" class="form">
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

            <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKyushu">九州エリア</button>
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
          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseCategory">ジャンルで絞る</button>
          <div class="collapse" id="collapseCategory">
            @foreach($categories as $category)
            <label for="plan_id" class="m-1">
              <input type="checkbox" name="category_ids[]" value="{{$category->id}}" multiple @if(is_array(old('category_ids')) && in_array($category->id, old('category_ids')))checked
              @endif />{{$category->name}}
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
  <div class="row mt-3">
    @foreach($items as $item)
    <div class="col-md-6 col-lg-3">
      <div class="card mb-4">
        <div class="card-body">
          @foreach($item->categories as $value)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
          @endforeach
          <h5 class="fs-6 fw-bolder">{{$item->main_title}}</h5>
          <div class="row align-items-center">
            <div class="col-4 d-flex fs-7">
              {{$item->provider_name }}
            </div>
            <div class="col-4 fs-7 text-secondary text-md-center">{{ $item->price }}円</div>
            <div class="col-4 text-md-end">
              <a href="{{ route('service.detail',['service_id'=>$item->id]) }}" class="btn btn-primary fs-7">詳細</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection