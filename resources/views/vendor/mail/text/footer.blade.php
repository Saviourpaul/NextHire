@php
    $appName = config('app.name');
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
© {{ date('Y') }} {{ $appName }}. @lang('All rights reserved.')

@foreach ($links as $label => $href)
{{ $label }}: {{ $href }}
@endforeach
