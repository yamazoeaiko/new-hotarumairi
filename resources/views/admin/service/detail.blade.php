@extends('layouts.admin')

@section('content')
<div class="container">
  <h5 class="my-2 fw-bold">【管理画面】出品サービス詳細</h5>
  <div class="form-control">
    <div class="mb-3">
      <p class="fw-bolder fs-3">{{ $item->main_title }}</p>
    </div>
    @if($item->categories)
    <div>
      @foreach($item->categories as $value)
      <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
      @endforeach
    </div>
    @endif
    <div class="mb-3">
      <label class="fw-bolder" for="photo">登録画像</label>
      @foreach (range(1, 8) as $i)
      @php
      $photo = "photo_" . $i;
      @endphp
      @if ($item->$photo !== null)
      <div>
        <a href="{{asset($item->$photo)}}">画像（{{$item->img_url}}）</a>
      </div>
      @endif
      @endforeach
    </div>
    <div class="mb-3">
      <label for="price" class="fw-bolder">サービス価格</label>
      <div class="input-group">
        <input type="number" name="price" class="form-control" value="{{$item->price}}" readonly>
        <div class="input-group-append">
          <span class="input-group-text">円（税別）</span>
        </div>
      </div>
    </div>
    <div class="mb-3">
      <label for="content" class="fw-bolder">サービス内容</label>
      <textarea name="content" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->content }}</textarea>
    </div>

    @if($item->area_ids)
    <div class="mb-3">
      <label for="area_id" class="fw-bolder">対応可能エリア<span class="fs-7 text-secondary">※任意</span></label>
      @foreach($item->area_ids as $area_id)
      <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success">{{ $area_id->name}}</small>
      @endforeach
    </div>
    @endif

    <div class="mb-3">
      <label for="attention" class="fw-bolder">購入時の注意事項<span class="fs-7 text-secondary">※任意</span></label>
      <textarea name="attention" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->attention }}</textarea>
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="free">自由記入欄<span class="fs-7 text-secondary">※任意</span></label>
      <textarea class="form-control" name="free" readonly>{{ $item->free }}</textarea>
    </div>

    <div class="mb-3">
      <label for="status" class="fw-bolder">公開状況</label>
      <div>{{ $item->status_name }}</div>
    </div>
  </div>
  <div class="text-center mt-3">
    <button class="btn btn-primary" onClick="location.href='{{route('admin.service.edit',['service_id'=>$item->id])}}'">編集</button>
    <button class="btn btn-outline-primary" onClick="location.href='{{route('admin.service.list')}}'">戻る</button>
  </div>
  @endsection