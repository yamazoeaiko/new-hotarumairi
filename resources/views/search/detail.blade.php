@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
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
          {{$item->price_net}}円(税込)
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
          @if(isset($item->img_url))
          <br>
          <a href="{{ asset($item->img_url) }}">画像があります</a>
          @endif
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
          {{$item->price_net}}円(税込)
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
          {{$item->price_net}}円(税込)
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
          {{$item->price_net}}円(税込)
        </td>
      </tr>
    </table>
    @endif

    @if($item->request_user_id == $user_id)
    <button class="btn btn-outline-secondary col-3" onclick="location.href='{{route('mypage.myrequest.edit',['request_id'=> $item->id])}}'">内容編集</button>
    @elseif($apply_flag == 1)

    <button type="button" class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#collapseApply">応募者に質問や応募のメッセージを送る。</button>

    <div class="collapse" id="collapseApply">
      <form action="{{route('search.apply')}}" method="post">
        @csrf
        <input type="hidden" name="request_id" value="{{$item->id}}">
        <textarea name="first_chat" id="first_chat" cols="80" rows="10" class="text-start m-3">※必ず記載してください。
特に依頼者への質問がない場合は、「記載のご依頼通りに対応します」
と記載し下の応募するボタンを押してください。
</textarea>
        <button type="submit" class="btn btn-primary col-3">応募する</button>
      </form>
    </div>
    @else
    <button disabled class="btn btn-outline-primary col-3">応募済みです</button>
    @endif

    <button onclick="history.back()" type="button" name="back" class="btn btn-outline-primary col-3">戻る</button>
  </div>
</body>