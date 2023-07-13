@extends('layouts.app')

@section('content')
<div class="container">
  <h6 class="my-4 fw-bold fs-5 text-primary">振込先情報の登録</h6>
  <form action="{{route('mypage.bank.done')}}" method="post" class="form-group">
    @csrf
    <table class="table">
      <input type="hidden" name="user_id" value="{{ $user_id }}">
      <tr>
        <th>金融機関名</th>
        <td>
          <input type="text" class="form-control" name="bank_name" placeholder="例）○○銀行">
        </td>
      </tr>
      <tr>
        <th>支店名</th>
        <td>
          <input type="text" class="form-control" name="branch_name" placeholder="例）○○支店">
        </td>
      </tr>

      <tr>
        <th>口座種別</th>
        <td>
          <label>
            <input type="radio" name="account_type" value="普通口座" checked>
            普通口座
          </label>
          <label>
            <input type="radio" name="account_type" value="当座預金">
            当座預金
          </label>
          <label>
            <input type="radio" name="account_type" value="貯蓄預金">
            貯蓄預金
          </label>
          <label>
            <input type="radio" name="account_type" value="その他">
            その他
          </label>

        </td>
      </tr>

      <tr>
        <th>口座番号</th>
        <td>
          <input type="text" class="form-control" name="account_number" placeholder="例）0123456">
        </td>
      </tr>

      <tr>
        <th>口座名義（カナ）</th>
        <td>
          <input type="text" class="form-control" name="account_name" placeholder="例）ヤマダ　タロウ">
        </td>
      </tr>
    </table>
    <div class="text-center">
      <button class="btn btn-primary" type="submit" onclick="return confirm('登録情報が正しいことを確認後、OKを押してください。')">登録</button>
    </div>
  </form>
</div>
@endsection