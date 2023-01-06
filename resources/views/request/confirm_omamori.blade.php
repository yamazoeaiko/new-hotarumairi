@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>
  <div class="container">
    <form action="{{route('request.done')}}" method="post" class="form-control">
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
          <th>御守りを購入できる神社がある都道府県</th>
          <td>
            <input type="number" name="area_id" id="" value="{{$params->area_id}}" hidden>{{$params->area_name}}
          </td>
        </tr>
        <tr>
          <th>神社住所</th>
          <td>
            <input type="text" name="address" class="input-group-text" value="{{$params->address}}" hidden>
            {{$params->address}}
          </td>
        </tr>
        <tr>
          <th>何の御守りか（御守りの名称など）</th>
          <td>
            <textarea name="amulet" cols="30" rows="3" class="input-group-text">{{$params->amulet}}</textarea>
          </td>
        </tr>
        <tr>
          <th>その他</th>
          <td>
            <textarea name="free" id="" cols="30" rows="3" class="input-group-text">{{$params->free}}</textarea>
          </td>
        <tr>
          <th>お支払い金額</th>
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