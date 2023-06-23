@extends('layouts.admin')
@section('content')
<div class="container">
  <h5>【管理画面】本人確認証明書　詳細確認</h5>
  <div>
    <table class="table">
      <tr>
        <th>申請者氏名</th>
        <td>{{$item->user_name}}</td>
      </tr>
      <tr>
        <th>ニックネーム</th>
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
          <a href="{{asset($item->identification_photo)}}">申請データ</a>
        </td>
      </tr>
      <tr>
        <th>確認ステータス</th>
        <td>{{$item->status}}</td>
      </tr>
    </table>
  </div>
  <div class="my-5">
    <h6>{{$item->user_name}}（{{$item->user_nickname}}）のその他の本人確認証明申請</h6>
    @if($other_items->isEmpty())
    <div class="fs-6 text-danger">その他の申請はありません</div>
    @endif
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
  </div>
</div>
@endsection