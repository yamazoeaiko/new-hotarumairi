@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{route('request.done')}}" method="post" class="form-control">
    @csrf
    <input type="hidden" name="user_id" value="{{ $params->user_id }}">
    <div class="mb-3">
      <label for="plan_id" class="fw-bolder">プラン</label>
      <select name="plan_id" id="plan_id" class="form-control fw-bolder" readonly>
        <option value="1">お墓のお掃除・お参り代行</option>
      </select>
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
      <label for="area_id" class="fw-bolder">該当のお墓の都道府県</label>
      <input name="area_id" id="area_id" value="{{ $params->area_id }}" hidden>
      <input type="text" class="form-control" readonly value="{{ $params->area_name }}">
    </div>

    <div class="mb-3">
      <label for="address" class="fw-bolder">お墓の市町村(可能ならば番地まで)</label>
      <input type="text" name="address" id="address" class="form-control" value="{{ $params->address }}" readonly>
    </div>

    <div class="mb-3">
      <label class="fw-bolder d-block mb-2">ご依頼概要(複数選択可能)</label>
      @foreach($summaries as $summary)
      @if(in_array($summary->id, $ohakamairi_sum_ids))
      <div class="form-check">
        <input type="checkbox" name="ohakamairi_sum_id[]" value="{{ $summary->id }}" class="form-check-input" checked disabled>
        <label class="form-check-label">{{ $summary->name }}</label>
      </div>
      @endif
      @endforeach
      <input type="hidden" name="ohakamairi_sum" value="{{ $ohakamairi_sum }}">

    </div>

    <div class="mb-3">
      <label class="fw-bolder d-block mb-2">お供え物・墓花・お線香マナーなどのご要望があれば</label>
      <textarea name="offering" cols="30" rows="3" class="form-control" readonly>{{$params->offering}}</textarea>
    </div>

    <div class="mb-3">
      <label class="fw-bolder d-block mb-2">お墓のお掃除に関して要望があれば</label>

      <textarea name="cleaning" cols="30" rows="3" class="form-control" readonly>{{$params->cleaning}}</textarea>
    </div>
    <div class="mb-3">
      <label class="fw-bolder mb-2">画像添付(任意)</label>
      <input type="hidden" name="img_url" value="{{$path}}">

      <p><a href="{{ asset($path) }}">{{ $fileName }}</a></p>
    </div>

    <div class="mb-3">
      <label for="fress" class="fw-bolder">その他
      </label>
      <div class="input-group">
        <textarea name="free" id="" cols="30" rows="3" class="form-control" readonly>{{$params->free}}
        </textarea>
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