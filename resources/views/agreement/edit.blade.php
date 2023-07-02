@extends('layouts.app')

@section('content')
<div class="container">
  <h5>お見積内容の修正</h5>
  <form action="{{ route('agreement.update') }}" method="post">
    @csrf
    <input type="hidden" name="agreement_id" value="{{$item->id}}">
    <div class="mb-3">
      <label for="main_title" class="fw-bolder"> サービスタイトル</label>
      <input type="text" name="main_title" class="form-control fw-bolder" value="{{ $item->main_title }}">
    </div>

    <div class="mb-3">
      <label for="content" class="fw-bolder">サービス内容<span class="fs-7 text-danger">（任意）</span></label>
      <div class="input-group">
        <textarea name="content" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。">{{ $item->content }}</textarea>
      </div>
    </div>

    <div class="mb-3">
      <label for="price" class="fw-bolder">お見積り金額</label>
      <div class="input-group">
        <input type="number" class="form-control" name="price" id="price" value="{{ $item->price }}">
        <div class="input-group-append">
          <span class="input-group-text">円（税別）</span>
        </div>
      </div>
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="delivery_deadline">納品（実施）日<span class="fs-7 text-danger">（任意）</span></label>
      <input type="date" class="form-control" name="delivery_deadline" value="{{ $item->delivery_deadline }}" min="<?php echo date('Y-m-d'); ?>">
    </div>

    <div class="form-group mb-3">
      <label class="fw-bolder" for="free">自由記入欄<span class="fs-7 text-danger">（任意）</span></label>
      <textarea class="form-control" name="free" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。">{{ $item->free }}</textarea>
    </div>
    <div class="text-cente mt-3">
      <button type="submit" class="btn btn-primary">更新</button>
    </div>
  </form>
</div>
@endsection