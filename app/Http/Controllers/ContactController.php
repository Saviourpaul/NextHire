<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        return redirect()
            ->route('contact')
            ->with('success', 'Thank you for contacting NextHire. Our team will respond within one to two business days.');
    }
}
