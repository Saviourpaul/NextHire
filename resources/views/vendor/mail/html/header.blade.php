@props(['url'])
@php
    $logo = config('mail.logo') ?: secure_asset('assets/img/logo.png');
@endphp
<tr>
<td class="header">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="brand-bar" bgcolor="#0073b1" height="6" style="background-color: #0073b1; font-size: 0; line-height: 0; mso-hide: all;">&nbsp;</td>
        </tr>
    </table>
    <a href="{{ $url }}" class="header-brand" target="_blank" rel="noopener" style="display: inline-block; text-decoration: none;">
        <img src="{{ $logo }}" class="logo" alt="{{ config('app.name') }}" width="49" height="36" style="border: 0; display: block; height: 36px; margin: 0 auto; width: auto;" />
    </a>
</td>
</tr>
