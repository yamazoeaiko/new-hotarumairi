@extends('layouts.app')

@section('content')
<div class="container">
  <h5 class="my-2 fw-bold">お見積書</h5>
  <div class="mb-3">
    <label for="main_title" class="fw-bolder"> サービスタイトル</label>
    <input type="text" name="main_title" class="form-control fw-bolder" value="{{ $item->main_title }}" readonly>
  </div>

  <div class="mb-3">
    <label for="content" class="fw-bolder">サービス内容<span class="fs-7 text-danger">（任意）</span></label>
    <div class="input-group">
      <textarea name="content" class="text-start form-control" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" oninput="resizeTextarea(this)" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。" readonly>{{ $item->content }}</textarea>
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

  <div class="d-flex justify-content-around">
    @if($mytype == 'buy_user')
    @if($item->status == 'paid')
    <button class="btn btn-primary" disabled>支払い済み</button>
    <!--
    <button class="btn btn-danger my-1 mx-2" onclick="location.href='{{route('buyer.cancel.offer',['agreement_id'=>$item->id, 'entry_id'=>$item->entry_id])}}'">キャンセル申請（返金依頼）</button>
    -->
    @elseif($item->status == 'pending')
    <button class="btn btn-success fw-bolder my-1 mx-2" onclick="location.href='{{route('payment',['agreement_id'=>$item->id])}}'">承認（支払い画面へ）</button>
    <form action="{{ route('agreement.unapproved') }}" method="post">
      @csrf
      <input type="hidden" name="agreement_id" value="{{$item->id}}">
      <button type="submit" class="btn btn-outline-danger" onclick="return confirm('この見積もり提案を辞退しますか？辞退すると復元できません。')">辞退する</button>
    </form>
    @elseif($item->status == 'unapproved')
    <button class="btn btn-danger" disabled>辞退しました</button>
    @elseif($item->status == 'cancel_pending')
    <button class="btn btn-danger" disabled>キャンセル申請済み</button>
    <div class="text-danger fs-7">
      ※管理者確認中です。しばらくお待ちください。
    </div>
    @elseif($item->status == 'canceled')
    <button class="btn btn-danger" disabled>キャンセル完了</button>
    @endif
    @endif

    @if($mytype == 'sell_user')
    @if($item->status == 'pending')
    <button class="btn btn-success my-1 mx-2" onclick="location.href='{{route('agreement.edit',['agreement_id'=>$item->id])}}'">お見積もり修正</button>
    <form action="{{ route('agreement.cancel') }}" method="post">
      @csrf
      <input type="hidden" name="agreement_id" value="{{$item->id}}">
      <button type="submit" class="btn btn-outline-danger" onclick="return confirm('この見積もり提案をキャンセルしますか？キャンセルすると復元できません。')">キャンセルする</button>
    </form>
    @elseif($item->status == 'unapproved')
    <button class="btn btn-success my-1 mx-2" onclick="location.href='{{route('agreement.edit',['agreement_id'=>$item->id])}}'">お見積もり修正して再提案</button>
    @elseif($item->status == 'paid')
    <button class="btn btn-primary" disabled>承認されました（支払い済み）</button>
    <button class="btn btn-danger my-1 mx-2" onclick="location.href='{{route('seller.cancel.offer',['agreement_id'=>$item->id, 'entry_id'=>$item->entry_id])}}'">キャンセル申請（返金依頼）</button>
    @elseif($item->status == 'cancel_pending')
    <button class="btn btn-danger" disabled>キャンセル申請済み</button>
    <div class="text-danger fs-7">
      ※管理者確認中です。しばらくお待ちください。
    </div>
    @elseif($item->status == 'canceled')
    <button class="btn btn-danger" disabled>キャンセル完了</button>
    @endif
    @endif
  </div>
</div>
@endsection

<script>
  function resizeTextarea(textarea) {
    textarea.style.height = '70px';
    textarea.style.height = textarea.scrollHeight + 'px';
  }

  const textarea = document.querySelector('textarea');
  textarea.addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      const startPos = textarea.selectionStart;
      const endPos = textarea.selectionEnd;
      textarea.value = textarea.value.substring(0, startPos) + '\n' + textarea.value.substring(endPos, textarea.value.length);
      resizeTextarea(textarea);
    }
  });
</script>