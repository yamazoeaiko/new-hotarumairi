    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
      <div class="container px-5">
        <a class="navbar-brand fw-bold" href="/">Service Name</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="bi-list"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
            <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('request.index')}}">代行を依頼する</a></li>
            <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('search.index')}}">お仕事を探す</a></li>
            <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('chat.index')}}">チャット</a></li>
            <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('mypage.index')}}">マイページ</a></li>
            @guest
            <li class="nav-item"><a class="nav-link me-lg-3" href="/login">ログイン</a></li>
            @endguest
            @auth
            <li class="nav-item"><a class="nav-link me-lg-3" href="/logout">ログアウト</a></li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>