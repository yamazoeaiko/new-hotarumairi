@extends('layouts.app')

@section('content')
<div class="container card input-group p-5">
    <form method="POST" action="{{ route('password.store') }}" class="form-group">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="fw-normal">{{ __('メールアドレス') }}</label>
            <input id="email" class="block mt-1 w-full form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="fw-normal">{{ __('パスワード') }}</label>
            <input id="password" class="block mt-1 w-full form-control" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="fw-normal">{{ __('パスワード（確認用）') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full form-control" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary">
                {{ __('パスワードをリセット') }}
            </button>
        </div>
    </form>
</div>
@endsection