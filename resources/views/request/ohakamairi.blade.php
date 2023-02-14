@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    @component('components.back-button')
    @endcomponent
    <form action="{{ route('request.session.save') }}" method="post" class="form-control" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" value="{{ $user_id }}">
      <div class="table-responsive">
        <table class="table">
          <tbody>
            <tr>
              <th scope="row">プラン</th>
              <td>
                <input type="hidden" name="plan_id" value="1">
                <p class="my-2">お墓のお掃除・お参り代行</p>
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
              <th scope="row">該当のお墓の都道府県</th>
              <td>
                <select name="area_id" class="form-select">
                  @foreach($areas as $area)
                  <option value="{{ $area->id }}">{{ $area->name }}</option>
                  @endforeach
                </select>
              </td>
            </tr>
            <tr>
              <th scope="row">お墓の市町村(可能ならば番地まで)</th>
              <td>
                <input type="text" name="address" class="form-control">
              </td>
            </tr>
            <tr>
              <th scope="row">ご依頼概要(複数選択可能)</th>
              <td>
                @foreach($summaries as $summary)
                <div class="form-check">
                  <input type="checkbox" name="ohakamairi_sum_id[]" value="{{ $summary->id }}" class="form-check-input">
                  <label class="form-check-label">{{ $summary->name }}</label>
                </div>
                @endforeach
              </td>
            </tr>
            <tr>
              <th scope="row">お供え物・墓花・お線香マナーなどのご要望があれば</th>
              <td>
                <textarea name="offering" class="form-control" rows="3"></textarea>
                <div class="my-2">
                  <input type="file" name="img_url" class="form-control-file" accept="image/png, image/jpeg">
                </div>
              </td>
            </tr>
            <tr>
              <th scope="row">お墓のお掃除に関して要望があれば</th>
              <td>
                <textarea name="cleaning" class="form-control" rows="3"></textarea>
              </td>
            </tr>
            <tr>
              <th scope="row">その他</th>
              <td>
                <textarea name="free" class="form-control" rows="3"></textarea>
              </td>
            </tr>
            <tr>
              <th scope="row">
                費用（お支払い額）<br>
                <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
              </th>
              <td>
                <div class="input-group">
                  <input type="number" class="form-control" name="price" required>
                  <div class="input-group-append">
                    <span class="input-group-text">円（税別）</span>
                  </div>
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