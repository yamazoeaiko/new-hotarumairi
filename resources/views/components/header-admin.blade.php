<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav" style="background-image: url('{{ asset('storage/others/hotaru_bannar5.png')}}');">
  <div class="container d-flex px-5">
    <div class="me-auto mx-2">
      <a class="navbar-brand fw-bold" href="{{route('admin.index')}}">ほたる参り</a>
    </div>

    <div class="ms-auto d-flex">
      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="bi-list"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
          <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('admin.user.list')}}">ユーザー管理</a></li>
          <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('admin.identification.offer.list')}}">本人確認証明の申請</a></li>
          <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('admin.service.list')}}">出品サービス管理</a></li>
          <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('admin.transfer.list')}}">振込申請</a></li>
          <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('admin.cancel.offer.list')}}">キャンセル申請</a></li>
          <li class="nav-item"><a class="nav-link me-lg-3" href="{{route('admin.user.chat.list')}}">チャット管理（ユーザー同士）</a></li>
          <li class="nav-item"><a class="nav-link me-lg-3">マイページ</a></li>
          @guest
          <li class="nav-item"><a class="nav-link me-lg-3" href="/login">ログイン</a></li>
          @endguest
          @auth
          <li class="nav-item"><a class="nav-link me-lg-3" href="/logout">ログアウト</a></li>
          @endauth
        </ul>
      </div>
      @auth
      <div class="nav-item ml-2">
        <a href="{{ route('admin.announcement.index') }}">
          <span class="position-relative">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
              <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
            </svg>
            <span class="position-absolute top-2 start-150 translate-middle badge rounded-pill bg-danger">
              <span class="visually-hidden">未読の通知数</span>
              {{count($announcements)}}
            </span>
          </span>
        </a>
      </div>
      @endauth
    </div>
  </div>
</nav>