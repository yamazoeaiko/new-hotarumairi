@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>
  <div class="container">
    <div class="d-grid gap-4">
      <button onclick="location.href='{{route('request.ohakamairi')}}'" class="btn-lg btn-primary">
        御墓参り代行を依頼
      </button>
      <button onclick="location.href='{{route('request.omamori')}}'" class="btn-lg">
        御守り購入代行を依頼
      </button>
      <button onclick="location.href='{{route('request.sanpai')}}'" class="btn-lg">
        参拝代行を依頼
      </button>
      <button onclick="location.href='{{route('request.others')}}'" class="btn-lg">
        その他代行を依頼
      </button>
    </div>
  </div>
</body>