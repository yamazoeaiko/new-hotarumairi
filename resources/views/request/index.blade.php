@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-grid gap-4">
    <button onclick="location.href='{{route('request.ohakamairi')}}'" class="btn btn-primary p-3">
      お墓のお掃除・お参り代行を依頼
    </button>
    <button onclick="location.href='{{route('request.omamori')}}'" class="btn btn-primary p-3">
      お守・お札・御朱印購入代行を依頼
    </button>
    <button onclick="location.href='{{route('request.sanpai')}}'" class="btn btn-primary p-3">
      神社仏閣参拝・祈祷代行を依頼
    </button>
    <button onclick="location.href='{{route('request.others')}}'" class="btn btn-primary p-3">
      その他お参り代行をカスタマイズ依頼
    </button>
  </div>
</div>
@endsection