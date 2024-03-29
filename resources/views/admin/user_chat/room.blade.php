@extends('layouts.admin')

@section('content')
<div class="container">
  <div class="row gx-5 align-items-center">
    <div class="col-12">
      <button class="btn btn-outline-primary" onClick="location.href='{{route('admin.user.chat.list')}}'">一覧に戻る</button>
      <p class="col-9 mx-auto mt-4 fs-5 fw-bolder">{{ $sell_user->nickname }}-{{ $buy_user->nickname }}</p>
      @if($room->status !== 'stopping' )
      <form action="{{ route('admin.user.chat.stop')}}" method="post">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">
        <button class="btn btn-danger">このトークルームを強制停止する</button>
      </form>
      @else
      <form action="{{ route('admin.user.chat.unstop')}}" method="post">
        @csrf
        <input type="hidden" name="room_id" value="{{ $room->id }}">
        <button class="btn btn-success">強制停止を解除する</button>
      </form>
      @endif

      <!-- Mashead text and app badges-->
      <div class="col-12 mb-5 text-center text-start">
        <!--ここからルーム-->
        <div>
          <div class="col-9 col-sm-12 mx-auto bg-light p-1" style="height: 500px; overflow-y: auto;">
            <ul style="padding: 0;">
              @if($chats->isEmpty())
              <span>最初のメッセージを送ろう</span>
              @else
              @foreach($chats as $chat)
              <div class="message d-flex align-items-start mb-4 
          @if($chat->sender_id == $buy_user->id)flex-row-reverse @else flex-row @endif">
                <p class="fs-xs">{{$chat->nickname}}</p>
                <div>
                  <img src="{{ asset($chat->img_url) }}" alt="" class="message-icon rounded-circle text-white fs-3">
                </div>
                @if($chat->message !== null)
                <p class="message-text p-2 m-2 mb-0 text-start @if($chat->sender_id == $buy_user->id) from-user-bg @else to-user-bg @endif" style="word-wrap: break-word; max-width: 80%;">
                  {!! nl2br(e($chat->message)) !!}
                </p>
                @endif
                @if($chat->file !== null)
                <p class="message-text p-2 m-2 mb-0 text-start @if($chat->sender_id == $buy_user->id) from-user-bg @else to-user-bg @endif" style="word-wrap: break-word; max-width: 80%;">
                  <a href="{{ asset($chat->file) }}" class="fc-blue fw-bolder">添付ファイルがあります</a>
                </p>
                @endif
              </div>
              @endforeach
              @endif
            </ul>
          </div>

          <!-- .chat -->
          <form action="{{route('admin.user.chat.send')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-center mt-3 row  mb-3 bg-white">
              <input type="hidden" name="room_id" value="{{ $room->id }}">
              <input type="hidden" name="sender_id" value="1">
              <input type="hidden" name="receiver_id" value="1">
              <div class="col-6" style="padding-right: 0;">
                <div class="input-group  h-100">
                  <textarea name="message" class="text-start form-control" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" oninput="resizeTextarea(this)" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで改行されます。"></textarea>
                  <div class="form-group">
                    <input type="file" accept=".png, .jpeg, .jpg" name="file_path">
                  </div>
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">送信</button>
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