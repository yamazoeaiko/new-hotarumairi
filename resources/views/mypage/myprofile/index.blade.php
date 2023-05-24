@extends('layouts.app')

@section('content')
<div class="container">
  <table class="table">
    <div>
      @if($item->img_url == null)
      <p>イメージ画像なし</p>
      @else
      <img src="{{ asset($item->img_url) }}" alt="" class="profile-img">
      @endif
    </div>
    <tr>
      <th>ニックネーム</th>
      <td>
        {{$item->nickname}}
      </td>
    </tr>
    <tr>
      <th>TwitterアカウントURL</th>
      <td>
        <a href="{{$item->twitter_url}}" target="_blank">{{$item->twitter_url}}</a>
      </td>
    </tr>
    <tr>
      <th>InstagramアカウントURL</th>
      <td>
        <a href="{{$item->instagram_url}}" target="_blank">{{$item->instagram_url}}</a>
      </td>
    </tr>
    <tr>
      <th>その他SNSアカウントURL</th>
      <td>
        <a href="{{$item->others_sns_url}}" target="_blank">{{$item->others_sns_url}}</a>
      </td>
    </tr>
    <tr>
      <th>屋号</th>
      <td>{{ $item->trade_name }}</td>
    </tr>
    <tr>
      <th>年齢</th>
      <td>
        {{$item->age}}歳
      </td>
    </tr>
    <tr>
      <th>性別</th>
      <td>
        {{$item->gender_name}}
      </td>
    </tr>
    <tr>
      <th>住んでいる地域</th>
      <td>
        {{$item->living_area}}
      </td>
    </tr>
    <tr>
      <th>自己紹介</th>
      <td>
        {{$item->message}}
      </td>
  </table>
  <a href="{{route('myprofile.edit')}}" class="btn btn-outline-primary">編集する</a>
</div>
@endsection