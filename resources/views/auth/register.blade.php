@component('components.app')
@endcomponent
@component('components.header_wide')
@endcomponent

<body>

    <div class="container card input-group">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h4 class="m-2">新規登録画面</h4>

            <!-- Name -->
            <div>
                <label for="name">お名前</label>
                <input id="name" class="block mt-1 w-full input-group-text" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email">メールアドレス</label>
                <input id="email" class="block mt-1 w-full input-group-text" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password">パスワード（8文字以上）</label>
                <input id="password" class="block mt-1 w-full input-group-text" type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation">パスワード（確認用）</label>

                <input id="password_confirmation" class="block mt-1 w-full input-group-text" type="password" name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="offset-1 btn btn-primary">
                    新規登録
                </button>
            </div>
        </form>
        <a class="text-sm text-gray-600 hover:text-white-900 focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-indigo-500" href="{{ route('login') }}">
            新規登録がお済みの方はログイン画面へ
        </a>
    </div>
</body>