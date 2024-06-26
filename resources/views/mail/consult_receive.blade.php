<x-mail::message>
  このメールは、ほたる参りから配信されています<br>

  {{$receiverName}}さま<br>

  {{$senderName}}さまからチャットルームにメッセージが届きました。<br>
  <br>下記URLからチャットを開き、内容の確認をお願いします。<br>

  <x-mail::button :url="route('chat.room', ['room_id'=>$chatRoom])">
    ほたる参りページへ
  </x-mail::button>

  <br>引き続き、よろしくお願いいたします。


  <br>◇ほたる参りは、破格のシステム手数料で現在ご利用いただいておりますので、この機会にビジネスでのご活躍の幅を広げていただけましたら幸いです。
  <br>◇システムの不具合でご迷惑をお掛けする可能性がございます。
  <br>◇ご不明な点やお問い合せは以下からお願いいたします。
  <br>https://about.hotarumairi.com/contact/

  <br>※こちらのメールは送信専用のメールアドレスより自動送信されていますので、そのままご返信いただくことはできません。<br>

  ほたる参り をご利用いただきありがとうございます。<br>

  運営：ほたるまいり事務局
  <br>管理：一般社団法人青虫社
  <br>https://aomushi.jp/
</x-mail::message>