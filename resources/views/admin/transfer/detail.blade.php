@extends('layouts.admin')
@section('content')
<div class="container">
  <div class="my-4">
    <h5 class="fw-bold fs-5 text-primary">{{ $user->nickname }}さんの振込リクエスト情報</h5>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">支払いID</th>
          <th scope="col">サービスID</th>
          <th scope="col">購入日</th>
          <th scope="col">振込依頼金額</th>
          <th scope="col">返金(キャンセルの場合)</th>
          <th scope="col">振込</th>
        </tr>
      </thead>
      <tbody>
        @if(!$items->isEmpty())
        @foreach($items as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->service_id }}</td>
          <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('Y年m月d日') }}</td>
          <td>{{ $item->transfer_price }}円</td>
          <td>{{ $item->cancel_fee ? $item->cancel_fee . '円' : '0円' }}</td>
          <td>{{ $item->status_name }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="fs-6 text-danger">現在未対応の振込リクエストはありません。</p>
    @endif
  </div>
  <div class="my-4">
    <h6 class="fw-bold fs-5 text-primary">振込リクエスト合計金額</h6>
    <table class="table">
      <tr>
        <th class="fw-normal">振込申請済み金額</th>
        <td>{{ $total_transfer_price }}円</td>
      </tr>
    </table>
    <div class="my-4 text-center">
      <form action="{{route('admin.transfer.done')}}" method="post">
        @csrf
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <button type="submit" class="btn btn-primary" onclick="return confirm('振込完了ステータスに変更してよろしいですか？')" @if($total_transfer_price < 1000) disabled @endif>
          振込完了
        </button>
      </form>
      <div class="fs-7 text-danger">
        ユーザーに通知が届くので、振込完了後にボタンを押してください。
      </div>
    </div>
  </div>
  <div class="my-4 text-center">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#collapseBank">振込先口座情報を確認する</button>

    <div class="collapse" id="collapseBank">
      <div class="container">
        <h6 class="my-4 fw-bold fs-5 text-primary">振込先口座情報</h6>
        @if($bank == null)
        <div class="text-center">
          <p class="text-danger fs-6 my-4">振込先が未登録です。</p>
        </div>
        @else
        <table class="table">
          <tr>
            <th>金融機関名</th>
            <td>
              {{ $bank->bank_name }}
            </td>
          </tr>
          <tr>
            <th>支店名</th>
            <td>
              {{ $bank->branch_name }}
            </td>
          </tr>

          <tr>
            <th>口座種別</th>
            <td>
              {{ $bank->account_type }}
            </td>
          </tr>

          <tr>
            <th>口座番号</th>
            <td>
              {{ $bank->account_number }}
            </td>
          </tr>

          <tr>
            <th>口座名義（カナ）</th>
            <td>
              {{$bank->account_name }}
            </td>
          </tr>
        </table>
        @endif
      </div>
    </div>
  </div>
  @endsection