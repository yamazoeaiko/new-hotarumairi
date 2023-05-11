@extends('layouts.app')

@section('content')
<div class="container">
  <h5>お見積書</h5>
  <div class="mb-3">
    <label for="main_title" class="fw-bolder"> サービスタイトル</label>
    <input type="text" name="main_title" class="form-control fw-bolder" value="{{ $item->main_title }}" readonly>
  </div>

  <div class="mb-3">
    <label for="content" class="fw-bolder">サービス内容<span class="fs-7 text-danger">（任意）</span></label>
    <div class="input-group">
      <textarea name="content" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.form.submit();}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Shift+Enterで改行。Enterで送信。" readonly>{{ $item->content }}</textarea>
    </div>
  </div>

  <div class="mb-3">
    <label for="price" class="fw-bolder">お見積り金額</label>
    <div class="input-group">
      <input type="number" class="form-control" name="price" id="price" value="{{ $item->price }}" readonly>
      <div class="input-group-append">
        <span class="input-group-text">円（税別）</span>
      </div>
    </div>
  </div>

  <div class="form-group mb-3">
    <label class="fw-bolder" for="delivery_deadline">納品（実施）日<span class="fs-7 text-danger">（任意）</span></label>
    <input type="date" class="form-control" name="delivery_deadline" value="{{ $item->delivery_deadline }}" readonly>
  </div>

  <div class="form-group mb-3">
    <label class="fw-bolder" for="free">自由記入欄<span class="fs-7 text-danger">（任意）</span></label>
    <textarea class="form-control" name="free" readonly>{{ $item->free }}</textarea>
  </div>

  <div class="text-center">
    @if($mytype == 'buy_user')
    @if($item->status == 'paid')
    <button class="btn btn-danger" disabled>支払い済み</button>
    @elseif($item->status == 'pending')
    <button class="btn btn-danger my-1 mx-2" onclick="location.href='{{route('payment',['agreement_id'=>$item->id])}}'">承認（支払い画面へ）</button>
    <form action="{{ route('agreement.unapproved') }}" method="post">
      @csrf
      <button type="submit" class="btn btn-outline-danger">辞退する</button>
    </form>
    @elseif($item->status == 'unapproved')
    <button class="btn btn-danger" disabled>辞退しました</button>
    @endif
    @endif

    @if($mytype == 'sell_user')
    @if($item->status == 'pending')
    <button class="btn btn-danger my-1 mx-2" onclick="location.href='{{route('agreement.edit',['agreement_id'=>$item->id])}}'">お見積もり修正</button>
    <form action="{{ route('agreement.cancel') }}" method="post">
      @csrf
      <button type="submit" class="btn btn-outline-danger">キャンセルする</button>
    </form>
    @elseif($item->status == 'unapproved')
    <button class="btn btn-danger my-1 mx-2" onclick="location.href='{{route('agreement.edit',['agreement_id'=>$item->id])}}'">お見積もり修正して再提案</button>
    @elseif($item->status == 'paid')
    <button class="btn btn-danger" disabled>承認されました（支払い済み）</button>
    @endif
    @endif
  </div>
  </form>
</div>
@endsection