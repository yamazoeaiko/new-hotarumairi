@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    @component('components.back-button')
    @endcomponent
    <form action="{{route('request.session.save')}}" method="post" class="form-control">
      @csrf
      <input type="hidden" name="user_id" id="" value="{{$user_id}}">
      <div class="table-responsive">
        <table class="table">
          <tr>
            <th scope="row">プラン</th>
            <input type="hidden" name="plan_id" value="4">
            <td>その他お参り代行</td>
          </tr>
          <tr>
            <th scope="row">依頼内容(詳細に記入)
              <span><br>※お参りと称したユニークな代行依頼をカスタマイズ可能です。
              </span>
            </th>
            <td>
              <textarea name="free" id="" cols="30" rows="3" class="form-control"></textarea>
            </td>
          </tr>
          <tr>
            <th scope="row">日程</th>
            <td>
              <div class="input-group">
                <input type="date" name="date_begin" class="form-control">
                <span class="input-group-text">〜</span>
                <input type="date" name="date_end" class="form-control">
              </div>
            </td>

          </tr>
          <tr>
            <th scope="row">都道府県のエリア指定（任意）</th>
            <td>
              <select name="area_id" class="form-select">
                @foreach($areas as $area)
                <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row">住所の指定（任意）</th>
            <td>
              <input type="text" name="address" class="form-control">
            </td>
          </tr>
          <tr>
            <th scope="row">施設の名称など（任意）</th>
            <td>
              <input type="text" name="spot" class="form-control">
            </td>
          </tr>
          <tr>
            <th scope="row">画像添付(任意)</th>
            <td>
              <input type="file" name="img_url" accept="image/png, image/jpeg" class="form-control-file">
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
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-primary mt-3">確認画面に進む</button>
      </div>
    </form>
  </div>
</body>