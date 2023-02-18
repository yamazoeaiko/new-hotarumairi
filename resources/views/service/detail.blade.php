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
            <label for="public_sign" class="fw-bolder">公開状況</label>
            <div>{{ $item->public }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>