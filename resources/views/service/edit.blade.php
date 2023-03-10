@extends('layouts.app')

@section('content')
<div class="container">
  <form action="{{ route('mypage.service.update') }}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="service_id" value="{{ $item->id }}">
    <div class="mb-3">
      <label for="main_title" class="fw-bolder"> サービスタイトル</label>
      <input type="text" name="main_title" class="form-control fw-bolder" value="{{ $item->main_title }}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_1">Photo 1</label>
      @if($item->photo_1)
      <a href="{{asset($item->photo_1)}}">画像①</a>
      @endif
      <input type="file" class="form-control" name="photo_1" value="{{$item->photo_1}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_2">Photo 2</label>
      @if($item->photo_2)
      <a href="{{asset($item->photo_2)}}">画像②</a>
      @endif
      <input type="file" class="form-control" name="photo_2" value="{{$item->photo_2}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_3">Photo 3</label>
      @if($item->photo_3)
      <a href="{{asset($item->photo_3)}}">画像③</a>
      @endif
      <input type="file" class="form-control" name="photo_3" value="{{$item->photo_3}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_4">Photo 4</label>
      @if($item->photo_4)
      <a href="{{asset($item->photo_4)}}">画像④</a>
      @endif
      <input type="file" class="form-control" name="photo_4" value="{{$item->photo_4}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_5">Photo 5</label>
      @if($item->photo_5)
      <a href="{{asset($item->photo_5)}}">画像⑤</a>
      @endif
      <input type="file" class="form-control" name="photo_5" value="{{$item->photo_5}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_6">Photo 6</label>
      @if($item->photo_6)
      <a href="{{asset($item->photo_6)}}">画像⑥</a>
      @endif
      <input type="file" class="form-control" name="photo_6" value="{{$item->photo_6}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_7">Photo 7</label>
      @if($item->photo_7)
      <a href="{{asset($item->photo_7)}}">画像⑦</a>
      @endif
      <input type="file" class="form-control" name="photo_7" value="{{$item->photo_7}}">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="photo_8">Photo 8</label>
      @if($item->photo_8)
      <a href="{{asset($item->photo_8)}}">画像⑧</a>
      @endif
      <input type="file" class="form-control" name="photo_8" value="{{$item->photo_8}}">
    </div>


    <div class="mb-3">
      <label for="content" class="fw-bolder">サービス内容</label>
      <div class="input-group">
        <textarea name="content" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで送信。Shift+Enterで改行">{{ $item->content }}</textarea>
      </div>
    </div>

    <div class="mb-3">
      <label for="category_id" class="fw-bolder">出品カテゴリー(複数選択可能)</label>
      @if($item->categories)
      @foreach($categories as $category)
      <div class="form-check">
        <input type="checkbox" name="category_id[]" value="{{ $category->id }}" class="form-check-input" @if(in_array($category->id, $item->category_ids)) checked @endif>
        <label class="form-check-label">{{ $category->name }}</label>
      </div>
      @endforeach
      @endif
    </div>


    <div class="mb-3">
      <label for="area_id" class="fw-bolder">対応エリア(複数選択可能)</label>
      @if($item->area_ids)
      <div>
        <button type="button" class="btn btn-outline-success" data-bs-toggle="collapse" data-bs-target="#collapseHokkaido">北海道エリア</button>
        <div class="collapse" id="collapseHokkaido">
          @foreach($areas as $area)
          @if($area->category == '北海道エリア')
          <label for="area_id" class="mr-1">
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>
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
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>
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
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>
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
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>
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
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>

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
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>

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
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>

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
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>

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
            <input type="checkbox" name="area_id[]" value="{{$area->id}}" multiple @if(in_array($area->id, $item->area_id))checked @endif>
            {{$area->name}}
          </label>
          @endif
          @endforeach
        </div>
      </div>
      @endif
    </div>

    <div class="mb-3">
      <label for="attention" class="fw-bolder">購入時の注意事項</label>
      <div class="input-group">
        <textarea name="attention" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで送信。Shift+Enterで改行">{{ $item->attention }}</textarea>
      </div>
    </div>

    <div class="mb-3">
      <label for="price" class="fw-bolder">サービス価格<span>物品購入などのサービスに付随し発生する費用は除く。</span></label>
      <div class="input-group">
        <input type="number" class="form-control" name="price" id="price" required value="{{ $item->price }}">
        <div class="input-group-append">
          <span class="input-group-text">円（税別）</span>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label for="public_sign" class="fw-bolder">公開/非公開</label>
      <div class="form-check form-switch">
        <input class="form-check-input" type="radio" id="public_radio" name="public_sign" value="1" @if($item->public_sign == true) checked @endif>
        <label class="form-check-label" for="public_radio">公開</label>
      </div>

      <div class="form-check form-switch">
        <input class="form-check-input" type="radio" id="private_radio" name="public_sign" value="0" @if($item->public_sign == false)checked @endif>
        <label class="form-check-label" for="private_radio">非公開</label>
      </div>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-primary mt-3">更新する</button>
    </div>
  </form>
</div>
@endsection