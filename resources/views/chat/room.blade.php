@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <div class="row gx-5 align-items-center">
      <div class="col-12">
        <button class="btn-outline-primary" onClick="location.href='{{route('chat.list')}}'">戻る</button>
        <p class="col-9 mx-auto mt-4 fs-5 fw-bolder">{{ $theother->nickname }}</p>
        <!--hotaru_requestの修正・承認へ-->
        @if($hotaru_request_id !== null)
        <button onClick="location.href='{{route('mypage.myrequest.member_detail', ['request_id'=>$hotaru_request_id, 
         'user_id' => $theother->id,
         'apply_id' => $chat_room->apply_id])}}'" class="btn btn-primary mb-2">
         【代行依頼】に関して<br>
          依頼内容の修正・正式な依頼の承認・否認を行う
        </button>
        @endif
        <!--serviceの修正・承認へ-->
        @if($fix_id !== null)
        <button onClick="location.href='{{route('service.fixed', ['fix_id'=>$fix_id])}}'" class="btn btn-primary mb-2">
          【出品サービス】に関して<br>
          依頼内容の修正・正式な依頼の承認・否認を行う
        </button>
        @endif
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
          @if($chat->from_user == $user_id)flex-row-reverse @else flex-row @endif">
                  <p class="fs-xs">{{$chat->nickname}}</p>
                  <div>
                    <img src="{{ asset($chat->img_url) }}" alt="" class="message-icon rounded-circle text-white fs-3">
                  </div>
                  @if($chat->message !== null)
                  <p class="message-text p-2 m-2 mb-0 text-start @if($chat->from_user == $user_id) from-user-bg @else to-user-bg @endif" style="word-wrap: break-word; max-width: 80%;">
                    {!! nl2br(e($chat->message)) !!}
                  </p>
                  @endif
                  @if($chat->image !== null)
                  <p class="message-text p-2 m-2 mb-0 text-start @if($chat->from_user == $user_id) from-user-bg @else to-user-bg @endif" style="word-wrap: break-word; max-width: 80%;">
                    <a href="{{ asset($chat->image)}}" class="fc-blue fw-bolder">添付ファイルがあります</a>
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
                <input type="hidden" name="theother_id" value="{{$theother->user_id}}">
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <div class="col-6" style="padding-right: 0;">
                  <div class="input-group h-100">
                    <textarea name="message" class="text-start input-group-text is-valid" style="resize: none; height: 70px; overflow-y: auto; padding: 10px; width: 100%;" onkeydown="if(event.keyCode == 13 && !event.shiftKey){event.preventDefault(); this.form.submit();}" oninput="this.style.height = '70px'; this.style.height = (this.scrollHeight + 10) + 'px';" placeholder="Enterで送信。Shift+Enterで改行"></textarea>
                    <div class="form-group">
                      <input type="file" name="image">
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
</body>