@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>
  <div class="container">
    <form action="{{route('request.session.save')}}" method="post" class="form-control" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" id="" value="{{$user_id}}">
      <table class="table">
        <tr>
          <th>プラン</th>
          <input type="hidden" name="plan_id" value="2">
          <td>お守、お札、御朱印購入代行</td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            <input type="date" name="date_begin" id="" class="input-group-text">〜<input type="date" name="date_end" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>該当の神社仏閣の都道府県</th>
          <td>
            <select name="area_id" id="" class="input-group-text">
              @foreach($areas as $area)
              <option value="{{$area->id}}">{{$area->name}}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <th>神社仏閣市町村(可能ならば番地まで)</th>
          <td>
            <input type="text" name="address" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>購入したいもの(正式名称、金額、参考URL、画像)</th>
          <td>
            <span>次の確認ページで画像を添付することができます。</span>
            <textarea name="amulet" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
        </tr>
        <tr>
          <th>費用<br>
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            <input type="number" name="price" class="input-group-text">
          </td>
        </tr>
      </table>
      <button class="btn btn-primary">確認画面に進む</button>
    </form>
  </div>
</body>