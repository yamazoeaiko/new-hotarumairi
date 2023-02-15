@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <form action="{{route('request.done')}}" method="post" class="form-control">
      @csrf
      <input type="hidden" name="user_id" id="" value="{{$params->user_id}}">
      <div class="mb-3">
        <label for="plan_id" class="fw-bolder">プラン
        </label>
        <select name="plan_id" readonly class="form-control">
          <option value="3">神社仏閣参拝・祈祷</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="date_range" class="fw-bolder">日程</label>
        <div class="input-group">
          <input type="date" name="date_begin" id="date_begin" class="form-control" value="{{ $params->date_begin }}" readonly>
          <span class="input-group-text">〜</span>
          <input type="date" name="date_end" id="date_end" class="form-control" value="{{ $params->date_end }}" readonly>
        </div>
      </div>

      <div class="mb-3">
        <label for="area_id" class="fw-bolder">該当の神社仏閣の都道府県</label>
        <input name="area_id" id="area_id" value="{{ $params->area_id }}" hidden>
        <input type="text" class="form-control" readonly value="{{ $params->area_name }}">
      </div>

      <div class="mb-3">
        <label for="address" class="fw-bolder">神社仏閣の市町村(可能ならば番地まで)</label>
        <input type="text" name="address" id="address" class="form-control" value="{{ $params->address }}" readonly>
      </div>

      <div class="mb-3">
        <label for="praying" class="fw-bolder">ご希望の参拝、祈祷内容
        </label>
        <div class="input-group">
          <textarea name="praying" cols="30" rows="3" class="form-control" readonly>{{$params->praying}}
          </textarea>
        </div>

        <div class="mb-3">
          <label for="sanpai_sum" class="fw-bolder">ご依頼概要(複数選択可能)</label>
          <div class="input-group">
            <input type="hidden" name="sanpai_sum" value="{{ $sum }}">
            @foreach($items as $item)
            ・{{$item->sanpai_sum_name}}<br>
            @endforeach
          </div>
        </div>

        <div class="mb-3">
          <label for="goshuin" class="fw-bolder">御朱印の有無</label>
          <div class="input-group">
            <input type="hidden" name="goshuin" value="{{$params->goshuin}}">
            @if($params->goshuin == 0)
            <input class="form-control" value="不要" readonly>
            @else
            <input class="form-control" value="要" readonly>
            @endif
          </div>

          <div class="mb-3">
            <label for="goshuin_content" class="fw-bolder">御朱印要の場合詳細を記入<br><span>郵送を希望の際、住所など個人情報は記載しないでください<br>（個別チャットでやり取り）</span></label>
            <div class="input-group">
              <textarea name="goshuin_content" class="form-control" readonly>{{$params->goshuin_content}}
              </textarea>
            </div>
          </div>
          <div class="mb-3">
            <label class="fw-bolder mb-2">画像添付(任意)</label>
            <input type="hidden" name="img_url" value="{{$path}}">


            <p><a href="{{ asset($path) }}">{{ $fileName }}</a></p>
          </div>

          <div class="mb-3">
            <label for="fress" class="fw-bolder">その他
            </label>
            <div class="input-group">
              <textarea name="free" id="" cols="30" rows="3" class="form-control" readonly>{{$params->free}}
              </textarea>
            </div>
          </div>

          <div class="mb-3">
            <label class="fw-bolder d-block mb-2">費用（お支払い額）<br>
              <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
            </label>
            <div class="input-group">
              <input type="number" name="price" class="form-control" value="{{$params->price}}" readonly>
              <div class="input-group-append">
                <span class="input-group-text">円（税別）</span>
              </div>
            </div>
          </div>

          <div class="text-center mt-3">
            <button name="submit" class="btn btn-primary">この内容で募集開始する</button>
            <button type="button" onClick="history.back();" class="btn btn-outline-secondary">修正する</button>
          </div>
    </form>
  </div>
</body>