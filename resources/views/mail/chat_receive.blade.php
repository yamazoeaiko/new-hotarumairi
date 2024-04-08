<x-mail::message>
  このメールは、ほたる参りから配信されています

  {{$receiverName}}さま

  {{$senderName}}さまからチャットルームにメッセージが届きました。
  <br>下記URLからチャットを開き、内容の確認をお願いします。

  <x-mail::button :url="'https://hotarumairi.com/chat/list_buy'">
    ほたる参りページへ
  </x-mail::button>

  <br>**◇メッセージ内容**
  <br>{{$receiveMessage}}


  <br>引き続き、よろしくお願いいたします。


  <br>◇ほたる参りは、破格のシステム手数料で現在ご利用いただいておりますので、この機会にビジネスでのご活躍の幅を広げていただけましたら幸いです。
  <br>◇システムの不具合でご迷惑をお掛けする可能性がございます。
  <br>◇ご不明な点やお問い合せは以下からお願いいたします。
  <br>https://about.hotarumairi.com/contact/

  <br>※こちらのメールは送信専用のメールアドレスより自動送信されていますので、そのままご返信いただくことはできません。

  ほたる参り をご利用いただきありがとうございます。

  運営：ほたるまいり事務局
  <br>管理：一般社団法人青虫社
  <br>https://aomushi.jp/
</x-mail::message>