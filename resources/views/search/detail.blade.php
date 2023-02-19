@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    @component('components.back-button')
    @endcomponent
    <h5>依頼詳細内容</h5>
    @if($item->plan_id == 1)
    <div class="form-control">
      <div class="mb-3">
        <label for="plan_id" class="fw-bolder">プラン</label>
        <select name="plan_id" id="plan_id" class="form-control fw-bolder" readonly>
          <option value="1">お墓のお掃除・お参り代行</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="date_range" class="fw-bolder">日程</label>
        <div class="input-group">
          <input type="date" name="date_begin" id="date_begin" class="form-control" value="{{ $item->date_begin }}" readonly>
          <span class="input-group-text">〜</span>
          <input type="date" name="date_end" id="date_end" class="form-control" value="{{ $item->date_end }}" readonly>
        </div>
      </div>

      <div class="mb-3">
        <label for="area_id" class="fw-bolder">該当のお墓の都道府県</label>
        <input name="area_id" id="area_id" value="{{ $item->area_id }}" hidden>
        <input type="text" class="form-control" readonly value="{{ $item->area_name }}">
      </div>

      <div class="mb-3">
        <label for="address" class="fw-bolder">お墓の市町村(可能ならば番地まで)</label>
        <input type="text" name="address" id="address" class="form-control" value="{{ $item->address }}" readonly>
      </div>

      <div class="mb-3">
        <label class="fw-bolder d-block mb-2">ご依頼概要(複数選択可能)</label>
        @foreach($ohakamairi_summaries as $ohakamairi_summary)
        ・{{$ohakamairi_summary->name}}<br>
        @endforeach
      </div>

      <div class="mb-3">
        <label class="fw-bolder d-block mb-2">お供え物・墓花・お線香マナーなどのご要望があれば</label>
        <textarea name="offering" cols="30" rows="3" class="form-control" readonly>{{$item->offering}}</textarea>
      </div>

      <div class="mb-3">
        <label class="fw-bolder d-block mb-2">お墓のお掃除に関して要望があれば</label>

        <textarea name="cleaning" cols="30" rows="3" class="form-control" readonly>{{$item->cleaning}}</textarea>
      </div>
      <div class="mb-3">
        <label class="fw-bolder mb-2">画像添付(任意)</label>

        <p><a href="{{ asset($item->img_url) }}">添付画像</a></p>
      </div>

      <div class="mb-3">
        <label for="fress" class="fw-bolder">その他
        </label>
        <div class="input-group">
          <textarea name="free" id="" cols="30" rows="3" class="form-control" readonly>{{$item->free}}
          </textarea>
        </div>

        <div class="mb-3">
          <label class="fw-bolder d-block mb-2">費用（お支払い額）<br>
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
          </label>
          <div class="input-group">
            <input type="number" name="price" class="form-control" value="{{$item->price}}" readonly>
            <div class="input-group-append">
              <span class="input-group-text">円（税別）</span>
            </div>
          </div>
        </div>
      </div>
      @elseif($item->plan_id == 2)
      <div class="form-control">
        <div class="mb-3">
          <label for="plan_id" class="fw-bolder">プラン</label>
          <select name="plan_id" class="form-control" readonly>
            <option value="2">お守り・お札・御朱印購入代行</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="date_range" class="fw-bolder">日程</label>
          <div class="input-group">
            <input type="date" name="date_begin" id="date_begin" class="form-control" value="{{ $item->date_begin }}" readonly>
            <span class="input-group-text">〜</span>
            <input type="date" name="date_end" id="date_end" class="form-control" value="{{ $item->date_end }}" readonly>
          </div>
        </div>
        <div class="mb-3">
          <label for="area_id" class="fw-bolder">該当の神社仏閣の都道府県</label>
          <input name="area_id" id="area_id" value="{{ $item->area_id }}" hidden>
          <input type="text" class="form-control" readonly value="{{ $item->area_name }}">
        </div>

        <div class="mb-3">
          <label for="address" class="fw-bolder">神社仏閣の市町村(可能ならば番地まで)</label>
          <input type="text" name="address" id="address" class="form-control" value="{{ $item->address }}" readonly>
        </div>

        <div class="mb-3">
          <lable for="amulet" class="fw-bolder">購入したいもの(正式名称、金額、参考URL、画像)
            </label>
            <div class="input-group">
              <textarea name="amulet" cols="30" rows="3" class="form-control" readonly>{{$item->amulet}}</textarea>
            </div>
        </div>
        <div class="mb-3">
          <label class="fw-bolder mb-2">画像添付(任意)</label>

          <p><a href="{{ asset($item->img_url) }}">添付画像</a></p>
        </div>

        <div class="mb-3">
          <label for="fress" class="fw-bolder">その他
          </label>
          <div class="input-group">
            <textarea name="free" id="" cols="30" rows="3" class="form-control" readonly>{{ $item->free }}
            </textarea>
          </div>
        </div>

        <div class="mb-3">
          <label class="fw-bolder d-block mb-2">費用（お支払い額）<br>
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
          </label>
          <div class="input-group">
            <input type="number" name="price" class="form-control" value="{{ $item->price }}" readonly>
            <div class="input-group-append">
              <span class="input-group-text">円（税別）</span>
            </div>
          </div>
        </div>
      </div>
      @elseif($item->plan_id == 3)
      <div class="form-control">
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
            <input type="date" name="date_begin" id="date_begin" class="form-control" value="{{ $item->date_begin }}" readonly>
            <span class="input-group-text">〜</span>
            <input type="date" name="date_end" id="date_end" class="form-control" value="{{ $item->date_end }}" readonly>
          </div>
        </div>

        <div class="mb-3">
          <label for="area_id" class="fw-bolder">該当の神社仏閣の都道府県</label>
          <input type="text" class="form-control" readonly value="{{ $item->area_name }}">
        </div>

        <div class="mb-3">
          <label for="address" class="fw-bolder">神社仏閣の市町村(可能ならば番地まで)</label>
          <input type="text" name="address" id="address" class="form-control" value="{{ $item->address }}" readonly>
        </div>

        <div class="mb-3">
          <label for="praying" class="fw-bolder">ご希望の参拝、祈祷内容
          </label>
          <div class="input-group">
            <textarea name="praying" cols="30" rows="3" class="form-control" readonly>{{ $item->praying }}
            </textarea>
          </div>

          <div class="mb-3">
            <label for="sanpai_sum" class="fw-bolder">ご依頼概要(複数選択可能)</label>
            <div class="input-group">
              @foreach($sanpai_summaries as $sanpai_summary)
              ・{{ $sanpai_summary->name }}<br>
              @endforeach
            </div>
          </div>

          <div class="mb-3">
            <label for="goshuin" class="fw-bolder">御朱印の有無</label>
            <div class="input-group">
              {{ $item->goshuin }}
            </div>
          </div>

          <div class="mb-3">
            <label for="goshuin_content" class="fw-bolder">御朱印要の場合詳細を記入<br><span>郵送を希望の際、住所など個人情報は記載しないでください<br>（個別チャットでやり取り）</span></label>
            <div class="input-group">
              <textarea name="goshuin_content" class="form-control" readonly>{{ $item->goshuin_content }}
              </textarea>
            </div>
          </div>
          <div class="mb-3">
            <label class="fw-bolder mb-2">画像添付(任意)</label>

            <p><a href="{{ asset($item->img_url) }}">添付画像</a></p>
          </div>

          <div class="mb-3">
            <label for="free" class="fw-bolder">その他
            </label>
            <div class="input-group">
              <textarea name="free" id="" cols="30" rows="3" class="form-control" readonly>{{ $item->free }}
              </textarea>
            </div>
          </div>

          <div class="mb-3">
            <label class="fw-bolder d-block mb-2" for="price">費用（お支払い額）<br>
              <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
            </label>
            <div class="input-group">
              <input type="number" name="price" class="form-control" value="{{ $item->price }}" readonly>
              <div class="input-group-append">
                <span class="input-group-text">円（税別）</span>
              </div>
            </div>
          </div>
        </div>
        @elseif($item->plan_id == 4)
        <div class="form-control">
          <div class="mb-3">
            <label for="plan_id" class="fw-bolder">プラン</label>
            <select name="plan_id" class="form-control" readonly>
              <option value="4">その他お参り代行</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="fress" class="fw-bolder">ご依頼内容(詳細)
            </label>
            <div class="input-group">
              <textarea name="free" id="" cols="30" rows="3" class="form-control" readonly>{{ $item->free }}
              </textarea>
            </div>
          </div>
          <div class="mb-3">
            <label for="date_range" class="fw-bolder">日程</label>
            <div class="input-group">
              <input type="date" name="date_begin" id="date_begin" class="form-control" value="{{ $item->date_begin }}" readonly>
              <span class="input-group-text">〜</span>
              <input type="date" name="date_end" id="date_end" class="form-control" value="{{ $item->date_end }}" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label for="area_id" class="fw-bolder">依頼に該当する都道府県</label>
            <input name="area_id" id="area_id" value="{{ $item->area_id }}" hidden>
            <input type="text" class="form-control" readonly value="{{ $item->area_name }}">
          </div>
          <div class="mb-3">
            <label for="address" class="fw-bolder">依頼に該当する住所</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $item->address }}" readonly>
          </div>
          <div class="mb-3">
            <label for="spot" class="fw-bolder">依頼に該当する施設名称</label>
            <div class="input-group">
              <input type="text" name="spot" class="form-control" value="{{$item->spot}}" readonly>
            </div>
          </div>
          <div class="mb-3">
            <label class="fw-bolder mb-2">画像添付(任意)</label>
            <p><a href="{{ asset($item->img_url) }}">添付画像</a></p>
          </div>
          <div class="mb-3">
            <label class="fw-bolder d-block mb-2">費用（お支払い額）<br>
              <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ、事務局手数料等の全ての購入代金や経費を含む金額</span>
            </label>
            <div class="input-group">
              <input type="number" name="price" class="form-control" value="{{ $item->price }}" readonly>
              <div class="input-group-append">
                <span class="input-group-text">円（税別）</span>
              </div>
            </div>
          </div>
        </div>
        @endif

      <div class="text-center my-3">  
        @if($item->request_user_id == $user_id)
        <button class="btn btn-outline-secondary col-3" onclick="location.href='{{route('mypage.myrequest.index')}}'">内容編集</button>
        @elseif($apply_flag == 1)

        <button type="button" class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#collapseApply">応募者に質問や応募のメッセージを送る。</button>

        <div class="collapse" id="collapseApply">
          <form action="{{route('search.apply')}}" method="post">
            @csrf
            <input type="hidden" name="request_id" value="{{$item->id}}">
            <input type="hidden" name="host_user" value="{{ $item->request_user_id }}">
            <textarea name="first_chat" id="first_chat" cols="60" rows="10" class="text-start m-3">※必ず記載してください。
特に依頼者への質問がない場合は、「記載のご依頼通りに対応します」
と記載し下の応募するボタンを押してください。
            </textarea>
            <button type="submit" class="btn btn-primary col-3">送信する</button>
          </form>
        </div>
        @else
        <button disabled class="btn btn-outline-primary col-3">応募済みです</button>
        @endif

        <button onclick="history.back()" type="button" name="back" class="btn btn-outline-primary col-3">戻る</button>
      </div>
</body>