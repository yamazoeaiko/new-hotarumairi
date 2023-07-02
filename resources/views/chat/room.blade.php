@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row gx-5 align-items-center">
    <div class="col-12">
      <button class="btn-outline-primary" onClick="location.href='{{route('chat.list')}}'">戻る</button>
      <p class="col me-2 fs-5 fw-bolder ">{{ $theother->nickname }}</p>
      <div class="d-flex  align-items-center mb-3">

        @if($mytype == 'sell_user')
        @if($agreement == null)
        <button class="btn btn-danger fs-7 col p-3 mx-2" onclick="location.href='{{route('agreement.create',['service_id'=>$service->id, 'entry_id'=>$entry->id])}}'">見積もり提案を送付</button>
        @else
        <button class="btn btn-danger fs-7 col p-3 mx-2" onclick="location.href='{{route('agreement.index',['agreement_id'=>$agreement->id])}}'">見積もり内容</button>
        @endif
        @endif
        @if($mytype == 'buy_user')
        @if($agreement ==null)
        <button class="btn btn-danger fs-7 col p-3 mx-2" disabled>
          見積もり提案がありません
        </button>
        @else
        <button class="btn btn-outline-danger fs-7 col p-3 mx-2" onclick="location.href='{{route('agreement.index',['agreement_id'=>$agreement->id])}}'">見積もり内容</button>
        @endif
        @endif

        @if($service->type == 'public_request')

        <button class="btn btn-outline-primary fs-7 col p-3 mx-2" onclick="location.href='{{route('pubreq.detail',['service_id'=>$service->id])}}'">公開依頼内容</button>
        @elseif($service->type == 'service')
        <button class="btn btn-outline-primary col fs-7 p-3 mx-2" onclick="location.href='{{route('service.detail',['service_id'=>$service->id])}}'">出品サービス内容</button>

        @endif
        <!--正式な納品報告-->
        @if($entry)
        @if($mytype == 'sell_user')
        @if($entry->status == 'paid')
        <button type="button" id="deliveryButton" class="col fs-7 p-3 btn btn-success mx-2 fw-bolder">正式納品を報告</button>
        <div id="deliveryPopup" class="delivery_offer text-center p-3 rounded-2 border-primary border-3">
          <div class="fs-5 fw-bolder text-primary my-3">正式な納品を報告する</div>
          <div class="fs-7 text-danger">※納品報告をしてください。<br>事前にチャットにて確認いただく方がスムーズです。</div>
          <form action="{{route('offer.delivery')}}" method="post">
            @csrf
            <input type="hidden" name="entry_id" value="{{$entry->id}}">
            <input type="hidden" name="room_id" value="{{$room->id}}">
            <div class="input-group my-3">
              <textarea name="message" class="text-start input-group-text is-valid" style="resize: none; height: 100px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。"></textarea>
            </div>
            <button type="submit" class="btn btn-primary my-2" onclick="return confirm('正式な納品を報告しますか？')">送信する</button>
          </form>
        </div>
        @endif
        @endif
        @endif
      </div>
      <!-- Mashead text and app badges-->
      <div>
        @if($delivery)
        @if($mytype == 'buy_user')
        <div class="mb-3 p-3 rounded-2 border border-primary border-3 ">
          <h6>正式な納品の連絡あり</h6>
          <p class="fs-6">納品時のメッセージ：{{$delivery->message}}</p>
          @if($entry->status == 'delivery_pending')
          <div class="text-center d-flex">
            <form action="{{ route('approved.delivery') }}" method="post" class="mx-2 mt-2">
              @csrf
              <input type="hidden" name="entry_id" value="{{$entry->id}}">
              <button type="submit" class="btn btn-outline-success my-2 border border-2 border-success" onclick="return confirm('納品を承認しますか？作業完了となり、これ以降本件で依頼はできなくなります。')">承認する</button>
            </form>
            <form action="{{ route('unapproved.delivery') }}" method="post" class="mx-2 mt-2">
              @csrf
              <input type="hidden" name="entry_id" value="{{$entry->id}}">
              <button type="submit" class="btn btn-outline-danger my-2" onclick="return confirm('納品を否認しますか？否認の理由などはチャットにてお伝えください。')">否認する</button>
            </form>
          </div>
          @endif
          @if($entry->status == 'delivery_complete')
          <div class="text-center">
            <button disabled class="btn btn-primary">承認完了</button>
          </div>
          @endif
        </div>
        @elseif($mytype == 'sell_user')
        <div class="mb-3 p-3 rounded-2 border border-primary border-3 ">
          <h6>正式な納品の連絡</h6>
          <p class="fs-6">納品時のメッセージ：{{$delivery->message}}</p>
          @if($entry->status == 'delivery_pending')
          <p class="text-danger fs-6">相手の承認・否認をお待ちください</p>
          @endif
          @if($entry->status == 'delivery_complete')
          <div class="text-center">
            <button disabled class="btn btn-primary">承認完了されました</button>
          </div>
          @endif
        </div>
        @endif
        @endif
        <div class="col-12 mb-5 text-center text-start">
          <!--ここからルーム-->
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
                  <textarea name="message" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.value += '\n';}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。"></textarea>
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

<script>
  var deliveryButton = document.getElementById("deliveryButton");
  var deliveryPopup = document.getElementById("deliveryPopup");

  deliveryButton.addEventListener("click", function() {
    if (deliveryPopup.style.display === "none") {
      deliveryPopup.style.display = "block";
    } else {
      deliveryPopup.style.display = "none";
    }
  });
</script>

<style>
  .delivery_offer {
    width: 80%;
    display: none;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    padding: 10px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
</style>
@endsection