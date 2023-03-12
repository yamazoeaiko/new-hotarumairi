@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{route('request.session.save')}}" method="post" class="form-control">
    @csrf
    <input type="hidden" name="user_id" id="" value="{{$user_id}}">
    <div class="mb-3">
      <label for="plan" class="form-label fw-bolder">プラン</label>
      <select name="plan_id" id="plan_id" class="form-control fw-bolder">
        <option value="4">その他お参り代行</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="request" class="form-label fw-bolder">依頼内容(詳細に記入)<br><span>※お参りと称したユニークな代行依頼をカスタマイズ可能です。</span></label>
      <textarea name="free" id="request" cols="30" rows="3" class="form-control"></textarea>
    </div>
    <div class="mb-3">
      <label for="date" class="form-label fw-bolder">日程</label>
      <div class="input-group">
        <input type="date" name="date_begin" class="form-control">
        <span class="input-group-text">〜</span>
        <input type="date" name="date_end" class="form-control">
      </div>
    </div>
    <div class="mb-3">
      <label for="area" class="form-label fw-bolder">都道府県のエリア指定（任意）</label>
      <select name="area_id" id="area" class="form-select">
        @foreach($areas as $area)
        <option value="{{ $area->id }}">{{ $area->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label fw-bolder">住所の指定（任意）</label>
      <input type="text" name="address" id="address" class="form-control">
    </div>
    <div class="mb-3">
      <label for="spot" class="form-label fw-bolder">施設の名称など（任意）</label>
      <input type="text" name="spot" id="spot" class="form-control">
    </div>
    <div class="mb-3">
      <label for="image" class="form-label fw-bolder">画像添付(任意)</label>
      <input type="file" name="img_url" accept="image/png, image/jpeg" id="image" class="form-control">
    </div>
    <div class="mb-3">
      <label for="price" class="form-label fw-bolder">費用（お支払い額）<br><span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span></label>
      <div class="input-group">
        <input type="number" name="price" id="price" class="form-control">
        <span class="input-group-text">円（税別）</span>
      </div>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary mt-3">確認画面に進む</button>
    </div>
  </form>
</div>
@endsection