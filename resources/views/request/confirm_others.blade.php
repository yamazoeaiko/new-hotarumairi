@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{route('request.done')}}" method="post" class="form-control">
    @csrf
    <input type="hidden" name="user_id" id="" value="{{$params->user_id}}">
    <div class="mb-3">
      <label for="plan_id" class="fw-bolder">プラン</label>
      <div class="input-group">
        <select name="plan_id" class="form-control" readonly>
          <option value="4">その他お参り代行</option>
        </select>
      </div>
    </div>

    <div class="mb-3">
      <label for="fress" class="fw-bolder">その他
      </label>
      <div class="input-group">
        <textarea name="free" id="" cols="30" rows="3" class="form-control" readonly>{{$params->free}}
        </textarea>
      </div>
    </div>

    <div class="mb-3">
      <label for="date_range" class="fw-bolder">日程</label>
      <div class="input-group">
        <input type="date" name="date_begin" id="date_begin" class="form-control" value="{{ $params->date_begin }}" readonly>
        <span class="input-group-text">〜</span>
        <input type="date" name="date_end" id="date_end" class="form-control" value="{{ $params->date_end }}" readonly>
      </div>
    </div>

    <div class="mb-3">
      <label for="area_id" class="fw-bolder">都道府県のエリア指定（任意）</label>
      <input name="area_id" id="area_id" value="{{ $params->area_id }}" hidden>
      <input type="text" class="form-control" readonly value="{{ $params->area_name }}">
    </div>

    <div class="mb-3">
      <label for="address" class="fw-bolder">住所の指定（任意）</label>
      <input type="text" name="address" id="address" class="form-control" value="{{ $params->address }}" readonly>
    </div>
    <div class="mb-3">
      <label for="spot" class="fw-bolder">施設の名称など（任意）</label>
      <div class="input-group">
        <input type="text" value="{{$params->spot}}" name="spot" class="form-control" readonly>
      </div>
    </div>

    <div class="mb-3">
      <label class="fw-bolder mb-2">画像添付(任意)</label>
      <input type="hidden" name="img_url" value="{{$path}}">


      <p><a href="{{ asset($path) }}">{{ $fileName }}</a></p>
    </div>

    <div class="mb-3">
      <label class="fw-bolder d-block mb-2">費用（お支払い額）<br>
        <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
      </label>
      <div class="input-group">
        <input type="number" name="price" class="form-control" value="{{$params->price}}" readonly>
        <div class="input-group-append">
          <span class="input-group-text">円（税別）</span>
        </div>
      </div>
    </div>

    <div class="text-center mt-3">
      <button name="submit" class="btn btn-primary">この内容で募集開始する</button>
      <button type="button" onClick="history.back();" class="btn btn-outline-secondary">修正する</button>
    </div>
  </form>
</div>
@endsection