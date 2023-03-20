@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{ route('service.fixed.update') }}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 row">
      <div class="col-md-4">
        <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img" style="max-width: 100%; height: auto;">
      </div>
      <div class="col-md-8">
        <div class="mb-3">
          <input type="text" class="fs-3" value="{{ $item->main_title }}">
        </div>

        <div class="mb-3">
          <p class="card-text mb-0">
            <small class="text-muted">ユーザー名：</small>
            {{$item->user_name}}
          </p>
          <p class="card-text mb-0">
            <small class="text-muted">年齢：</small>{{ $item->age }}歳
          </p>
          <p class="card-text mb-0">
            <small class="text-muted">住まい地域：</small>{{ $item->living_area }}
          </p>
        </div>
        <div class="mb-3">
          <label for="price" class="fw-bolder">サービス価格</label>
          <div class="input-group">
            <input type="number" name="price" class="form-control" value="{{$item->price}}">
            <div class="input-group-append">
              <span class="input-group-text">円（税別）</span>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="date_end" class="fw-bolder">納品期日</label>
          <div class="input-group">
            <input type="date" name="date_end" value="{{ $item->date_end }}">
          </div>
        </div>

        <div class="mb-3">
          <label for="content" class="fw-bolder">サービス内容</label>
          <textarea name="content" id="" cols="30" rows="10" class="form-control">{{ $item->content }}</textarea>
        </div>
      </div>
    </div>
    <input type="hidden" name="fix_id" value="{{ $item->id }}">
    <div class="text-center">
      <button class="col btn btn-primary">更新</button>
    </div>
  </form>
</div>
@endsection