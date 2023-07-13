@extends('layouts.app')

@section('content')
<div class="container">
  <h6 class="my-4 fw-bold fs-5 text-primary">振込先口座情報</h6>
  @if($item == null)
  <div class="text-center">
    <p class="text-danger fs-6 my-4">振込先が未登録です。</p>
    <button class="btn btn-primary my-4" onclick="location.href='{{ route('mypage.bank.create') }}'">振込先情報の登録</button>
  </div>
  @else
  <table class="table">
    <tr>
      <th>金融機関名</th>
      <td>
        {{ $item->bank_name }}
      </td>
    </tr>
    <tr>
      <th>支店名</th>
      <td>
        {{ $item->branch_name }}
      </td>
    </tr>

    <tr>
      <th>口座種別</th>
      <td>
        {{ $item->account_type }}
      </td>
    </tr>

    <tr>
      <th>口座番号</th>
      <td>
        {{ $item->account_number }}
      </td>
    </tr>

    <tr>
      <th>口座名義（カナ）</th>
      <td>
        {{$item->account_name }}
      </td>
    </tr>
  </table>
  <div class="text-center">
    <button class="btn btn-secondary mx-2" onClick="location.href='{{route('mypage.bank.edit')}}'">口座情報の変更</button>
    <button class="btn btn-primary mx-2" onClick="location.href='{{route('proceeds.information')}}'">売上情報・振込申請</button>
  </div>
  @endif
</div>
@endsection