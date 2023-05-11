@extends('layouts.app')

@section('content')
<div class="container">
  <div class="form-control">
    <div class="mb-3 row">
      <div class="col-md-4">
        <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img">
      </div>
      <div class="col-md-8">
        <div class="mb-3">
          <p class="fw-bolder fs-3">{{ $item->main_title }}</p>
        </div>
        @if($item->categories)
        <div>
          カテゴリー：
          @foreach($item->categories as $value)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
          @endforeach
        </div>
        @endif
        <div class="mb-3">
          <p class="card-text mb-0">
            <small class="text-muted">ユーザー名：</small>
            {{$item->user_name}}
          </p>
          <p class="card-text mb-0">
            <small class="text-muted">年齢：</small>{{ $item->age }}歳
          </p>
          <p class="card-text mb-0">
            <small class="text-muted">住まい地域：</small>{{ $item->living_area }}
          </p>
        </div>
        <div class="mb-3">
          <div class="owl-carousel owl-theme">
            @foreach (range(1, 8) as $i)
            @php
            $photo = "photo_" . $i;
            @endphp
            @if ($item->$photo !== null)
            <img src="{{asset($item->$photo)}}" style=" width: 300px; height: 200px;">
            @endif
            @endforeach
          </div>
        </div>
        <div class="mb-3">
          <label for="price" class="fw-bolder">サービス価格</label>
          <div class="input-group">
            <input type="number" name="price" class="form-control" value="{{$item->price}}" readonly>
            <div class="input-group-append">
              <span class="input-group-text">円（税別）</span>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label for="content" class="fw-bolder">サービス内容</label>
          <textarea name="content" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->content }}</textarea>
        </div>

        @if($item->area_ids)
        <div class="mb-3">
          <label for="area_id" class="fw-bolder">対応可能エリア</label>
          @foreach($item->area_ids as $area_id)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success">{{ $area_id->name}}</small>
          @endforeach
        </div>
        @endif

        <div class="mb-3">
          <label for="attention" class="fw-bolder">注意事項</label>
          <textarea name="attention" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->attention }}</textarea>
        </div>

        <div class="form-group mb-3">
          <label class="fw-bolder" for="delivery_deadline">希望納品（実施）日</label>
          <input type="date" class="form-control" name="delivery_deadline" value="{{$item->delivery_deadline}}" readonly>
        </div>

        <div class="form-group mb-3">
          <label class="fw-bolder" for="application_deadline">応募締切日</label>
          <input type="date" class="form-control" name="application_deadline" value="{{$item->application_deadline}}" readonly>
        </div>
        <div class="mb-3">
          <label for="free" class="fw-bolder">自由記入欄</label>
          <textarea name="free" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->free }}</textarea>
        </div>
      </div>
    </div>
    @if($item->request_user_id !== $user_id)
    @if($room_id)
    <div class="text-center">
      <button class="btn btn-success" onclick=location.href="{{route('chat.room',['room_id'=>$room_id])}}">チャット画面</button>
    </div>
    @else
    <div class="text-center">
      <button type="button" class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#collapseConsult">お見積りやサービス内容を提案する（チャットする）</button>

      <div class="collapse" id="collapseConsult">
        <form action="{{route('service.offer.send')}}" method="post">
          @csrf
          <input type="hidden" name="sell_user" value="{{$user_id}}">
          <input type="hidden" name="buy_user" value="{{ $item->request_user_id }}">
          <input type="hidden" name="service_id" value="{{ $item->id }}">
          <div style="padding-right: 0;">
            <div class="input-group">
              <textarea name="first_chat" class="text-start input-group-text is-valid my-3" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.form.submit();}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Shift+Enterで改行。Enterで送信。"></textarea>
              <div class="form-group">
                <input type="file" name="file_path">
              </div>
              <div class="input-group-append">
                <button class="btn btn-outline-primary" type="submit">送信</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    @endif
    @elseif($item->request_user_id == $user_id)
    <div class="text-center my-1">
      <button class="btn btn-primary" onclick=location.href="{{route('mypage.service.edit',['service_id'=>$item->id])}}">公開依頼内容を編集する</button>
    </div>
    @endif