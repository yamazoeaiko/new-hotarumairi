@extends('layouts.app')

@section('content')
<div class="container card input-group p-5">
    <form method="POST" action="{{ route('login') }}" class="form-group">
        @csrf
        <div class="d-flex">
            <h6 class="my-3 fw-bolder">ログイン画面</h6>
            <button class=" btn btn-outline-primary ms-auto" onclick="location.href='{{route('register')}}'">
                新規登録
            </button>
        </div>


        <!-- Email Address -->
        <div>
            <label for="email" class="fw-normal">Email</label>
            <input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">パスワード（8文字以上）</label>

            <input id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="current-password" />
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
            <a class="link-success" href="{{ route('password.request') }}">
                <u>パスワードが分からない方はこちら</u>
            </a>
            @endif

            <button class="offset-4 btn btn-primary">
                ログイン
            </button>
        </div>
    </form>
</div>
@endsection