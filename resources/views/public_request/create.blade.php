@extends('layouts.app')
@section('content')
<div class="container">
  <h5>公開依頼の作成</h5>
  <form action="{{ route('pubreq.create.done') }}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="request_user_id" value="{{ $user_id }}">
    <input type="hidden" name="type" value="public_request">
    <div class="mb-3">
      <label for="main_title" class="fw-bolder"> 依頼タイトル<span class="fs-7 text-danger ">※必須(20字以内)</span></label>
      <input type="text" name="main_title" class="form-control fw-bolder">
    </div>

    <div class="mb-3">
      <label for="content" class="fw-bolder">依頼内容<span class="fs-7 text-danger ">※必須(公開ページになりますので本名、住所などの個人情報の記載はしないでください)</span></label>
      <div class="input-group">
        <textarea name="content" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。"></textarea>
      </div>
    </div>

    <div class="mb-3">
      <label for="category_id" class="fw-bolder">依頼カテゴリー(複数選択可能)<span class="fs-7 text-danger ">※必須</span></label>
      @foreach($categories as $category)
      <div class="form-check">
        <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="form-check-input">
        <label class="form-check-label">{{ $category->name }}</label>
      </div>
      @endforeach
    </div>

    <div class="form-group">
      <label class="fw-bolder" for="photo_1">依頼内容に関する画像やファイル（１枚目）<span class="fs-7 text-secondary">※任意</span></label>
      <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_1" value="{{old('photo_1')}}">
    </div>

    <div class="form-group">
      <label class="fw-bolder" for="photo_2">依頼内容に関する画像やファイル（２枚目）<span class="fs-7 text-secondary">※任意</span></label>
      <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_2" value="{{old('photo_2')}}">
    </div>

    <div class="form-group">
      <label class="fw-bolder" for="photo_3">依頼内容に関する画像やファイル（３枚目）<span class="fs-7 text-secondary">※任意</span></label>
      <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_3" value="{{old('photo_3')}}">
    </div>

    <div class="form-group">
      <label class="fw-bolder" for="photo_4">依頼内容に関する画像やファイル（４枚目）<span class="fs-7 text-secondary">※任意</span></label>
      <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_4" value="{{old('photo_4')}}">
    </div>
    <div class="text-danger fs-7">画像やファイルが５点以上になる場合は、別途チャットで送付できます。</div>
    <div class="mb-3">
      <label for="area_id" class="fw-bolder">エリア(複数選択可能)<span class="fs-7 text-secondary">※任意</span></label>
      <div>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseOthers">全国(エリア指定なし)</button>
        <div class="collapse" id="collapseOthers">
          @foreach($areas as $area)
          @if($area->category == 'その他')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}

          </label>
          @endif
          @endforeach
        </div>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseHokkaido">北海道エリア</button>
        <div class="collapse" id="collapseHokkaido">
          @foreach($areas as $area)
          @if($area->category == '北海道エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}

          </label>
          @endif
          @endforeach
        </div>

        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseTohoku">東北エリア</button>
        <div class="collapse" id="collapseTohoku">
          @foreach($areas as $area)
          @if($area->category == '東北エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>

        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKanto">関東エリア</button>
        <div class="collapse" id="collapseKanto">
          @foreach($areas as $area)
          @if($area->category == '関東エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>

        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseChubu">中部エリア</button>
        <div class="collapse" id="collapseChubu">
          @foreach($areas as $area)
          @if($area->category == '中部エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>

        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKinki">近畿エリア</button>
        <div class="collapse" id="collapseKinki">
          @foreach($areas as $area)
          @if($area->category == '近畿エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>

        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseChugoku">中国エリア</button>
        <div class="collapse" id="collapseChugoku">
          @foreach($areas as $area)
          @if($area->category == '中国エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>

        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseShikoku">四国エリア</button>
        <div class="collapse" id="collapseShikoku">
          @foreach($areas as $area)
          @if($area->category == '四国エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>

        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKyushu">九州エリア</button>
        <div class="collapse" id="collapseKyushu">
          @foreach($areas as $area)
          @if($area->category == '九州エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>

        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseOkinawa">沖縄エリア</button>
        <div class="collapse" id="collapseOkinawa">
          @foreach($areas as $area)
          @if($area->category == '沖縄エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(is_array(old('area_id')) && in_array($area->id, old('area_id')))checked
            @endif />

            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label for="attention" class="fw-bolder">ご提案時の注意事項<span class="fs-7 text-secondary">※任意</span></label>
      <div class="input-group">
        <textarea name="attention" class="text-start input-group-text is-valid" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。"></textarea>
      </div>
    </div>

    <div class="mb-3">
      <label for="price" class="fw-bolder">予算(税別)<span class="fs-7 text-danger">※必須<br>
          物品購入などのサービスに付随し発生する費用を含んだ金額。</span></label>
      <div class="input-group">
        <input type="number" class="form-control" name="price" id="price" required>
        <div class="input-group-append">
          <span class="input-group-text">円（税別）</span>
        </div>
      </div>
    </div>

    <!--
    <div class="mb-3">
      <label for="application_deadline" class="fw-bolder">応募締切日<span class="fs-7 text-secondary">※任意</span></label>
      <div class="input-group">
        <input type="date" name="application_deadline" min="<?php echo date('Y-m-d'); ?>">
      </div>
    </div>
    -->

    <div class="mb-3">
      <label for="delivery_deadline" class="fw-bolder">希望納品(実施)日<span class="fs-7 text-secondary">※任意</span></label>
      <div class="input-group">
        <input type="date" name="delivery_deadline" min="<?php echo date('Y-m-d'); ?>">
      </div>
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="free">自由記入欄<span class="fs-7 text-secondary" placeholder="その他なにかあればご自由にご記載ください。（任意）">※任意</span></label>
      <textarea class="form-control" name="free" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。"></textarea>
    </div>

    <div class="mb-3">
      <label for="status" class="fw-bolder">公開/非公開</label>
      <div class="form-check form-switch">
        <input class="form-check-input" type="radio" id="public_radio" name="status" value="open" checked>
        <label class="form-check-label" for="public_radio">公開</label>
      </div>

      <div class="form-check form-switch">
        <input class="form-check-input" type="radio" id="private_radio" name="status" value="closed">
        <label class="form-check-label" for="private_radio">非公開</label>
      </div>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-primary mt-3">公開依頼に登録</button>
    </div>
  </form>
</div>
@endsection