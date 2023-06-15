@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{route('myrequest.update.sanpai', ['service_id' => $item->id])}}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <div>
      <div class="fw-bolder">プラン</div>
      <select name="plan_id" id="plan_id" class="form-control fw-bolder" readonly>
        <option value="3">神社仏閣参拝・祈祷代行</option>
      </select>
    </div>

    <div class="my-3">
      <div class="fw-bolder">日程</div>
      <div class="input-group">
        <input type="date" name="date_begin" id="" class="form-control" value="{{ $item->date_begin }}">
        <div class="input-group-text">〜</div>
        <input type="date" name="date_end" class="form-control" value="{{ $item->date_end }}">
      </div>
    </div>

    <div class="my-3">
      <div class="fw-bolder">該当の神社仏閣の都道府県</div>
      <div>{{ $item->area_name }}</div>
      <select name="area_id" id="area_id" class="form-control">
        @foreach($areas as $area)
        <option value="{{ $area->id }}">{{ $area->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="my-3">
      <div class="fw-bolder">神社仏閣市町村(可能ならば番地まで)</div>
      <input type="text" name="address" class="form-control" value="{{ $item->address }}">
    </div>

    <div class="my-3">
      <div class="fw-bolder">ご希望の参拝、祈祷内容</div>
      <textarea name="praying" cols="30" rows="3" class="form-control">{{ $item->praying }}</textarea>
    </div>

    <div class="my-3">
      <div class="fw-bolder">ご依頼概要(複数選択可能)</div>
      @foreach ($summaries as $summary)
      <div>
        <input type="checkbox" name="sanpai_sum_id[]" value="{{ $summary->id }}" class="form-check-input" @if(in_array($summary->id, $item->sanpai_sum))checked @endif>
        <label class="form-check-label">{{ $summary->name }}</label>
        @endforeach
      </div>

    </div>

    <div class="my-3">
      <div class="fw-bolder">御朱印の有無</div>
      <div class="form-check">
        <input type="radio" name="goshuin" id="0" value="0" {{ $item->goshuin == 0 ? 'checked' : '' }}>
        <label class="form-check-label fw-normal" for="0">不要</label>
      </div>
      <div class="form-check">
        <input type="radio" name="goshuin" id="1" value="1" data-bs-toggle="collapse" data-bs-target="#collapseGoshuin" {{ $item->goshuin == 1 ? 'checked' : ''  }}>
        <label for="1" class="form-check-label fw-normal">要</label>
      </div>
    </div>
    @if($item->goshuin == 1)
    <div>
      <span class="d-block my-2">御朱印の詳細を記入<br>御朱印の名称、郵送希望・画像送付希望など<br>住所など個人情報は記載しないでください（個別チャットでやり取り）</span>
      <textarea name="goshuin_content" id="" cols="30" rows="3" class="form-control">{{ $item->goshuin_content }}</textarea>
    </div>
    @endif

    <div class="mb-3">
      <label for="img_url" class="form-label fw-bolder">購入したいもの(正式名称、金額、参考URL、画像)</label>
      <div class="my-2">
        <input type="file" accept=".png, .jpeg, .jpg" name="img_url" class="form-control" accept="image/png, image/jpeg">
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

      <div class="text-center mt-3">
        <button name="submit" class="btn btn-primary">内容を更新</button>
        <button type="button" onClick="history.back();" class="btn btn-outline-secondary">修正せずに戻る</button>
      </div>
  </form>
</div>
@endsection