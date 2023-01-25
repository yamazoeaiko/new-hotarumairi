@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>
  <div class="container">
    <h4>チャットグループ一覧</h4>
    <div class="list-group">
      @foreach($items as $item)
      <button onClick="location.href='{{route('chat.room',['apply_id'=>$item->id])}}'" class="list-group-item list-group-item-action">
        <div class="row no-gutters">
          <div class="col-2">
            <img src="{{ asset($item->profile_img) }}" alt="Profile image" class="card-img">
          </div>
          <div class="col-10">
            <p>{{$you->nickname}}</p>
            <p>{{$item->plan_name}}</p>
          </div>
        </div>
      </button>
      @endforeach
    </div>
  </div>
</body>