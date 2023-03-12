@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{route('myrequest.update.omamori', ['request_id' => $item->id])}}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="plan" class="form-label fw-bolder">プラン</label>
      <select name="plan_id" id="plan_id" class="form-control fw-bolder">
        <option value="2">お守り・お札・御朱印購入代行</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="date_begin" class="form-label fw-bolder">日程</label>
      <div class="input-group">
        <input type="date" name="date_begin" id="date_begin" class="form-control" value="{{ $item->date_begin }}">
        <div class="input-group-text">〜</div>
        <input type="date" name="date_end" id="date_end" class="form-control" value="{{ $item->date_end }}">
      </div>
    </div>
    <div class="mb-3">
      <label for="area_id" class="form-label fw-bolder">該当の神社仏閣の都道府県</label>
      <div>{{ $item->area_name }}</div>
      <select name="area_id" id="area_id" class="form-control">
        @foreach($areas as $area)
        <option value="{{ $area->id }}">{{ $area->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="address" class="form-label fw-bolder">神社仏閣市町村(可能ならば番地まで)</label>
      <input type="text" name="address" id="address" class="form-control" value="{{ $item->address }}">
    </div>

    <div class="mb-3">
      <label for="amulet" class="form-label fw-bolder">購入したいもの(正式名称、金額、参考URL、画像)</label>
      <textarea name="amulet" id="amulet" class="form-control" rows="3">{{ $item->amulet }}</textarea>
      <div class="my-2">
        <input type="file" name="img_url" class="form-control" accept="image/png, image/jpeg">
      </div>
      <a href="{{asset($item->img_url)}}">添付画像</a>
    </div>

    <div class="mb-3">
      <label for="free" class="form-label fw-bolder">その他</label>
      <textarea name="free" id="free" class="form-control" rows="3">{{ $item->free }}</textarea>
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