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
    <form method="post" action="{{route('myprofile.update')}}" enctype="multipart/form-data">
      @csrf
      <input type="file" accept=".png, .jpeg, .jpg" name="image">
      <table class="table">
        <tr>
          <th>ニックネーム</th>
          <td>
            <input type="text" name="nickname" value="{{$item->nickname}}">
          </td>
        </tr>
        <!--
        <tr>
          <th>TwitterアカウントURL</th>
          <div class="input-group mb-3">
            <span class="input-group-text">https://twitter.com/</span>
            <input type="text" class="form-control" name="twitter_url" value="{{str_replace('https://twitter.com/', '', $item->twitter_url)}}" placeholder="ユーザー名">
          </div>
        </tr>
        <tr>
          <th>InstagramアカウントURL</th>
          <div class="input-group mb-3">
            <span class="input-group-text">https://www.instagram.com/</span>
            <input type="text" class="form-control" name="instagram_url" value="{{str_replace('https://www.instagram.com/', '', $item->instagram_url)}}" placeholder="ユーザー名">
          </div>
        </tr>
        <tr>
          <th>その他SNSアカウントURL</th>
          <div class="input-group mb-3">
            <span class="input-group-text">https://</span>
            <input type="text" class="form-control" name="others_sns_url" value="{{str_replace('https://', '', $item->others_sns_url)}}">
          </div>
        </tr>
            -->
        <tr>
          <th>屋号</th>
          <td><input type="text" name="trade_name" value="{{ $item->trade_name }}"></td>
        </tr>
        <tr>
          <th>誕生日</th>
          <td>
            <input type="date" name="birthday" value="{{$item->birthday}}">
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
            <textarea name="message" oninput="resizeTextarea(this)" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。">{{$item->message}}</textarea>
          </td>
      </table>
      <button name="update" class="btn btn-primary">更新する</button>
    </form>
    <button type="button" onClick="history.back();" class="btn">戻る</button>
  </table>
</div>
@endsection

<script>
  function resizeTextarea(textarea) {
    textarea.style.height = '70px';
    textarea.style.height = textarea.scrollHeight + 'px';
  }

  const textarea = document.querySelector('textarea');
  textarea.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      const startPos = textarea.selectionStart;
      const endPos = textarea.selectionEnd;
      textarea.value = textarea.value.substring(0, startPos) + '\n' + textarea.value.substring(endPos, textarea.value.length);
      resizeTextarea(textarea);
    }
  });
</script>