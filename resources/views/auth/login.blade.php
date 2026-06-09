<x-auth-layout title="Login - KofeJob" card-width="600px">
    <h1 class="auth-title">Welcome! Nice to see you again</h1>

    <x-auth-session-status class="alert alert-success auth-status mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <x-auth-field
            name="email"
            label="Email Address"
            type="email"
            autocomplete="username"
            required
            autofocus
        />

        <x-auth-field
            name="password"
            label="Password"
            type="password"
            autocomplete="current-password"
            required
        />

        <label class="auth-remember">
            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
            Remember me
        </label>

        <button class="auth-primary-btn" type="submit">
            Login Now <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </button>

       

        <div class="auth-footer-row">
            <div>New to Kofejob&nbsp; <a href="{{ route('register') }}">Signup?</a></div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">forgot Password?</a>
            @endif
        </div>
    </form>
</x-auth-layout>
