@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-10">
    <h5>あなたが応募している代行一覧</h5>
    @if($items->isEmpty())
    <span>現在あなたが応募している案件はございません</span>
    @endif
    <div class="mb-5 mb-lg-0 text-center text-lg-start">
      @foreach($items as $item)
      <button onClick="location.href='{{ route('search.more',['request_id'=>$item->id]) }}'" class="card m-4 shadow card-point bg-success" style="max-width: 500px;">
        <div class="row no-gutters">
          <div class="col-md-4">
            <img src="{{ asset($item->profile_img) }}" alt="Profile image" class="card-img">
            <p class="card-text mb-0">{{$item->user_name}}</p>
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title">{{$item->plan_name}}</h5>
              <p class="card-text mb-0"><small class="text-muted">代行期日：</small>{{$item->date_end}}</p>
              <p class="card-text mb-0"><small class="text-muted">エリア：</small>{{$item->area_name}}</p>
              <p class="card-text mb-0"><small class="text-muted">見積り：</small>{{$item->price_net}}円</p>
              <a href="{{ route('search.more',['request_id'=>$item->id]) }}" class="btn btn-secondary stretched-link">詳細を見る</a>
              <span class="ml-auto mb-2 fs-6 fw-bolder"><i class="bi bi-check-circle"></i> 応募済み</span>
            </div>
          </div>
        </div>
      </button>
      @endforeach
    </div>
  </div>
</div>
@endsection