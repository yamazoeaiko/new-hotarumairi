@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
  <div class="container">
    <div class="d-grid gap-4">
      <button onclick="location.href='{{route('request.ohakamairi')}}'" class="btn-lg btn-outline-primary">
        お墓のお掃除・お参り代行を依頼
      </button>
      <button onclick="location.href='{{route('request.omamori')}}'" class="btn-lg btn-outline-primary">
        お守・お札・御朱印購入代行を依頼
      </button>
      <button onclick="location.href='{{route('request.sanpai')}}'" class="btn-lg btn-outline-primary">
        神社仏閣参拝・祈祷代行を依頼
      </button>
      <button onclick="location.href='{{route('request.others')}}'" class="btn-lg btn-outline-primary">
        その他お参り代行をカスタマイズ依頼
      </button>
    </div>
  </div>
</body>