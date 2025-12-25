@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 shadow-sm">
            <h3 class="mb-3">Вход</h3>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                    @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Войти</button>
            </form>
        </div>
    </div>
</div>
@endsection
