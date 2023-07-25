<x-mail::message>
  ---
  このメールは、ほたる参りから配信されています
  ---
  {{$receiverName}}さま

  {{$senderName}}さまからチャットルームにメッセージが届きました。
  <br>下記URLからチャットを開き、内容の確認をお願いします。

  <x-mail::button :url="'https://laravel.hotarumairi.com/chat/list_buy'">
    ほたる参りページへ
  </x-mail::button>

  **◇メッセージ内容**
  ---
  {{$receiveMessage}}
  ---

  引き続き、よろしくお願いいたします。

  ---
  ◇ほたる参りは、破格のシステム手数料で現在ご利用いただいておりますので、この機会にビジネスでのご活躍の幅を広げていただけましたら幸いです。
  <br>◇システムの不具合でご迷惑をお掛けする可能性がございます。
  <br>◇ご不明な点やお問い合せは以下からお願いいたします。
  <br>https://about.hotarumairi.com/contact/
  ---
  ※こちらのメールは送信専用のメールアドレスより自動送信されていますので、そのままご返信いただくことはできません。

  ほたる参り をご利用いただきありがとうございます。

  運営：ほたるまいり事務局
  <br>管理：一般社団法人Kikujin
  <br>https://kikujin.or.jp/
</x-mail::message>