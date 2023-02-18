@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    @component('components.back-button')
    @endcomponent
    <h5>依頼内容</h5>
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
        <div class="row my-1">
          <button class="col-6 fs-6 btn btn-primary" onclick=location.href="{{route('mypage.myrequest.member_list',['request_id'=>$item->id])}}">{{$item->apply_count}}名からの応募があります<br><span>@if($item->confirm_count==true)承認済みです。@elseまだ承認した方はいません@endif</span></button>
        </div>
        <div class="row">
          <button type="button" class="col-3 btn btn-outline-secondary" onClick="history.back();">戻る</button>
          @if($item->plan_id == 1)
          <button type="button" class="col-3 btn btn-outline-primary offset-1" onclick="location.href='{{route('mypage.myrequest.edit.ohakamairi',['request_id' => $item->id])}}'">内容修正</button>
          @elseif($item->plan_id == 2)
          <button type="button" class="col-3 btn btn-outline-primary offset-1" onclick="location.href='{{route('mypage.myrequest.edit.omamori',['request_id' => $item->id])}}'">内容修正</button>
          @elseif($item->plan_id == 3)
          <button type="button" class="col-3 btn btn-outline-primary offset-1" onclick="location.href='{{route('mypage.myrequest.edit.sanpai',['request_id' => $item->id])}}'">内容修正</button>
          @elseif($item->plan_id == 4)
          <button type="button" class="col-3 btn btn-outline-primary offset-1" onclick="location.href='{{route('mypage.myrequest.edit.others',['request_id' => $item->id])}}'">内容修正</button>
          @endif

          <button type="button" class="btn btn-danger col-3 offset-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            依頼削除
          </button>
          <!-- Modal -->
          <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">削除前確認</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  依頼を削除して宜しいですか？削除した場合は復元できません。
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">戻る</button>

                  <button type="button" class="btn btn-danger" onclick="location.href='{{route('mypage.myrequest.destroy',['request_id' => $item->id])}}'">削除する</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>