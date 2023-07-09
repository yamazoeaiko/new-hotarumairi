@extends('layouts.admin')
@section('content')
<div class="container">
  <h5 class="my-2 fw-bold">【管理画面】トップページ</h5>

  <div class="card p-2">
    <h6 class="fs-6 fw-bolder">◆お知らせ情報の管理</h6>
    <p class="fs-7 text-danger">現在ユーザーに表示中のお知らせ（最大３つ）</p>
    <table class="table">
      <tr>
        <th>No.</th>
        <th>タイトル</th>
        <th>お知らせ内容</th>
      </tr>
      @if($info_1)
      <tr>
        <td>1</td>
        <td>{{$info_1->title}}</td>
        <td>{{$info_1->content}}</td>
      </tr>
      @endif
      @if($info_2)
      <tr>
        <td>2</td>
        <td>{{$info_2->title}}</td>
        <td>{{$info_2->content}}</td>
      </tr>
      @endif
      @if($info_3)
      <tr>
        <td>3</td>
        <td>{{$info_3->title}}</td>
        <td>{{$info_3->content}}</td>
      </tr>
      @endif
    </table>
    <div class="my-2 text-center">
      <button class="btn btn-primary" onclick=location.href="{{route('admin.informations.edit')}}">変更する</button>
    </div>
  </div>
</div>
@endsection