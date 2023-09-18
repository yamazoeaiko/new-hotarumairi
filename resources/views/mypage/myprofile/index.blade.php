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
      <th>アカウント名</th>
      <td>
        {{$item->nickname}}
      </td>
    </tr>
    <tr>
      <th>本人確認証明状況</th>
      <td>
        @if($item->identification_agreement == 'approved')
        <i class="bi bi-check-circle-fill"></i>本人確認済み。
        @elseif($item->identification_agreement == 'unapproved')
        否認されています
        <div>
          <button type="button" class="btn btn-primary my-2" data-bs-toggle="collapse" data-bs-target="#collapseIdentification">本人確認証明する</button>
          <div class="collapse" id="collapseIdentification">
            <form action="{{route('send.identification')}}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" value="{{ $item->id}}">
              <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="identification_photo" value="identification_photo">
              <input type="hidden" name="user_id" value="{{ $item->id}}">
              <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="identification_photo_2" value="identification_photo_2">
              <button type="submit" class="btn btn-outline-primary">送信</button>
            </form>
          </div>
        </div>
        @elseif($item->identification_agreement == 'unsubmit')
        本人確認証明書が提出されていません
        <div>
          <button type="button" class="btn btn-primary my-2" data-bs-toggle="collapse" data-bs-target="#collapseIdentification">本人確認証明する</button>
          <div class="collapse" id="collapseIdentification">
            <div class="fs-7 text-danger">※免許証で裏側に記載がある場合は裏表で2枚ご提出ください</div>
            <form action="{{route('send.identification')}}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="user_id" value="{{ $item->id}}">
              <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="identification_photo" value="identification_photo">

              <input type="file" accept=".png, .jpeg, .jpg" class="form-control" name="identification_photo_2" value="identification_photo_2">
              <button type="submit" class="btn btn-outline-primary">送信</button>
            </form>
          </div>
        </div>
        @elseif($item->identification_agreement == 'pending')
        本人確認中です。しばらくお待ちください。
        @endif
      </td>
    </tr>
    <!--
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
-->
    <tr>
      <th>年齢</th>
      <td>
        @if ($item->age >= 10 && $item->age < 20) 10代 @elseif ($item->age >= 20 && $item->age < 30) 20代 @elseif ($item->age >= 30 && $item->age < 40) 30代 @elseif ($item->age >= 40 && $item->age < 50) 40代 @elseif ($item->age >= 50 && $item->age < 60) 50代 @elseif ($item->age >= 60 && $item->age < 70) 60代 @elseif ($item->age >= 70 && $item->age < 80) 70代 @elseif ($item->age >= 80 && $item->age < 90) 80代 @elseif ($item->age >= 90 && $item->age < 100) 90代 @else その他の年齢 @endif </td>
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