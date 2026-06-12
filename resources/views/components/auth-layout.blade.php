@props([
    'title' => 'NextHire',
    'cardWidth' => '600px',
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ $title }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        :root {
            --auth-primary: #0073b1;
            --auth-ink: #07072f;
            --auth-muted: #647084;
            --auth-border: #dde2ec;
        }

        body.auth-page {
            min-height: 100vh;
            margin: 0;
            color: var(--auth-ink);
            background:
                linear-gradient(rgba(255, 255, 255, 0.88), rgba(255, 255, 255, 0.88)),
                url("{{ asset('assets/img/login-bg.png') }}") center / cover no-repeat fixed;
            font-family: Arial, Helvetica, sans-serif;
        }

        .auth-screen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .auth-card {
            width: min(100%, {{ $cardWidth }});
            padding: 36px;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 28px;
            box-shadow: 0 20px 45px rgba(7, 7, 47, 0.08);
        }

        .auth-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }

        .auth-logo img {
            max-width: 190px;
            height: auto;
        }

        .auth-title {
            margin: 0 0 28px;
            color: #000;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.25;
            text-align: center;
        }

        .auth-subtitle {
            margin: -14px 0 24px;
            color: var(--auth-muted);
            font-size: 15px;
            line-height: 1.55;
            text-align: center;
        }

        .auth-field {
            margin-bottom: 24px;
        }

        .auth-label {
            display: block;
            margin-bottom: 10px;
            color: var(--auth-ink);
            font-size: 16px;
            font-weight: 700;
        }

        .auth-required {
            color: var(--auth-primary);
        }

        .auth-control {
            min-height: 50px;
            border-color: var(--auth-border);
            border-radius: 6px;
            color: var(--auth-ink);
            font-size: 16px;
        }

        .auth-control:focus {
            border-color: var(--auth-primary);
            box-shadow: 0 0 0 0.2rem rgba(240, 80, 35, 0.14);
        }

        .auth-primary-btn {
            display: inline-flex;
            width: 100%;
            min-height: 52px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            border-radius: 6px;
            background: var(--auth-primary);
            color: #fff;
            font-size: 18px;
            font-weight: 700;
        }

        .auth-primary-btn:hover,
        .auth-primary-btn:focus {
            background: #db4218;
            color: #fff;
        }

        .auth-divider {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 26px;
            margin: 36px 0 28px;
            color: #667085;
            font-size: 18px;
            font-weight: 700;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: "";
            height: 1px;
            background: #d7dce5;
        }

        .auth-social-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .auth-social-btn {
            display: inline-flex;
            min-height: 46px;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border: 1px solid #cbd4e4;
            border-radius: 7px;
            background: #fff;
            color: #667085;
            font-size: 18px;
            font-weight: 500;
            text-decoration: none;
        }

        .auth-social-btn:hover,
        .auth-social-btn:focus {
            border-color: var(--auth-primary);
            color: var(--auth-ink);
            text-decoration: none;
        }

        .auth-social-btn img,
        .auth-social-btn i {
            width: 22px;
            height: 22px;
            object-fit: contain;
            font-size: 22px;
        }

        .auth-footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-top: 38px;
            color: var(--auth-ink);
            font-size: 18px;
            font-weight: 700;
        }

        .auth-footer-row a,
        .auth-link {
            color: var(--auth-primary);
            text-decoration: none;
        }

        .auth-footer-row a:hover,
        .auth-link:hover {
            color: #db4218;
            text-decoration: none;
        }

        .auth-tabs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .auth-tab {
            min-height: 44px;
            border: 1px solid var(--auth-border);
            border-radius: 7px;
            background: #fff;
            color: var(--auth-ink);
            font-weight: 700;
        }

        .auth-tab.active {
            border-color: var(--auth-primary);
            background: var(--auth-primary);
            color: #fff;
        }

        .auth-terms {
            margin: -4px 0 22px;
            color: var(--auth-muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .auth-status {
            border-radius: 8px;
            font-weight: 600;
        }

        .auth-remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: -8px 0 22px;
            color: var(--auth-muted);
            font-size: 15px;
            font-weight: 600;
        }

        @media (max-width: 767.98px) {
            .auth-card {
                width: calc(100% - 8px);
                padding: 28px 20px;
                border-radius: 22px;
            }

            .auth-social-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .auth-footer-row {
                flex-direction: column;
                align-items: center;
                text-align: center;
                font-size: 16px;
            }
        }
    </style>
</head>
<body class="auth-page">
    <main class="auth-screen">
        <section class="auth-card">
            <a class="auth-logo" href="{{ url('/') }}" aria-label="NextHire home">
                <img src="{{ asset('assets/img/logo.png') }}" alt="NextHire">
            </a>

            {{ $slot }}
        </section>
    </main>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
