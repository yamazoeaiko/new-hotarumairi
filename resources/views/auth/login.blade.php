@component('components.app')
@endcomponent
@component('components.header')
@endcomponent

<body>
    <div class="container card input-group ">

        <!-- Session Status -->
        <div class="mb-4" :status="session('status')">

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h4 class="m-2">ログイン画面</h4>

                <!-- Email Address -->
                <div>
                    <label for="email">Email</label>
                    <input id="email" class="block mt-1 w-full input-group" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password">パスワード（8文字以上）</label>

                    <input id="password" class="block mt-1 w-full input-group" type="password" name="password" required autocomplete="current-password" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">ログイン情報を保存する</span>
                    </label>
                </div>

                <div class="flex  mt-4">
                    @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        パスワードが分からない方はこちら
                    </a>
                    @endif

                    <button class="offset-4 btn btn-primary">
                        ログイン
                    </button>
                </div>
            </form>
            <button onClick="location.href='{{route('register')}}'" class="btn btn-outline-success">登録がまだの方は新規登録画面へ</button>
            </class>
</body>