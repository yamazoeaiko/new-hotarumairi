@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12 list-group">
      <h1>通知一覧</h1>
      @foreach ($items as $item)
      <form action="{{route('announcement.read')}}" method="post" class="list-group-item list-group-action mb-3">
        @csrf
        <input type="hidden" name="link_path" value="{{$item->link}}">
        <input type="hidden" name="announcement_id" value="{{$item->id}}">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ $item->title }}</h5>
            <p class="card-text"><small class="text-muted">{{ $item->created_at->format('Y/m/d H:i') }}</small></p>
            <button type="submit" class="btn btn-primary">Read</button>
          </div>
        </div>
      </form>
      @endforeach
    </div>
  </div>
</div>
@endsection