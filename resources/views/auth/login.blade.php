@extends('layouts.app')

@section('content')
    <h1>Login</h1>
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required />
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required />
        </div>
        <button type="submit">Login</button>
    </form>
@endsection
