@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{ route('pubreq.update') }}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="service_id" value="{{ $item->id }}">
    <div class="mb-3">
      <label for="main_title" class="fw-bolder"> 依頼タイトル<span class="fs-7 text-danger ">※必須(20字以内) 
      </span></label>
      <input type="text" name="main_title" class="form-control fw-bolder" value="{{ $item->main_title }}">
      @if($errors->has('main_title'))
      <div class="fs-8 text-danger">エラー：依頼タイトルは必須です。
      </div>
      @endif
    </div>

    <div class="mb-3">
      <label for="content" class="fw-bolder">依頼内容<span class="fs-7 text-danger ">※必須</span></label>
      <div class="input-group">
        <textarea name="content" class="text-start input-group-text is-valid" style="resize: none; height: 150px; overflow-y: auto; padding: 10px; width: 100%;" oninput="this.style.height = '150px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="サービス内容、購入者のメリット、アピールポイントなどを具体的にご記載ください。">{{ $item->content }}</textarea>
      </div>
      @if($errors->has('content'))
      <div class="fs-8 text-danger">エラー：依頼内容は必須です。
      </div>
      @endif
    </div>

    <div class="mb-3">
      <label for="category_id" class="fw-bolder">依頼カテゴリー(複数選択可能)<span class="fs-7 text-danger ">※必須</span></label>
      @foreach ($categories as $category)
      <div class="form-check">
        <input type="checkbox" class="form-check-input" name="category_ids[]" value="{{ $category->id }}" @if($item->categories){{ (in_array($category->id, $item->categories->pluck('id')->toArray())) ? 'checked' : '' }}@endif>
        <label class="form-check-label">{{ $category->name }}</label>
      </div>
      @endforeach
      @if($errors->has('category_id'))
      <div class="fs-8 text-danger">エラー：依頼カテゴリーは必須です。
      </div>
      @endif
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_1">依頼内容に関する画像やファイル（１枚目）<span class="fs-7 text-secondary">※任意</span></label>
      @if($item->photo_1)
      <a href="{{asset($item->photo_1)}}">画像①</a>
      @endif
      <input type="file" class="form-control" name="photo_1" value="{{$item->photo_1}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_2">依頼内容に関する画像やファイル（２枚目）<span class="fs-7 text-secondary">※任意</span></label>
      @if($item->photo_2)
      <a href="{{asset($item->photo_2)}}">画像②</a>
      @endif
      <input type="file" class="form-control" name="photo_2" value="{{$item->photo_2}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_3">依頼内容に関する画像やファイル（３枚目）<span class="fs-7 text-secondary">※任意</span></label>
      @if($item->photo_3)
      <a href="{{asset($item->photo_3)}}">画像③</a>
      @endif
      <input type="file" class="form-control" name="photo_3" value="{{$item->photo_3}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_4">依頼内容に関する画像やファイル（４枚目）<span class="fs-7 text-secondary">※任意</span></label>
      @if($item->photo_4)
      <a href="{{asset($item->photo_4)}}">画像④</a>
      @endif
      <input type="file" class="form-control" name="photo_4" value="{{$item->photo_4}}">
    </div>
    <div class="text-danger fs-7">画像やファイルが５点以上になる場合は、別途チャットで送付できます。</div>


    <div class="mb-3">
      <label for="area_id" class="fw-bolder">エリア(複数選択可能)<span class="fs-7 text-secondary">※任意</span></label>
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
      <label for="attention" class="fw-bolder">ご提案時の注意事項<span class="fs-7 text-secondary">※任意</span></label>
      <div class="input-group">
        <textarea name="attention" class="text-start input-group-text is-valid" style="resize: none; height: 150px; overflow-y: auto; padding: 10px; width: 100%;" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="ご提案時に教えて欲しいことなどがあれば、ご記載ください。（任意）">{{ $item->attention }}</textarea>
      </div>
    </div>

    <div class="mb-3">
      <label for="price" class="fw-bolder">予算(税別)<span class="fs-7 text-danger">※必須<br>
          物品購入などのサービスに付随し発生する費用を含んだ金額。</span></label>
      <div class="input-group">
        <input type="number" class="form-control" name="price" id="price" required value="{{ $item->price }}">
        <div class="input-group-append">
          <span class="input-group-text">円（税別）</span>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label for="application_deadline" class="fw-bolder">応募締切日<span class="fs-7 text-secondary">※任意</span></label>
      <div class="input-group">
        <input type="date" name="application_deadline" value="{{ $item->application_deadline }}">
      </div>
    </div>

    <div class="mb-3">
      <label for="delivery_deadline" class="fw-bolder">希望納品(実施)日<span class="fs-7 text-secondary">※任意</span></label>
      <div class="input-group">
        <input type="date" name="delivery_deadline" value="{{ $item->delivery_deadline }}">
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

    <div class="text-center">
      <button type="submit" class="btn btn-primary mt-3">更新する</button>
    </div>
  </form>
</div>
@endsection