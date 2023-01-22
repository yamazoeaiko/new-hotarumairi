@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>
  <div class="container">
    <table class="table">
      <div>
        @if($item->img_url == null)
        <p>イメージ画像なし</p>
        @else
        <img src="{{ asset($item->img_url) }}" alt="" class="profile-img">
        @endif
      </div>
      <form method="post" action="{{route('myprofile.image.update')}}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <button>画像変更</button>
      </form>
      <form action="{{route('myprofile.update')}}" method="post">
        @csrf
        <table class="table">
          <tr>
            <th>ニックネーム</th>
            <td>
              <input type="text" name="nickname" value="{{$item->nickname}}">
            </td>
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
              <textarea name="message" cols="30" rows="3">{{$item->message}}</textarea>
            </td>
        </table>
        <button name="update" class="btn btn-primary">更新する</button>
      </form>
      <button type="button" onClick="history.back();" class="btn">戻る</button>
    </table>
  </div>
</body>