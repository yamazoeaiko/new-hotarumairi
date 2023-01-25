@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>
  <div class="container">
    <div class="row gx-5 align-items-center">
      <div class="col-12">
        <p class="col-9 mx-auto mt-4 fs-5">チャットルーム</p>
        <!-- Mashead text and app badges-->
        <div class="col-12 mb-5 text-center text-start">
          <!--ここからルーム-->
          <div>
            <div class="col-9 col-sm-12 mx-auto bg-light p-1">
              <ul>
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
                  <p class="message-text p-2 ms-2 mb-0 bg-warning">
                    {{$chat->message}}
                  </p>
                </div>
                @endforeach
                @endif
              </ul>
            </div><!-- .chat -->
            <form action="{{route('send.chat')}}" method="post">
              @csrf
              <div class="d-flex justify-content-center mt-3 row">
                <input type="hidden" name="apply_id" value="{{$apply_id}}">
                <input type="hidden" name="your_id" value="{{$you->user_id}}">
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <input type="text" name="message" class="input-group-text is-valid col-8">

                <button class="btn btn-outline-primary col-2 offset-1" type="submit">送信</button>
              </div>
            </form>
          </div><!-- .container -->
          <!--ここまでルーム-->
        </div>
      </div>
    </div>
  </div>
</body>