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
          <input type="hidden" name="plan_id" value="3">
          <td>参拝代行</td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            <input type="date" name="date_begin" id="" class="input-group-text">〜<input type="date" name="date_end" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>参拝先の都道府県</th>
          <td>
            <select name="area_id" id="" class="input-group-text">
              @foreach($areas as $area)
              <option value="{{$area->id}}">{{$area->name}}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <th>参拝先の住所</th>
          <td>
            <input type="text" name="address" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>参拝内容(祈願内容)</th>
          <td>
            <textarea name="praying" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
        </tr>
        <tr>
          <th>御朱印の有無</th>
          <td>
            <div class="form-check">
              <input type="radio" name="goshuin" id="0" value="0" checked>
              <label class="form-check-label" for="0">御朱印不要
            </div>
            <div class="form-check">
              <input type="radio" name="goshuin" id="1" value="1">
              <label for="1" class="form-check-label">御朱印の画像添付を希望</label>
            </div>
            <div class="form-check">
              <input type="radio" name="goshuin" id="2" value="2">
              <label for="2" class="form-check-label">御朱印の郵送を希望</label>
            </div>
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
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