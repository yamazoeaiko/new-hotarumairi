@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <div class="d-grid gap-4">
      <button onclick="location.href='{{route('myprofile.index')}}'" class="btn-lg btn-primary">
        プロフィール
      </button>
      <button onclick="location.href='{{route('mypage.myrequest.index')}}'" class="btn-lg btn-primary">
        依頼している案件の確認
      </button>
      <button onclick="location.href='{{route('mypage.myapply.index')}}'" class="btn-lg btn-primary">
        代行を引き受ける案件の確認
      </button>
    </div>
  </div>
</body>