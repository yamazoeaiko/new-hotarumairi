@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{route('myrequest.update.others', ['service_id' => $item->id])}}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="plan" class="form-label fw-bolder">プラン</label>
      <select name="plan_id" id="plan_id" class="form-control fw-bolder">
        <option value="4">その他お参り代行</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="request" class="form-label fw-bolder">依頼内容(詳細に記入)<br><span>※お参りと称したユニークな代行依頼をカスタマイズ可能です。</span></label>
      <textarea name="free" id="request" cols="30" rows="3" class="form-control">{{ $item->free }}</textarea>
    </div>
    <div class="mb-3">
      <label for="date" class="form-label fw-bolder">日程</label>
      <div class="input-group">
        <input type="date" name="date_begin" class="form-control" value="{{ $item->date_begin }}">
        <span class="input-group-text">〜</span>
        <input type="date" name="date_end" class="form-control" value="{{ $item->date_end }}">
      </div>
    </div>
    <div class="mb-3">
      <label for="area" class="form-label fw-bolder">依頼に該当する都道府県（任意）</label>
      <div>{{ $item->area_name }}</div>
      <select name="area_id" id="area_id" class="form-control">
        @foreach($areas as $area)
        <option value="{{ $area->id }}">{{ $area->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label fw-bolder">依頼に該当する住所（任意）</label>
      <input type="text" name="address" id="address" class="form-control" value="{{ $item->address }}">
    </div>
    <div class="mb-3">
      <label for="spot" class="form-label fw-bolder">施設の名称など（任意）</label>
      <input type="text" name="spot" id="spot" class="form-control" value="{{ $item->spot }}">
    </div>
    <div class="mb-3">
      <label for="image" class="form-label fw-bolder">画像添付(任意)</label>
      <div class="my-2">
        <input type="file" accept=".png, .jpeg, .jpg" name="img_url" class="form-control" accept="image/png, image/jpeg">
      </div>
      <a href="{{asset($item->img_url)}}">添付画像</a>
    </div>
    <div class="mb-3">
      <label for="price" class="form-label fw-bolder">費用（お支払い額）<br><span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span></label>
      <div class="input-group">
        <input type="number" name="price" id="price" class="form-control" value="{{ $item->price }}">
        <span class="input-group-text">円（税別）</span>
      </div>
    </div>
    <div class="text-center mt-3">
      <button name="submit" class="btn btn-primary">内容を更新</button>
      <button type="button" onClick="history.back();" class="btn btn-outline-secondary">修正せずに戻る</button>
    </div>
  </form>
</div>
@endsection