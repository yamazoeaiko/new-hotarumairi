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
          {{$item->age}}歳
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

    @if($exist == true)
    <button disable class="btn btn-outline-secondary">承認済み</button>
    <button class="btn btn-primary" onclick="location.href='{{route('chat.room',['apply_id'=>$apply_id, 'your_id'=>$item->user_id])}}'">チャットする</button>
    @else
    <button class="btn btn-primary" onClick="location.href='{{route('myrequest.member.approval',[
              'apply_id'=>$apply_id,
              'request_id' => $request_id,
              'user_id'=>$item->user_id])}}'">承認する</button>
    <button class="btn btn-danger" onClick="location.href='{{route('myrequest.member.reject', [
                'apply_id'=>$apply_id,
                'request_id' => $request_id,
              'user_id'=>$item->user_id])}}'">お断りする
    </button>
    @endif
  </div>
</body>