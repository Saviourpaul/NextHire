<x-auth-layout title="Login - NextHire" card-width="600px">
    <h1 class="auth-title">Welcome! Nice to see you again</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <x-auth-field name="email" label="Email Address" type="email" autocomplete="username" required autofocus />
        <x-auth-field name="password" label="Password" type="password" autocomplete="current-password" required
            help-text="" minlength="8" />

        <label class="auth-remember">
            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
            Remember me
        </label>
        <button class="auth-primary-btn" type="submit">
            Login Now <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </button>
        <div class="auth-footer-row">
            <div>New to NextHire&nbsp; <a href="{{ route('register') }}">Signup?</a></div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">forgot Password?</a>
            @endif
        </div>
    </form>
</x-auth-layout>
