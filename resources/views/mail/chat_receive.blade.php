<x-mail::message>
  -----------------------------------------
  このメールは、ほたる参りから配信されています
  -----------------------------------------
  {{$notifiable->nickname}}さま

  {{$senderName}}さまからチャットルームにメッセージが届きました。
  下記URLからチャットを開き、内容の確認をお願いします。

  <x-mail::button :url="'https://hotarumairi.com'">
    ほたる参りページへ
  </x-mail::button>

  ◇メッセージ内容
  ---------------------
  {{$receiveMessage}}
  ---------------------

  引き続き、よろしくお願いいたします。

  ------------------------------------------------------------------------
  ◇ほたる参りは、破格のシステム手数料で現在ご利用いただいておりますので、この機会にビジネスでのご活躍の幅を広げていただけましたら幸いです。
  ◇システムの不具合でご迷惑をお掛けする可能性がございます。
  ◇ご不明な点やお問い合せは以下からお願いいたします。
  https://about.hotarumairi.com/contact/
  ------------------------------------------------------------------------
  ※こちらのメールは送信専用のメールアドレスより自動送信されていますので、そのままご返信いただくことはできません。

  ほたる参り をご利用いただきありがとうございます。

  運営：ほたるまいり事務局
  管理：一般社団法人Kikujin
  https://kikujin.or.jp/
</x-mail::message>