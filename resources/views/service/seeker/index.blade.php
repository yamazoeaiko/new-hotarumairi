@extends('layouts.app')
@section('content')
<div class="container">
  <h5>出品サービス一覧</h5>
  <!--検索する-->
  <form action="{{route('service.search.post')}}" method="post">
    @csrf
    <div class="form-control">
      <div class="mb-3">
        <label class="fw-bolder">ジャンル</label>
        <div>
          <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapsePlan">ジャンルで絞る</button>
          <div class="collapse" id="collapsePlan">
            @foreach($categories as $category)
            <label for="category_ids" class="m-1">
              <input type="checkbox" name="category_ids[]" value="{{$category->id}}" multiple @if(is_array(old('category_ids')) && in_array($category->id, old('category_ids')))checked
              @endif />{{$category->name}}
            </label>
            @endforeach
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label class="fw-bolder">報酬金額</label>
        <div>
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
        </div>
      </div>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary shadow-lg px-5">検索</button>
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