@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container row">
    <div class="col-10">
      @if($item->plan_id == 1)
      <table class="table">
        <tr>
          <th>プラン</th>
          <td>お墓のお掃除・お参り代行</td>
        </tr>
        <tr>
          <th>依頼ユーザー名</th>
          <td>{{$item->user_name}}</td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            {{$item->date_begin}}〜{{$item->date_end}}
          </td>
        </tr>
        <tr>
          <th>該当のお墓の都道府県</th>
          <td>
            {{$item->area_name}}
          </td>
        </tr>
        <tr>
          <th>お墓の市町村</th>
          <td>
            {{$item->address}}
          </td>
        </tr>
        <tr>
          <th>ご依頼概要</th>
          <td>
            @foreach($d as $value)
            @if($value)
            ・{{$value}}<br>
            @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <th>お供え物・墓花・お線香マナーなどの要望</th>
          <td>
            {{$item->offering}}
          </td>
        </tr>
        <tr>
          <th>お墓のお掃除に関しての要望</th>
          <td>
            {{$item->cleaning}}
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            {{$item->free}}
          </td>
        </tr>
        <tr>
          <th>受け取り金額
            <br><span>現地までの交通費、駐車料金、墓花、御供、グッズ等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            {{$item->price}}円(税込)
          </td>
        </tr>
      </table>
      @elseif($item->plan_id == 2)
      <table class="table">
        <tr>
          <th>プラン</th>
          <td>お守、お札、御朱印購入代行</td>
        </tr>
        <tr>
          <th>依頼ユーザー名</th>
          <td>
            {{$item->user_name}}
          </td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            {{$item->date_begin}}〜{{$item->date_end}}
          </td>
        </tr>
        <tr>
          <th>該当の神社仏閣の都道府県</th>
          <td>
            {{$item->area_name}}
          </td>
        </tr>
        <tr>
          <th>神社仏閣市町村</th>
          <td>
            {{$item->address}}
          </td>
        </tr>
        <tr>
          <th>購入物の要望(正式名称、金額、参考URL、画像)</th>
          <td>
            {{$item->amulet}}
          </td>
          @if(isset($item->img_url))
          <td>{{$item->img_url}}</td>
          @endif
        </tr>
        <tr>
          <th>その他</th>
          <td>
            {{$item->free}}
          </td>
        </tr>
        <tr>
          <th>受け取り金額
            <br><span>現地までの交通費、駐車料金、墓花、御供、グッズ等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            {{$item->price}}円(税込)
          </td>
        </tr>
      </table>
      @elseif($item->plan_id == 3)
      <table class="table">
        <tr>
          <th>プラン</th>
          <td>神社仏閣参拝、祈祷代行</td>
        </tr>
        <tr>
          <th>依頼ユーザー名</th>
          <td>{{$item->user_name}}</td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            {{$item->date_begin}}〜{{$item->date_end}}
          </td>
        </tr>
        <tr>
          <th>該当の神社仏閣の都道府県</th>
          <td>
            {{$item->area_name}}
          </td>
        </tr>
        <tr>
          <th>神社仏閣市町村</th>
          <td>
            {{$item->address}}
          </td>
        </tr>
        <tr>
          <th>参拝、祈祷内容</th>
          <td>
            {{$item->praying}}
          </td>
        </tr>
        <tr>
          <th>ご依頼概要</th>
          <td>
            @foreach($s as $value)
            @if($value)
            ・{{$value}}<br>
            @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <th>御朱印の有無</th>
          <td>
            {{$item->goshuin}}
          </td>
        </tr>
        @if(isset($item->goshuin_content))
        <tr>
          <th>御朱印に関する詳細内容</th>
          <td>
            {{$item->goshuin_content}}
          </td>
        </tr>
        @endif
        <tr>
          <th>その他</th>
          <td>
            {{$item->free}}
          </td>
        <tr>
          <th>受け取り金額
            <br><span>現地までの交通費、駐車料金、墓花、御供、グッズ等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            {{$item->price}}円(税込)
          </td>
        </tr>
      </table>
      @elseif($item->plan_id == 4)
      <table class="table">
        <tr>
          <th>プラン</th>
          <td>その他お参り代行</td>
        </tr>
        <tr>
          <th>依頼ユーザー名</th>
          <td>
            {{$item->user_name}}
          </td>
        </tr>
        <tr>
          <th>ご依頼内容</th>
          <td>
            {{$item->free}}
          </td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            {{$item->date_begin}}〜{{$item->date_end}}
          </td>
        </tr>
        <tr>
          <th>依頼に該当する都道府県</th>
          <td>
            {{$item->area_name}}
          </td>
        </tr>
        <tr>
          <th>依頼に該当する住所</th>
          <td>
            {{$item->address}}
          </td>
        </tr>
        <tr>
          <th>依頼に該当する施設名称</th>
          <td>
            {{$item->spot}}
          </td>
        </tr>
        <tr>
          <th>受け取り金額
            <br><span>現地までの交通費、駐車料金、墓花、御供、グッズ等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            {{$item->price}}円(税込)
          </td>
        </tr>
      </table>
      @endif
      <div class="row my-1">
        <button class="col-6 fs-6 btn btn-primary" onclick=location.href="{{route('mypage.myrequest.member_list',['request_id'=>$item->id])}}">{{$item->apply_count}}名からの応募があります</button>
      </div>
      <div class="row">
        <button type="button" class="col-3 btn btn-outline-secondary" onClick="history.back();">戻る</button>
        <button type="button" class="col-3 btn btn-outline-primary offset-1" onclick="location.href='{{route('mypage.myrequest.edit',['request_id' => $item->id])}}'">内容修正</button>

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