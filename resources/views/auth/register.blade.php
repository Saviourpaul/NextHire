<x-auth-layout title="Register - NextHire" card-width="640px">
    <h1 class="auth-title">Create your Applicant account</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-auth-field name="first_name" label="First Name" autocomplete="given-name" required autofocus />
            </div>
            <div class="col-md-6">
                <x-auth-field name="last_name" label="Last Name" autocomplete="family-name" required />
            </div>
        </div>

        <x-auth-field name="username" label="Username" autocomplete="username" required />

        <x-auth-field name="email" label="Email Address" type="email" autocomplete="email" required />

        <x-auth-field name="password" label="Password" type="password" autocomplete="new-password" required
            help-text="Use at least 8 characters with a mix of letters, numbers, and symbols." minlength="8" />

        <x-auth-field name="password_confirmation" label="Confirm Password" type="password" autocomplete="new-password"
            required help-text="Re-enter your password to confirm it." minlength="8" />
        <p class="auth-terms">
            You agree to the NextHire
            <a class="auth-link" href="javascript:void(0);">User Agreement,</a>
            <a class="auth-link" href="javascript:void(0);">Privacy Policy,</a>
            and <a class="auth-link" href="javascript:void(0);">Cookie Policy</a>.
        </p>
        <button class="auth-primary-btn" type="submit">
            Register <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </button>
        <div class="auth-footer-row justify-content-center">
            <div>Already have an account? <a href="{{ route('login') }}">Login</a></div>
        </div>
    </form>

</x-auth-layout>
