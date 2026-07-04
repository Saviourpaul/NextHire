<x-auth-layout title="Forgot Password - NextHire" card-width="600px">
    <h1 class="auth-title">Forgot Your Password?</h1>
    <p class="auth-description">
        No problem. Just let us know your email address and we will email you a password reset link.
    </p>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <x-auth-field name="email" label="Email Address" type="email" autocomplete="username" required autofocus />

        <button class="auth-primary-btn" type="submit">
            Email Password Reset Link <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </button>
      
        <div class="auth-footer-row">
            <div>Remembered your password?&nbsp; <a href="{{ route('login') }}">Login</a></div>
    </form>
</x-auth-layout>
