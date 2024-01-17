@extends('layouts.app')
@section('content')
<div class="container">
  <h5 class="my-2 fw-bold">出品サービス一覧</h5>
  <!--検索する-->
  <form action="{{route('service.search')}}" method="get" class="form-group my-4">
    @csrf
    <table class="table my-2">
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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

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
                <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple>

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
  <div class="row">
    <div class="col-lg-2 d-lg-block d-none">
      <!-- Navbar Left -->
      <div class="navbar-left">
        <ul class="navbar-nav list-group">
          @foreach($categories as $category)
          <li class="nav-item px-2 list-group-item border-0">
            <div class="row">
              <div class="col-4">
                <img src="{{ asset($category->icon) }}" alt="Category Icon" class="category-icon">
              </div>
              <div class="col-8">
                <a href="{{ route('service.search', ['category_ids[]' => $category->id]) }}" class="nav-link btn btn-link">
                  {{ $category->name }}
                </a>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-lg-10">
      <!-- New Arrivals -->
      <section class="new-arrivals-section">
        <div class="container">
          <div class="row">
            <div class="col-7">
              <h2 class="section-title">出品サービスの新着案件</h2>
            </div>
            <div class="col-4">
              <a href="{{ route('service') }}">もっと見る</a>
            </div>
          </div>
          <div class="row row-cols-2 row-cols-md-4 g-2">
            @foreach($items as $item)
            <div class="col mb-2">
              <div class="card">
                <a class="mb-4 text-decoration-none" href="{{ route('service.detail',['service_id'=>$item->id]) }}">
                  <div class="service-card">
                    <img src="{{ asset($item->photo_1) }}" class="card-img-top" alt="image_photo">
                  </div>
                  <div class="card-body">
                    <div class="category-parent">
                      @foreach($item->categories as $value)
                      <small class="text-ellipsis d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name }}</small>
                      @endforeach
                    </div>
                    <p class="fw-bolder text-ellipsis">{{ $item->main_title }}</p>
                    <div class="row align-items-center px-1">
                      <div class="col-5">
                        <div class="rounded-circle overflow-hidden d-flex" style="width: 40px; height: 40px; padding: 0;">
                          <a href="{{ route('user.detail', ['user_id' => $item->provider_id]) }}" onclick="event.stopPropagation(); location.href=this.href;">
                            <img src="{{ asset($item->profile_image) }}" alt="" style="max-width: 100%; max-height: 100%;">
                          </a>
                        </div>
                      </div>
                      <div class="col-7 fs-7 text-secondary">{{ $item->price }}円</div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection