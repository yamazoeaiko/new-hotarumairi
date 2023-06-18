@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row gx-5 align-items-center">
    <div class="col-12">
      <button class="btn-outline-primary" onClick="location.href='{{route('chat.list')}}'">戻る</button>
      <div class="d-flex  align-items-center mb-3">
        <p class="col me-2 fs-5 fw-bolder ">{{ $theother->nickname }}</p>
        <div class="mx-2">
          @if($mytype == 'sell_user')
          @if($agreement == null)
          <button class="btn btn-danger fs-7 col p-3" onclick="location.href='{{route('agreement.create',['service_id'=>$service->id, 'entry_id'=>$entry->id])}}'">見積もり提案を送付</button>
          @else
          <button class="btn btn-danger fs-7 col p-3" onclick="location.href='{{route('agreement.index',['agreement_id'=>$agreement->id])}}'">提案した見積もり内容を見る</button>
          @endif
          @endif
          @if($mytype == 'buy_user')
          @if($agreement ==null)
          <button class="btn btn-danger fs-7 col p-3" disabled>
            見積もり提案がありません
          </button>
          @else
          <button class="btn btn-danger fs-7 col p-3" onclick="location.href='{{route('agreement.index',['agreement_id'=>$agreement->id])}}'">提案された見積もり内容を見る</button>
          @endif
          @endif
        </div>
        @if($service->type == 'public_request')
        <button class="btn btn-primary fs-7 col p-3" onclick="location.href='{{route('pubreq.detail',['service_id'=>$service->id])}}'">公開依頼詳細を確認</button>
        @elseif($service->type == 'service')
        <button class="btn btn-primary p-3" onclick="location.href='{{route('service.detail',['service_id'=>$service->id])}}'">出品サービス詳細を確認</button>
        @endif
      </div>

      <!--hotaru_requestの修正・承認へ-->
      <!-- Mashead text and app badges-->
      <div class="col-12 mb-5 text-center text-start">
        <!--ここからルーム-->
        <div>
          <div class="col-9 col-sm-12 mx-auto bg-light p-1" style="max-height: 500px; overflow-y: auto;">
            <ul style="padding: 0;">
              @if($chats->isEmpty())
              <span>最初のメッセージを送ろう</span>
              @else
              @foreach($chats as $chat)
              <div class="message d-flex align-items-start mb-4 
          @if($chat->sender_id == $user_id)flex-row-reverse @else flex-row @endif">
                <p class="fs-xs">{{$chat->nickname}}</p>
                <div>
                  <img src="{{ asset($chat->img_url) }}" alt="" class="message-icon rounded-circle text-white fs-3">
                </div>
                @if($chat->message !== null)
                <p class="message-text p-2 m-2 mb-0 text-start @if($chat->sender_id == $user_id) from-user-bg @else to-user-bg @endif" style="word-wrap: break-word; max-width: 80%;">
                  {!! nl2br(e($chat->message)) !!}
                </p>
                @endif
                @if($chat->file !== null)
                <p class="message-text p-2 m-2 mb-0 text-start @if($chat->sender_id == $user_id) from-user-bg @else to-user-bg @endif" style="word-wrap: break-word; max-width: 80%;">
                  <a href="{{ asset($chat->file)}}" class="fc-blue fw-bolder">添付ファイルがあります</a>
                </p>
                @endif
              </div>
              @endforeach
              @endif
            </ul>
          </div>

          <!-- .chat -->
          <form action="{{route('send.chat')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-center mt-3 row fixed-bottom mb-3 bg-white">
              <input type="hidden" name="room_id" value="{{ $room_id }}">
              <input type="hidden" name="receiver_id" value="{{$theother->id}}">
              <input type="hidden" name="user_id" value="{{ $user_id }}">
              <div class="col-6" style="padding-right: 0;">
                <div class="input-group h-100">
                  <textarea name="message" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.form.submit();}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Shift+Enterで改行。Enterで送信。"></textarea>
                  <div class="form-group">
                    <input type="file" accept=".png, .jpeg, .jpg" name="file_path">
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">送信</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- .container -->
        <!--ここまでルーム-->
      </div>
    </div>
  </div>
</div>
@endsection