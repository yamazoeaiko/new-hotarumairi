@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <form action="{{route('request.done')}}" method="post" class="form-control">
      @csrf
      <input type="hidden" name="user_id" id="" value="{{$params->user_id}}">
      <table class="table">
        <tr>
          <th>プラン</th>
          <input type="hidden" name="plan_id" value="3">
          <td>神社仏閣参拝、祈祷代行</td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            <input type="date" name="date_begin" id="" class="input-group-text" value="{{$params->date_begin}}" hidden><input type="date" name="date_end" class="input-group-text" value="{{$params->date_end}}" hidden>
            {{$params->date_begin}}〜{{$params->date_end}}
          </td>
        </tr>
        <tr>
          <th>該当の神社仏閣の都道府県</th>
          <td>
            <input type="number" name="area_id" id="" value="{{$params->area_id}}" hidden>{{$params->area_name}}
          </td>
        </tr>
        <tr>
          <th>神社仏閣市町村(可能ならば番地まで)</th>
          <td>
            <input type="text" name="address" class="input-group-text" value="{{$params->address}}" hidden>
            {{$params->address}}
          </td>
        </tr>
        <tr>
          <th>ご希望の参拝、祈祷内容</th>
          <td>
            <textarea name="praying" cols="30" rows="3" class="input-group-text">{{$params->praying}}</textarea>
          </td>
        </tr>
        <tr>
          <th>ご依頼概要(複数選択可能)</th>
          <td>
            <input type="hidden" name="sanpai_sum" value="{{ $sum }}">
            @foreach($items as $item)
            ・{{$item->sanpai_sum_name}}<br>
            @endforeach
          </td>
        </tr>
        <tr>
          <th>御朱印の有無</th>
          <td>
            <input type="hidden" name="goshuin" value="{{$params->goshuin}}">
            @if($params->goshuin == 0)
            <p>不要</p>
            @else
            <p>要</p>
            @endif
          </td>
        </tr>
        <tr>
          <th>御朱印アリの場合詳細を記入<br><span>郵送を希望の際、住所など個人情報は記載しないでください<br>（個別チャットでやり取り）</span></th>
          <td>
            <input type="hidden" name="goshuin_content" value="{{$params->goshuin_content}}">
            {{$params->goshuin_content}}
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            <input type="hidden" name="free" value="{{$params->free}}">
            {{$params->free}}
          </td>
        </tr>
        <tr>
          <th>費用<br>
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            <input type="hidden" name="price" class="input-group-text" value="{{$params->price}}">
            {{$params->price}}
          </td>
        </tr>
      </table>
      <button name="submit" class="btn btn-primary">この内容で募集開始する</button>
      <button type="button" onClick="history.back();" class="btn">修正する</button>
    </form>
  </div>
</body>