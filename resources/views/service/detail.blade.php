@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <div class="form-control">
      <div class="mb-3 row">
        <div class="col-md-4">
          <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img" style="max-width: 100%; height: auto;">
        </div>
        <div class="col-md-8">
          <div class="mb-3">
            <p class="fw-bolder fs-3">{{ $item->main_title }}</p>
          </div>
          <div>
            @foreach($item->categories as $value)
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
            @endforeach
          </div>
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

          <div class="mb-3">
            <label for="area_id" class="fw-bolder">対応可能エリア</label>
            @foreach($item->area_ids as $area_id)
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1 bg-success">{{ $area_id->name}}</small>
            @endforeach
          </div>

          <div class="mb-3">
            <label for="attention" class="fw-bolder">購入時の注意事項</label>
            <textarea name="attention" id="" cols="30" rows="10" class="form-control" readonly>{{ $item->attention }}</textarea>
          </div>

          <div class="mb-3">
            <label for="public_sign" class="fw-bolder">公開状況</label>
            <div>{{ $item->public }}</div>
          </div>
        </div>
      </div>
      @if($item->user_id !== $user_id)
      <div class="text-center">
        <button type="button" class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#collapseConsult">お見積りやサービス内容の相談をする</button>

        <div class="collapse" id="collapseConsult">
          <form action="{{route('service.consult.send')}}" method="post">
            @csrf
            <input type="hidden" name="consulting_user" value="{{$user_id}}">
            <input type="hidden" name="host_user" value="{{ $item->user_id }}">
            <input type="hidden" name="service_id" value="{{ $item->id }}">
            <textarea name="first_chat" id="first_chat" cols="80" rows="10" class="text-start m-3">※必ず記載してください。
            </textarea>
            <button type="submit" class="btn btn-primary col-3">送信する</button>
          </form>
        </div>
      </div>
      @elseif($item->user_id == $user_id)
      <div class="row my-1">
        <button class="col btn btn-primary" onclick=location.href="{{route('mypage.service.edit',['service_id'=>$item->id])}}">編集する</button>
      </div>
      @endif
</body>