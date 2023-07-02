@extends('layouts.admin')
@section('content')
<div class="container">
  <h4>【管理画面】プロフィール編集</h4>
  <form action="{{route('admin.user.update')}}" method="post">
    @csrf
    <table class="table">
      <img src="{{ asset($item->img_url) }}" alt="プロフィール画像">
      <tr>
        <th>ユーザーID</th>
        <input type="hidden" name="user_id" value="{{$item->id}}">
        <td>{{ $item->id }}</td>
      </tr>
      <tr>
        <th>ニックネーム</th>
        <td>
          <input type="text" name="nickname" value="{{$item->nickname}}">
        </td>
      </tr>
      <tr>
        <th>氏名</th>
        <td>
          <input type="text" name="name" value="{{ $item->name }}">
        </td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td>
          <input type="email" name="email" value="{{ $item->email }}">
        </td>
      </tr>
      <tr>
        <th>屋号</th>
        <td>
          <input type="text" name="trade_name" value="{{ $item->trade_name }}">
        </td>
      </tr>
      <tr>
        <th>性別</th>
        <td>
          <div class="form-check">
            <input type="radio" name="gender" id="men" value="1" @if($item->gender ==1)checked @endif>
            <label for="men" class="form-check-label">男性</label>
          </div>
          <div class="form-check">
            <input type="radio" name="gender" id="women" value="2" @if($item->gender ==2)checked @endif>
            <label for="women" class="form-check-label">女性</label>
          </div>
          <div class="form-check">
            <input type="radio" name="gender" id="others" value="3" @if($item->gender ==3)checked @endif>
            <label for="others" class="form-check-label">その他</label>
          </div>
        </td>
      </tr>
      <tr>
        <th>誕生日</th>
        <td>
          <input type="date" name="birthday" value="{{$item->birthday}}">
        </td>
      </tr>
      <tr>
        <th>住んでいる地域</th>
        <td>
          <select name="living_area">
            @foreach($areas as $area)
            <option value="{{$area->id}}" @if($item->living_area == $area->id)selected @endif>{{$area->name}}</option>
            @endforeach
          </select>
        </td>
      </tr>
      <tr>
        <th>自己紹介</th>
        <td>
          <textarea name="message" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。">{{$item->message}}</textarea>
        </td>
      </tr>
    </table>
    <div class="text-center">
      <button class="btn btn-primary">更新する</button>
    </div>
  </form>
  <div class="text-center">
    <button class="btn btn-outline-primary" onClick="location.href='{{route('admin.user.detail',['user_id'=>$item->id])}}'">戻る</button>
  </div>
</div>
@endsection