@extends('layouts.admin')
@section('content')
<div class="container">
  <h5>【管理画面】出品サービス編集</h5>
  <div class="container">
    <form action="{{ route('admin.service.update') }}" method="post" class="form-control" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="service_id" value="{{ $item->id }}">
      <div class="mb-3">
        <label for="main_title" class="fw-bolder"> サービスタイトル（20字以内）<span class="fs-7 text-danger ">※必須</span></label>
        <input type="text" name="main_title" class="form-control fw-bolder" value="{{ $item->main_title }}">
        @if($errors->has('main_title'))
        <div class="fs-8 text-danger">エラー：サービスタイトルは必須です。
        </div>
        @endif
      </div>

      <div class="mb-3">
        <label for="content" class="fw-bolder">サービス内容<span class="fs-7 text-danger ">※必須</span></label>
        <div class="input-group">
          <textarea name="content" class="text-start input-group-text is-valid" style="resize: none; height: 150px; overflow-y: auto; padding: 10px; width: 100%;" oninput="this.style.height = '150px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="サービス内容、購入者のメリット、アピールポイントなどを具体的にご記載ください。">{{ $item->content }}</textarea>
        </div>
        @if($errors->has('content'))
        <div class="fs-8 text-danger">エラー：サービス内容は必須です。
        </div>
        @endif
      </div>

      <div class="mb-3">
        <label for="category_ids" class="fw-bolder">出品カテゴリー(複数選択可能))<span class="fs-7 text-danger ">※必須</span>
        </label>
        @foreach ($categories as $category)
        <div class="form-check">
          <input type="checkbox" class="form-check-input" name="category_ids[]" value="{{ $category->id }}" @if($item->categories){{ (in_array($category->id, $item->categories->pluck('id')->toArray())) ? 'checked' : '' }}@endif>
          <label class="form-check-label">{{ $category->name }}</label>
        </div>
        @endforeach
        @if($errors->has('category_id'))
        <div class="fs-8 text-danger">エラー：出品カテゴリーは必須です。
        </div>
        @endif
      </div>

      <div class="form-group mb-3">
        <label class="fw-bolder" for="photo_1">イメージ画像（１枚目）<span class="fs-7 text-danger ">※イメージ画像１枚は必須</span></label>
        @if($item->photo_1)
        <a href="{{asset($item->photo_1)}}">画像①</a>
        @endif
        <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_1" value="{{$item->photo_1}}">
      </div>

      <div class="form-group mb-3">
        <label class="fw-bolder" for="photo_2">イメージ画像（２枚目）<span class="fs-7 text-secondary ">※２枚目以降は任意</span></label>
        @if($item->photo_2)
        <a href="{{asset($item->photo_2)}}">画像②</a>
        @endif
        <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_2" value="{{$item->photo_2}}">
      </div>

      <div class="form-group mb-3">
        <label class="fw-bolder" for="photo_3">イメージ画像（３枚目）</label>
        @if($item->photo_3)
        <a href="{{asset($item->photo_3)}}">画像③</a>
        @endif
        <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_3" value="{{$item->photo_3}}">
      </div>

      <div class="form-group mb-3">
        <label class="fw-bolder" for="photo_4">イメージ画像（４枚目）</label>
        @if($item->photo_4)
        <a href="{{asset($item->photo_4)}}">画像④</a>
        @endif
        <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_4" value="{{$item->photo_4}}">
      </div>

      <div class="form-group mb-3">
        <label class="fw-bolder" for="photo_5">イメージ画像（５枚目）</label>
        @if($item->photo_5)
        <a href="{{asset($item->photo_5)}}">画像⑤</a>
        @endif
        <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_5" value="{{$item->photo_5}}">
      </div>

      <div class="form-group mb-3">
        <label class="fw-bolder" for="photo_6">イメージ画像（６枚目）</label>
        @if($item->photo_6)
        <a href="{{asset($item->photo_6)}}">画像⑥</a>
        @endif
        <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_6" value="{{$item->photo_6}}">
      </div>

      <div class="form-group mb-3">
        <label class="fw-bolder" for="photo_7">イメージ画像（７枚目）</label>
        @if($item->photo_7)
        <a href="{{asset($item->photo_7)}}">画像⑦</a>
        @endif
        <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_7" value="{{$item->photo_7}}">
      </div>

      <div class="form-group mb-3">
        <label class="fw-bolder" for="photo_8">イメージ画像（８枚目）</label>
        @if($item->photo_8)
        <a href="{{asset($item->photo_8)}}">画像⑧</a>
        @endif
        <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="photo_8" value="{{$item->photo_8}}">
      </div>


      <div class="mb-3">
        <label for="area_id" class="fw-bolder">対応エリア(複数選択可能)<span class="fs-7 text-secondary">※任意</span></label>
        <div>
          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseOthers">全国(エリア指定なし)</button>
          <div class="collapse" id="collapseOthers">
            @foreach($areas as $area)
            @if($area->category == 'その他')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>
          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseHokkaido">北海道エリア</button>
          <div class="collapse" id="collapseHokkaido">
            @foreach($areas as $area)
            @if($area->category == '北海道エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>

          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseTohoku">東北エリア</button>
          <div class="collapse" id="collapseTohoku">
            @foreach($areas as $area)
            @if($area->category == '東北エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>

          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKanto">関東エリア</button>
          <div class="collapse" id="collapseKanto">
            @foreach($areas as $area)
            @if($area->category == '関東エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>

          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseChubu">中部エリア</button>
          <div class="collapse" id="collapseChubu">
            @foreach($areas as $area)
            @if($area->category == '中部エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>

          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKinki">近畿エリア</button>
          <div class="collapse" id="collapseKinki">
            @foreach($areas as $area)
            @if($area->category == '近畿エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>

          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseChugoku">中国エリア</button>
          <div class="collapse" id="collapseChugoku">
            @foreach($areas as $area)
            @if($area->category == '中国エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>

          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseShikoku">四国エリア</button>
          <div class="collapse" id="collapseShikoku">
            @foreach($areas as $area)
            @if($area->category == '四国エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>

          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseKyushu">九州エリア</button>
          <div class="collapse" id="collapseKyushu">
            @foreach($areas as $area)
            @if($area->category == '九州エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>

          <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseOkinawa">沖縄エリア</button>
          <div class="collapse" id="collapseOkinawa">
            @foreach($areas as $area)
            @if($area->category == '沖縄エリア')
            <label class="fw-bolder" for="area_id" class="mr-1">
              <input type="checkbox" class="form-check-input" name="area_id[]" value="{{ $area->id }}" @if($item->area_id){{ (in_array($area->id, $item->area_ids->pluck('id')->toArray())) ? 'checked' : '' }}@endif>

              {{$area->name}}

            </label>
            @endif
            @endforeach
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="attention" class="fw-bolder">購入時の注意事項<span class="fs-7 text-secondary">※任意</span></label>
        <div class="input-group">
          <textarea name="attention" class="text-start input-group-text is-valid" style="resize: none; height: 150px; overflow-y: auto; padding: 10px; width: 100%;" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="購入前に教えて欲しいことなどがあれば、ご記載ください。（任意）">{{ $item->attention }}</textarea>
        </div>
      </div>

      <div class="mb-3">
        <label for="price" class="fw-bolder">サービス価格<span class="fs-7 text-danger">※必須<br>
            物品購入などのサービスに付随し発生する費用を含んだ金額。</span></label>
        <div class="input-group">
          <input type="number" class="form-control" name="price" id="price" required value="{{ $item->price }}">
          <div class="input-group-append">
            <span class="input-group-text">円（税別）</span>
          </div>
        </div>
      </div>




      <div class="form-group mb-3">
        <label class="fw-bolder" for="free">自由記入欄<span class="fs-7 text-secondary" placeholder="その他なにかあればご自由にご記載ください。（任意）">※任意</span></label>
        <textarea class="form-control" name="free">{{$item->free}}</textarea>
      </div>

      <div class="mb-3">
        <label for="status" class="fw-bolder">公開/非公開</label>
        <div class="form-check form-switch">
          <input class="form-check-input" type="radio" id="public_radio" name="status" value="1" @if($item->status == 'open') checked @endif>
          <label class="form-check-label" for="public_radio">公開</label>
        </div>

        <div class="form-check form-switch">
          <input class="form-check-input" type="radio" id="private_radio" name="status" value="2" @if($item->status == 'closed')checked @endif>
          <label class="form-check-label" for="private_radio">非公開</label>
        </div>
      </div>

      <div class="text-center mt-3">
        <button class="btn btn-primary">更新する</button>
      </div>
    </form>
    <div class="text-center">
      <button class="btn btn-outline-primary" onClick="location.href='{{route('admin.service.detail',['service_id'=>$item->id])}}'">戻る</button>
    </div>
  </div>
  @endsection