@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>
  <div class="container">
    <form action="{{route('request.session.save')}}" method="post" class="form-control">
      @csrf
      <input type="hidden" name="user_id" id="" value="{{$user_id}}">
      <table class="table">
        <tr>
          <th>プラン</th>
          <input type="hidden" name="plan_id" value="4">
          <td>その他お参り代行</td>
        </tr>
        <tr>
          <th>依頼内容(詳細に記入)
            <span><br>※お参りと称したユニークな代行依頼をカスタマイズ可能です。
            </span>
          </th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            <input type="date" name="date_begin" id="" class="input-group-text">〜<input type="date" name="date_end" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>都道府県のエリア指定（任意）</th>
          <td>
            <select name="area_id" id="" class="input-group-text">
              @foreach($areas as $area)
              <option value="{{$area->id}}">{{$area->name}}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <th>住所の指定（任意）</th>
          <td>
            <input type="text" name="address" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>施設の名称など（任意）</th>
          <td>
            <input type="text" name="spot" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>お支払い金額</th>
          <td>
            <input type="number" name="price" class="input-group-text">
          </td>
        </tr>
      </table>
      <button class="btn btn-primary">確認画面に進む</button>
    </form>
  </div>
</body>