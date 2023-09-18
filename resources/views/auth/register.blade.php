@extends('layouts.app')

@section('content')

<div class="container card input-group p-5">
    <form method="POST" action="{{ route('register') }}" class="form-group">
        @csrf
        <div class="d-flex">
            <h4 class="fw-bolder my-3">新規登録画面</h4>
            <button class="btn btn-outline-success ms-auto" onclick="location.href='{{route('login')}}'">
                ログイン
            </button>
        </div>

        <!-- Name -->
        <div>
            <label for="name">お名前<span class="fs-7 text-danger">※サービス内では表示されません。本人確認として使用します。</span></label>
            <input id="name" class="block mt-1  form-control" type="text" name="name" value="{{ old('name') }}" required />
        </div>

        <div>
            <label for="name">アカウント名<span class="fs-7 text-danger">※サービス内での表示名</span></label>
            <input id="nickname" class="block mt-1 w-full form-control" type="text" name="nickname" value="{{ old('nickname') }}" required />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email">メールアドレス</label>
            <input id="email" class="block mt-1 w-full form-control" type="email" name="email" value="{{ old('email') }}" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">パスワード（8文字以上）</label>
            <input id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="new-password" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation">パスワード（確認用）</label>

            <input id="password_confirmation" class="block mt-1 w-full form-control" type="password" name="password_confirmation" required />
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary">
                新規登録
            </button>
        </div>
    </form>
</div>
@endsection