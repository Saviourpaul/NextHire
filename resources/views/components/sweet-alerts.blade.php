@php
    $flashTypes = ['success', 'error', 'warning', 'info'];

    $alerts = collect($flashTypes)
        ->map(fn ($type) => session()->has($type) ? [
            'type' => $type,
            'title' => match ($type) {
                'success' => 'Success',
                'error' => 'Something went wrong',
                'warning' => 'Please check',
                default => 'Notice',
            },
            'message' => session($type),
        ] : null)
        ->filter()
        ->values();

    if (session()->has('status')) {
        $statusMessage = session('status');

        $alerts->push([
            'type' => str_contains(strtolower((string) $statusMessage), 'suspend') ? 'warning' : 'success',
            'title' => 'Notice',
            'message' => match ($statusMessage) {
                'profile-updated' => 'Profile updated successfully.',
                'password-updated' => 'Password updated successfully.',
                default => $statusMessage,
            },
        ]);
    }

    $validationMessages = isset($errors)
        ? collect($errors->getBags())
            ->flatMap(fn ($bag) => $bag->all())
            ->unique()
            ->values()
        : collect();

    if ($validationMessages->isNotEmpty()) {
        $alerts->push([
            'type' => 'error',
            'title' => 'Please review your input',
            'message' => 'Some fields need your attention.',
            'messages' => $validationMessages,
        ]);
    }
@endphp

<script>
    window.NexHireAlerts = {
        messages: @json($alerts->values()),
    };
</script>
