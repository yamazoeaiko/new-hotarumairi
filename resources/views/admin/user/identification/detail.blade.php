@extends('layouts.admin')
@section('content')
<div class="container">
  <a href="{{route('admin.identification.offer.list')}}" class="mb-3 text-secondary">本人確認証明書の申請一覧に戻る</a>
  <h5 class="my-3">【管理画面】本人確認証明書　詳細確認</h5>
  <div>
    <table class="table">
      <tr>
        <th>申請者氏名</th>
        <td>{{$item->user_name}}</td>
      </tr>
      <tr>
        <th>アカウント名</th>
        <td>{{$item->user_nickname}}</td>
      </tr>
      <tr>
        <th>性別</th>
        <td>{{$item->gender}}</td>
      </tr>
      <tr>
        <th>生年月日</th>
        <td>{{ \Carbon\Carbon::parse($item->birthday)->format('Y年m月d日') }}</td>
      </tr>
      <tr>
        <th>本人確認証明書データ</th>
        <td>
          <div>
            <a class="text-decoration-underline text-info" href="{{asset($item->identification_photo)}}">申請データ（1枚目）</a>
          </div>

          @if($item->identification_photo_2)
          <div>
            <a class="text-info text-decoration-underline" href="{{asset($item->identification_photo_2)}}">申請データ（2枚目）</a>
          </div>
          @endif
        </td>
      </tr>
      <tr>
        <th>確認ステータス</th>
        <td>{{$item->status}}</td>
      </tr>
    </table>
  </div>
  @if($item->identification_agreement == 'pending')
  <div class="text-center d-flex">
    <form action="{{route('admin.identification.approved')}}" class="mx-2" method="post">
      @csrf
      <input type="hidden" name="identification_id" value="{{ $item->id }}">
      <button class="btn btn-primary" type="submit" onclick="return confirm('承認しますか？')">承認</button>
    </form>
    <form action="{{route('admin.identification.unapproved')}}" method="post" class="mx-2">
      @csrf
      <input type="hidden" name="identification_id" value="{{ $item->id }}">
      <button class="btn btn-outline-danger" type="submit" onclick="return confirm('否認しますか？')">否認</button>
    </form>
  </div>
  @elseif($item->identification_agreement =='approved')
  <button disabled="disabled" class="btn btn-primary">承認済み</button>
  @elseif($item->identification_agreement =='unapproved')
  <button disabled="disabled" class="btn btn-danger">否認済み</button>
  @endif
  <div class="my-5">
    <h6>{{$item->user_name}}（{{$item->user_nickname}}）のその他の本人確認証明申請</h6>
    @if($other_items == null)
    <div class="fs-6 text-danger">その他の申請はありません</div>
    @else
    <div class="list-group">
      @foreach($other_items as $other_item)
      <div class="list-group-item list-group-action">
        <div class="no-gutters">
          <div class="row">
            <div class="col-3">
              <a href="{{asset($other_item->identification_photo)}}">本人証明書データ</a>
            </div>
            <div class="col-6 text-right">
              <p class="text-muted small">申請日：{{ \Carbon\Carbon::parse($other_item->created_at)->format('Y年m月d日 H時i分') }}</p>
            </div>
          </div>
          <div class="row">
            ステータス：{{$other_item->status}}
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</div>
@endsection