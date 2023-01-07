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
      <tr>
        <th>ニックネーム</th>
        <td>
          {{$item->nickname}}
        </td>
      </tr>
      <tr>
        <th>年齢</th>
        <td>
          {{$item->age}}
        </td>
      </tr>
      <tr>
        <th>性別</th>
        <td>
          {{$item->gender}}
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
    <button type="button" onClick="history.back();" class="btn">戻る</button>
  </div>
</body>