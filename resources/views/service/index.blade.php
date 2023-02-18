@component('components.app')
@endcomponent
@component('components.header')
@endcomponent
<div class="container">
  <h5>出品サービス一覧</h5>
  @foreach($items as $item)
  <button onClick="location.href='{{ route('service.detail',['service_id'=>$item->id]) }}'" class="card m-4 shadow card-point" style="max-width: 500px;">
    <div class="row no-gutters">
      <div class="col-md-4">
        <img src="{{ asset($item->img_url) }}" alt="Profile image" class="card-img">
        <p class="card-text mb-0">{{$item->user_name}}</p>
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <div>
            @foreach($item->categories as $value)
            <small class="d-inline-flex align-items-center justify-content-center rounded-pill border mb-1 p-1">{{ $value->category_name}}</small>
            @endforeach
          </div>
          <h5 class="card-title">{{$item->main_title}}</h5>
          <p class="card-text mb-0"><small class="text-muted">{{$item->price}}円</small></p>
          <a href="{{ route('service.detail',['service_id'=>$item->id]) }}" class="btn btn-primary stretched-link">詳細を見る</a>
        </div>
      </div>
    </div>
  </button>
  @endforeach
</div>