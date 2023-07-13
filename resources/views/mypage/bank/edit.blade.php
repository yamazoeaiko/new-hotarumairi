@extends('layouts.app')

@section('content')
<div class="container">
  <h6 class="my-4 fw-bold fs-5 text-primary">振込先情報の変更</h6>
  <form action="{{route('mypage.bank.update')}}" method="post" class="form-group">
    @csrf
    <table class="table">
      <input type="hidden" name="user_id" value="{{ $user_id }}">
      <tr>
        <th>金融機関名</th>
        <td>
          <input type="text" class="form-control" name="bank_name" value="{{ $item->bank_name }}">
        </td>
      </tr>
      <tr>
        <th>支店名</th>
        <td>
          <input type="text" class="form-control" name="branch_name" value="{{ $item->branch_name }}">
        </td>
      </tr>

      <tr>
        <th>口座種別</th>
        <td>
          <label>
            <input type="radio" name="account_type" value="普通口座" @if($item->account_type == '普通口座')checked @endif>
            普通口座
          </label>
          <label>
            <input type="radio" name="account_type" value="当座預金" @if($item->account_type == '当座預金')checked @endif>
            当座預金
          </label>
          <label>
            <input type="radio" name="account_type" value="貯蓄預金" @if($item->account_type == '貯蓄預金')checked @endif>
            貯蓄預金
          </label>
          <label>
            <input type="radio" name="account_type" value="その他" @if($item->account_type == 'その他')checked @endif>
            その他
          </label>

        </td>
      </tr>

      <tr>
        <th>口座番号</th>
        <td>
          <input type="text" class="form-control" name="account_number" value="{{ $item->account_number }}">
        </td>
      </tr>

      <tr>
        <th>口座名義（カナ）</th>
        <td>
          <input type="text" class="form-control" name="account_name" value="{{ $item->account_name }}">
        </td>
      </tr>
    </table>
    <div class="text-center">
      <button class="btn btn-primary" type="submit" onclick="return confirm('変更情報が正しいことを確認後、OKを押してください。')">変更</button>
    </div>
  </form>
</div>
@endsection