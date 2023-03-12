@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{route('request.session.save')}}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" id="" value="{{$user_id}}">
    <div>
      <div class="fw-bolder">プラン</div>
      <select name="plan_id" id="plan_id" class="form-control fw-bolder">
        <option value="3">神社仏閣参拝・祈祷代行</option>
      </select>
    </div>

    <div class="my-3">
      <div class="fw-bolder">日程</div>
      <div class="input-group">
        <input type="date" name="date_begin" id="" class="form-control">
        <div class="input-group-text">〜</div>
        <input type="date" name="date_end" class="form-control">
      </div>
    </div>

    <div class="my-3">
      <div class="fw-bolder">該当の神社仏閣の都道府県</div>
      <select name="area_id" id="" class="form-select">
        @foreach($areas as $area)
        <option value="{{$area->id}}">{{$area->name}}</option>
        @endforeach
      </select>
    </div>

    <div class="my-3">
      <div class="fw-bolder">神社仏閣市町村(可能ならば番地まで)</div>
      <input type="text" name="address" class="form-control">
    </div>

    <div class="my-3">
      <div class="fw-bolder">ご希望の参拝、祈祷内容</div>
      <textarea name="praying" cols="30" rows="3" class="form-control"></textarea>
    </div>

    <div class="my-3">
      <div class="fw-bolder d-block mb-2">ご依頼概要(複数選択可能)</div>
      @foreach($summaries as $summary)
      <div class="form-check">
        <input type="checkbox" name="sanpai_sum_id[]" value="{{$summary->id}}" class="form-check-input">
        <label class="form-check-label fw-normal">{{$summary->name}}</label>
      </div>
      @endforeach
    </div>

    <div class="my-3">
      <div class="fw-bolder">御朱印の有無</div>
      <div class="form-check">
        <input type="radio" name="goshuin" id="0" value="0" checked>
        <label class="form-check-label fw-normal" for="0">不要</label>
      </div>
      <div class="form-check">
        <input type="radio" name="goshuin" id="1" value="1" data-bs-toggle="collapse" data-bs-target="#collapseGoshuin">
        <label for="1" class="form-check-label fw-normal">要</label>
      </div>
      <div class="collapse" id="collapseGoshuin">
        <span class="d-block my-2">御朱印の詳細を記入<br>御朱印の名称、郵送希望・画像送付希望など<br>住所など個人情報は記載しないでください（個別チャットでやり取り）</span>
        <textarea name="goshuin_content" id="" cols="30" rows="3" class="form-control"></textarea>
      </div>
    </div>
    <div class="mb-3">
      <label for="img_url" class="form-label fw-bolder">購入したいもの(正式名称、金額、参考URL、画像)</label>
      <input type="file" name="img_url" id="img_url" class="my-2 form-control" accept="image/png, image/jpeg">
    </div>
    <div class="mb-3">
      <label for="free" class="form-label fw-bolder">その他</label>
      <textarea name="free" id="free" class="form-control" rows="3"></textarea>
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