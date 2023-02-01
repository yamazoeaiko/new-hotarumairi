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
          <input type="hidden" name="plan_id" value="1">
          <td>お墓のお掃除・お参り代行</td>
        </tr>
        <tr>
          <th>日程</th>
          <td>
            <input type="date" name="date_begin" id="" class="input-group-text" value="{{$params->date_begin}}" hidden><input type="date" name="date_end" class="input-group-text" value="{{$params->date_end}}" hidden>
            {{$params->date_begin}}〜{{$params->date_end}}
          </td>
        </tr>
        <tr>
          <th>該当のお墓の都道府県</th>
          <td>
            <input type="number" name="area_id" id="" value="{{$params->area_id}}" hidden>{{$params->area_name}}
          </td>
        </tr>
        <tr>
          <th>お墓の市町村(可能ならば番地まで)</th>
          <td>
            <input type="text" name="address" class="input-group-text" value="{{$params->address}}" hidden>
            {{$params->address}}
          </td>
        </tr>
        <tr>
          <th>ご依頼概要(複数選択可能)</th>
          <td>
            <input type="hidden" name="ohakamairi_sum" value="{{ $sum }}">
            @foreach($items as $item)
            ・{{$item->ohakamairi_sum_name}}<br>
            @endforeach
          </td>
        </tr>
        <tr>
          <th>お供え物・墓花・お線香マナーなどのご要望があれば</th>
          <td>
            <textarea name="offering" cols="30" rows="3" class="input-group-text">{{$params->offering}}</textarea>
          </td>
        </tr>
        <tr>
          <th>お墓のお掃除に関して要望があれば</th>
          <td>
            <textarea name="cleaning" cols="30" rows="3" class="input-group-text">{{$params->cleaning}}</textarea>
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="input-group-text">{{$params->free}}</textarea>
          </td>
        <tr>
          <th>
            費用<br>
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            <input type="number" name="price" class="input-group-text" value="{{$params->price}}" hidden>
            {{$params->price}}円
          </td>
        </tr>
      </table>
      <button name="submit" class="btn btn-primary">この内容で募集開始する</button>
      <button type="button" onClick="history.back();" class="btn">修正する</button>
    </form>
  </div>
</body>