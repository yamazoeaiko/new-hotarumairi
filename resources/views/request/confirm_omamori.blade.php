@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <form action="{{route('request.done')}}" method="post" class="form-control" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="user_id" id="" value="{{$params->user_id}}">
      <table class="table">
        <tr>
          <th>プラン</th>
          <input type="hidden" name="plan_id" value="2">
          <td>御守り購入代行</td>
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
          <th>購入したいもの(正式名称、金額、参考URL、画像)</th>
          <td>
            <textarea name="amulet" cols="30" rows="3" class="input-group-text">{{$params->amulet}}</textarea>
          </td>
        </tr>
        <tr>
          <th>購入依頼物の画像(任意)</th>
          <td><input type="hidden" name="img_url" value="{{$path}}">
            <a href="{{ asset($path) }}">{{ $fileName }}</a>
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="input-group-text">{{$params->free}}</textarea>
          </td>
        <tr>
          <th>費用
            <span>費用：現地までの交通費、駐車料金、墓花、御供、グッズ等の全ての購入代金や経費を含む金額</span>
          </th>
          <td>
            <input type="number" name="price" class="input-group-text" value="{{$params->price}}" hidden>
            {{$params->price}}
          </td>
        </tr>
      </table>
      <button name="submit" class="btn btn-primary">この内容で募集開始する</button>
      <button type="button" onClick="history.back();" class="btn">修正する</button>
    </form>
  </div>
</body>