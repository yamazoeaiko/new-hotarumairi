@extends('layouts.app')

@section('content')
<div class="container">
  <h5>お見積書作成</h5>
  <form action="{{ route('agreement.create.done') }}" method="post" class="form-control" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="sell_user" value="{{ $user_id }}">
    <input type="hidden" name="buy_user" value="{{ $entry->buy_user }}">
    <input type="hidden" name="service_id" value="{{ $service->id }}">
    <input type="hidden" name="entry_id" value="{{ $entry->id }}">
    <div class="mb-3">
      <label for="main_title" class="fw-bolder"> サービスタイトル</label>
      <input type="text" name="main_title" class="form-control fw-bolder" value="{{ $service->main_title }}">
    </div>

    <div class="mb-3">
      <label for="content" class="fw-bolder">サービス内容<span class="fs-7 text-danger">（任意）</span></label>
      <div class="input-group">
        <textarea name="content" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。">{{ $service->content }}</textarea>
      </div>
    </div>

    <div class="mb-3">
      <label for="price" class="fw-bolder">お見積り金額<span class="fs-7 text-danger">物品購入などのサービスに付随し発生する費用を含んだ金額。（運営手数料10%差し引かれた金額がお振込されます）</span></label>
      <div class="input-group">
        <input type="number" class="form-control" name="price" id="price" required>
        <div class="input-group-append">
          <span class="input-group-text">円（税別）</span>
        </div>
      </div>
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="delivery_deadline">納品（実施）日<span class="fs-7 text-danger">（任意）</span></label>
      <input type="date" class="form-control" name="delivery_deadline" value="{{ $service->delivery_deadline }}" min="<?php echo date('Y-m-d'); ?>">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="free">自由記入欄<span class="fs-7 text-danger">（任意）</span></label>
      <textarea class="form-control" name="free" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。"></textarea>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-success mt-3" onclick="return confirm('この内容でお見積りを提案しますか？')">お見積もりを提案する</button>
    </div>
  </form>
</div>
@endsection