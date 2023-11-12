@extends('layouts.app')

@section('content')
<div class="container card input-group p-5">
    <div class="mb-4 text-sm text-gray-600">
        パスワードを忘れてしまった方はメールアドレスを教えていただければ、新しいパスワードを選択できるパスワードリセットリンクをメールでお送りします。
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="form-group">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="fw-normal">Email</label>
            <input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary">
                {{ __('パスワードをリセットする') }}
            </button>
        </div>
    </form>

    <div class="flex items-center justify-end mt-4">
        <a class="link-success" href="{{ route('login') }}">
            <u>ログイン画面に戻る</u>
        </a>
    </div>
</div>
@endsection