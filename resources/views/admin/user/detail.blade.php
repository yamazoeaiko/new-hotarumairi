@extends('layouts.admin')
@section('content')
<div class="container">
  <h4>【管理画面】プロフィール詳細</h4>
  <table class="table">
    <img src="{{ asset($item->img_url) }}" alt="プロフィール画像">
    <tr>
      <th>ユーザーID</th>
      <td>{{ $item->id }}</td>
    </tr>
    <tr>
      <th>ニックネーム</th>
      <td>{{ $item->nickname }}</td>
    </tr>
    <tr>
      <th>氏名</th>
      <td>{{ $item->name }}</td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td>{{ $item->email }}</td>
    </tr>
    <tr>
      <th>屋号</th>
      <td>{{ $item->trade_name }}</td>
    </tr>
    <tr>
      <th>性別</th>
      <td>{{$item->gender_name}}</td>
    </tr>
    <tr>
      <th>誕生日</th>
      <td>{{$item->birthday}}</td>
    </tr>
    <tr>
      <th>住まいの都道府県</th>
      <td>{{$item->living_area}}</td>
    </tr>
    <tr>
      <th>自己紹介</th>
      <td>{{ $item->message }}</td>
    </tr>
  </table>
  <div class="text-center mt-3">
    <button class="btn btn-primary" onClick="location.href='{{route('admin.user.edit',['user_id'=>$item->id])}}'">編集</button>
    <button class="btn btn-outline-primary" onClick="location.href='{{route('admin.user.list')}}'">戻る</button>
  </div>
</div>
@endsection