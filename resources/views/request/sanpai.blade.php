@component('components.app')
@endcomponent
@component('components.header')
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
          <td>神社仏閣参拝、祈祷代行</td>
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
          <th>ご希望の参拝、祈祷内容</th>
          <td>
            <textarea name="praying" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
        </tr>
        <tr>
          <th>ご依頼概要(複数選択可能)</th>
          <td>
            @foreach($summaries as $summary)
            <input type="checkbox" name="sanpai_sum_id[]" value="{{$summary->id}}" multiple>{{$summary->name}}<br>
            @endforeach
          </td>
        </tr>
        <tr>
          <th>御朱印の有無</th>
          <td>
            <div class="form-check">
              <input type="radio" name="goshuin" id="0" value="0" checked>
              <label class="form-check-label" for="0">不要
            </div>
            <div class="form-check">
              <input type="radio" name="goshuin" id="1" value="1" data-bs-toggle="collapse" data-bs-target="#collapseGoshuin">
              <label for="1" class="form-check-label">要</label>
            </div>
            <div class="collapse" id="collapseGoshuin">
              <span>御朱印の詳細を記入<br>御朱印の名称、郵送希望・画像送付希望など<br>住所など個人情報は記載しないでください（個別チャットでやり取り</span>
              <textarea name="goshuin_content" id="" cols="30" rows="4"></textarea>
            </div>
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="input-group-text"></textarea>
          </td>
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