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
      <div class="mb-3">
        <label for="plan_id" class="fw-bolder">プラン</label>
        <select name="plan_id" id="plan_id" class="form-control fw-bolder">
          <option value="1">お墓のお掃除・お参り代行</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="date_range" class="fw-bolder">日程</label>
        <div class="input-group">
          <input type="date" name="date_begin" id="date_begin" class="form-control">
          <span class="input-group-text">〜</span>
          <input type="date" name="date_end" id="date_end" class="form-control">
        </div>
      </div>

      <div class="mb-3">
        <label for="area_id" class="fw-bolder">該当のお墓の都道府県</label>
        <select name="area_id" id="area_id" class="form-control">
          @foreach($areas as $area)
          <option value="{{ $area->id }}">{{ $area->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-3">
        <label for="address" class="fw-bolder">お墓の市町村(可能ならば番地まで)</label>
        <input type="text" name="address" id="address" class="form-control">
      </div>

      <div class="mb-3">
        <label for="ohakamairi_sum_id" class="fw-bolder">ご依頼概要(複数選択可能)</label>
        @foreach($summaries as $summary)
        <div class="form-check">
          <input type="checkbox" name="ohakamairi_sum_id[]" value="{{ $summary->id }}" class="form-check-input">
          <label class="form-check-label">{{ $summary->name }}</label>
        </div>
        @endforeach
      </div>

      <div class="mb-3">
        <label for="offering" class="fw-bolder">お供え物・墓花・お線香マナーなどのご要望があれば</label>
        <textarea name="offering" id="offering" class="form-control" rows="3"></textarea>
        <div class="my-2">
          <input type="file" name="img_url" class="form-control" accept="image/png, image/jpeg">
        </div>
      </div>

      <div class="mb-3">
        <label for="cleaning" class="fw-bolder">お墓のお掃除に関して要望があれば</label>
        <textarea name="cleaning" id="cleaning" class="form-control" rows="3"></textarea>
      </div>

      <div class="mb-3">
        <label for="free" class="fw-bolder">その他</label>
        <textarea name="free" id="free" class="form-control" rows="3"></textarea>
      </div>

      <div class="mb-3">
        <label for="price" class="fw-bolder">費用（お支払い額）</label>
        <span>交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
        <div class="input-group">
          <input type="number" class="form-control" name="price" id="price" required>
          <div class="input-group-append">
            <span class="input-group-text">円（税別）</span>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary mt-3">確認画面に進む</button>
        </div>
      </div>
    </form>
  </div>
</body>