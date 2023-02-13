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
      <table class="table">
        <tr>
          <th>プラン</th>
          <input type="hidden" name="plan_id" value="1">
          <td>お墓のお掃除・お参り代行</td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            <input type="date" name="date_begin" id="" class="input-group-text">〜<input type="date" name="date_end" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>該当のお墓の都道府県</th>
          <td>
            <select name="area_id" id="" class="input-group-text">
              @foreach($areas as $area)
              <option value="{{$area->id}}">{{$area->name}}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
          <th>お墓の市町村(可能ならば番地まで)
          </th>
          <td>
            <input type="text" name="address" class="input-group-text">
          </td>
        </tr>
        <tr>
          <th>ご依頼概要(複数選択可能)</th>
          <td>
            @foreach($summaries as $summary)
            <input type="checkbox" name="ohakamairi_sum_id[]" value="{{$summary->id}}" multiple>{{$summary->name}}<br>
            @endforeach
          </td>
        </tr>
        <tr>
          <th>お供え物・墓花・お線香マナーなどのご要望があれば</th>
          <td>
            <textarea name="offering" cols="30" rows="3" class="input-group-text"></textarea><br>
            <input type="file" name="img_url" accept="image/png, image/jpeg">
          </td>
        </tr>
        <tr>
          <th>お墓のお掃除に関して要望があれば</th>
          <td>
            <textarea name="cleaning" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
        </tr>
        <tr>
          <th>費用（お支払い額）<br>
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            <input type="number" name="price" class="input-group-text">円（税別）
          </td>
        </tr>
      </table>
      <button class="btn btn-primary">確認画面に進む</button>
    </form>
  </div>
</body>