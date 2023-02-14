@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    @component('components.back-button')
    @endcomponent
    <form action="{{route('request.session.save')}}" method="post" class="form-control" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" id="" value="{{$user_id}}">
      <div class="table-responsive">
      <table class="table">
        <tr>
          <th scope="row">プラン</th>
          <td>お守、お札、御朱印購入代行<input type="hidden" name="plan_id" value="2"></td>
        </tr>
        <tr>
          <th scopes="row">日程</th>
          <td>
            <div class="input-group">
              <input type="date" name="date_begin" id="" class="form-control">
              <div class="input-group-text">〜</div>
              <input type="date" name="date_end" class="form-control">
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">該当の神社仏閣の都道府県</th>
          <td>
            <select name="area_id" id="" class="form-select">
              @foreach($areas as $area)
              <option value="{{$area->id}}">{{$area->name}}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <th scope="row">神社仏閣市町村(可能ならば番地まで)</th>
          <td>
            <input type="text" name="address" class="form-control">
          </td>
        </tr>
        <tr>
          <th scope="row">購入したいもの(正式名称、金額、参考URL、画像)</th>
          <td>
            <textarea name="amulet" cols="30" rows="3" class="form-control"></textarea><br>
            <input type="file" name="img_url" class="form-control-file" accept="image/png, image/jpeg">
          </td>
        </tr>
        <tr>
          <th scope="row">その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="form-control"></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">費用（お支払い額）<br>
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            <div class="input-group">
              <input type="number" name="price" class="form-control">
              <span class="input-group-text">円（税別）</span>
            </div>
          </td>
        </tr>
      </table>
      <div class="text-center">
        <button type="submit" class="btn btn-primary mt-3">確認画面に進む</button>
      </div>
      </div>  
    </form>

  </div>
</body>