@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-grid gap-4">
    <button onclick="location.href='{{route('search.index')}}'" class="btn btn-primary p-3">
      代行できる依頼を探す
    </button>
    <button onclick="location.href='{{route('service.create')}}'" class="btn btn-primary p-3">
      サービスを出品する
    </button>
  </div>
</div>
@endsection