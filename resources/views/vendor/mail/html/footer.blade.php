@php
    $appName = config('app.name');
    $logo = config('mail.logo') ?: secure_asset('assets/img/logo.png');

    $links = [];
    if ($support = config('mail.footer.support_url')) {
        $links[__('Support')] = Str::startsWith($support, 'http') ? $support : secure_url($support);
    }
    if ($privacy = config('mail.footer.privacy_url')) {
        $links[__('Privacy Policy')] = Str::startsWith($privacy, 'http') ? $privacy : secure_url($privacy);
    }
    if ($terms = config('mail.footer.terms_url')) {
        $links[__('Terms')] = Str::startsWith($terms, 'http') ? $terms : secure_url($terms);
    }
    if ($unsub = config('mail.footer.unsubscribe_url')) {
        $links[__('Unsubscribe')] = Str::startsWith($unsub, 'http') ? $unsub : secure_url($unsub);
    }
@endphp
<tr>
<td>
    <table class="footer" align="center" width="600" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td class="footer-cell" align="center">
                <a href="{{ secure_url('/') }}" class="footer-logo" target="_blank" rel="noopener">
                    <img src="{{ $logo }}" alt="{{ $appName }}" width="30" height="22" style="border: 0; display: inline-block; height: 22px; width: auto;" />
                </a>
                @if (count($links))
                <p class="footer-links">
                    @foreach ($links as $label => $href)
                        @if (!$loop->first)&nbsp;&bull;&nbsp;@endif
                        <a href="{{ $href }}" target="_blank" rel="noopener">{{ $label }}</a>
                    @endforeach
                </p>
                @endif
                <p class="footer-copy">
                    &copy; {{ date('Y') }} {{ $appName }}. {{ __('All rights reserved.') }}
                </p>
                <p class="footer-muted">
                    {{ __('You are receiving this email because you have an account with :app.', ['app' => $appName]) }}
                </p>
            </td>
        </tr>
    </table>
</td>
</tr>
