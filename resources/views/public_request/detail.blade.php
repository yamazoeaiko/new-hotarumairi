@extends('layouts.app')

@section('content')

<div class="container">
  <h5 class="my-2 fw-bold">公開依頼の詳細</h5>
  <div class="form-control">
    <div class="mb-3 row">
      <div class="col-2">
        <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img">
      </div>
      <div class="col-10">
        <div class="mb-3">
          <label for="main_title" class="fw-bolder"> 依頼タイトル<span class="fs-7 text-danger ">※必須</span></label>
          <div class="fw-bolder fs-5">{{ $item->main_title }}</div>
        </div>
        @if($item->categories)
        <div>
          依頼カテゴリー：
          @foreach($item->categories as $value)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
          @endforeach
        </div>
        @endif
        <div class="mb-3">
          <p class="card-text mb-0">
            <small class="text-muted">アカウント名：</small>
            {{$item->user_name}}
          </p>
          <p class="card-text mb-0">
            <small class="text-muted">年齢：</small>@if ($item->age >= 10 && $item->age < 20) 10代 @elseif ($item->age >= 20 && $item->age < 30) 20代 @elseif ($item->age >= 30 && $item->age < 40) 30代 @elseif ($item->age >= 40 && $item->age < 50) 40代 @elseif ($item->age >= 50 && $item->age < 60) 50代 @elseif ($item->age >= 60 && $item->age < 70) 60代 @elseif ($item->age >= 70 && $item->age < 80) 70代 @elseif ($item->age >= 80 && $item->age < 90) 80代 @elseif ($item->age >= 90 && $item->age < 100) 90代 @else その他の年齢 @endif </p>
                              <p class="card-text mb-0">
                                <small class="text-muted">住まい地域：</small>{{ $item->living_area }}
                              </p>
        </div>

        <div class="mb-3">
          <label for="content" class="fw-bolder">依頼内容<span class="fs-7 text-danger ">※必須</span></label>
          <textarea name="content" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->content }}</textarea>
        </div>

        <div class="mb-3">
          <label for="price" class="fw-bolder">予算(税別)<span class="fs-7 text-danger">※必須<br>
              物品購入などのサービスに付随し発生する費用を含んだ金額。</span></label>
          <div class="input-group">
            <input type="number" name="price" class="form-control" value="{{$item->price}}" readonly>
            <div class="input-group-append">
              <span class="input-group-text">円（税別）</span>
            </div>
          </div>
        </div>

        @if($item->area_ids)
        <div class="mb-3">
          <label for="area_id" class="fw-bolder">エリア(複数選択可能)<span class="fs-7 text-secondary">※任意</span></label>
          @foreach($item->area_ids as $area_id)
          <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success">{{ $area_id->name}}</small>
          @endforeach
        </div>
        @endif

        <div class="mb-3">
          <label for="attention" class="fw-bolder">ご提案時の注意事項<span class="fs-7 text-secondary">※任意</span></label>
          <textarea name="attention" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->attention }}</textarea>
        </div>

        <div class="form-group mb-3">
          <label for="application_deadline" class="fw-bolder">応募締切日<span class="fs-7 text-secondary">※任意</span></label>
          <input type="date" class="form-control" name="application_deadline" value="{{$item->application_deadline}}" readonly>
        </div>
        <div class="form-group mb-3">
          <label for="delivery_deadline" class="fw-bolder">希望納品(実施)日<span class="fs-7 text-secondary">※任意</span></label>
          <input type="date" class="form-control" name="delivery_deadline" value="{{$item->delivery_deadline}}" readonly>
        </div>

        <div class="mb-3">
          <label for="free" class="fw-bolder">自由記入欄</label>
          <textarea name="free" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->free }}</textarea>
        </div>
        @if($item->photo_1)
        <div class="mb-3">
          <p class="fw-bolder">添付ファイル</p>
          <a href="{{ asset($item->photo_1) }}" class="fc-blue ">画像・ファイル①</a>
        </div>
        @endif
        @if($item->photo_2)
        <div class="mb-3">
          <a href="{{ asset($item->photo_2) }}" class="fc-blue">画像・ファイル②</a>
        </div>
        @endif
        @if($item->photo_3)
        <div class="mb-3">
          <a href="{{ asset($item->photo_3) }}" class="fc-blue fw-bolder">画像・ファイル③</a>
        </div>
        @endif
        @if($item->photo_4)
        <div class="mb-3">
          <a href="{{ asset($item->photo_4) }}" class="fc-blue">画像・ファイル④</a>
        </div>
        @endif
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
              <textarea name="first_chat" class="text-start form-control my-3" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" oninput="resizeTextarea(this)" placeholder="Enterで改行されます。"></textarea>
              <div class="form-group">
                <input type="file" accept=".png, .jpeg, .jpg" name="file_path">
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
      <button class="btn btn-primary" onclick=location.href="{{route('pubreq.edit',['service_id'=>$item->id])}}">公開依頼内容を編集する</button>
    </div>
    @endif
  </div>
</div>
@endsection
<script>
  function resizeTextarea(textarea) {
    textarea.style.height = '70px';
    textarea.style.height = textarea.scrollHeight + 'px';
  }

  const textarea = document.querySelector('textarea');
  textarea.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      const startPos = textarea.selectionStart;
      const endPos = textarea.selectionEnd;
      textarea.value = textarea.value.substring(0, startPos) + '\n' + textarea.value.substring(endPos, textarea.value.length);
      resizeTextarea(textarea);
    }
  });
</script>