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
          <th scope="row">プラン</th>
          <input type="hidden" name="plan_id" value="3">
          <td>神社仏閣参拝、祈祷代行</td>
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
          <th scope="row">ご希望の参拝、祈祷内容</th>
          <td>
            <textarea name="praying" cols="30" rows="3" class="form-control"></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">ご依頼概要(複数選択可能)</th>
          <td>
            @foreach($summaries as $summary)
            <div class="form-check">
              <input type="checkbox" name="sanpai_sum_id[]" value="{{$summary->id}}" class="form-check-input" multiple>
              <label class="form-check-label">{{$summary->name}}</label>
            </div>
            @endforeach
          </td>
        </tr>
        <tr>
          <th scope="row">御朱印の有無</th>
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
              <textarea name="goshuin_content" id="" cols="30" rows="3" class="form-control"></textarea>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">画像添付(任意)</th>
          <td>
            <div class="my-2">
              <input type="file" name="img_url" class="form-control-file" accept="image/png, image/jpeg">
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="form-control"></textarea>
          </td>
        <tr>
          <th scope="row">費用（お支払い額）<br>
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            <div class="input-group">
              <input type="number" class="form-control" name="price" required>
              <div class="input-group-append">
                <span class="input-group-text">円（税別）
                </span>
              </div>
          </td>
        </tr>
      </table>
      <div class="text-center">
        <button type="submit" class="btn btn-primary mt-3">確認画面に進む</button>
      </div>
    </form>
  </div>
</body>