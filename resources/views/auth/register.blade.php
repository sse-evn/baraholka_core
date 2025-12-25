@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 shadow-sm">
            <h3 class="mb-3">Регистрация</h3>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Имя</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

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

                <div class="mb-3">
                    <label class="form-label">Подтверждение пароля</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</div>
@endsection
