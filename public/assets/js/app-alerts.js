(function () {
    'use strict';

    const ready = (callback) => {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback, { once: true });
            return;
        }

        callback();
    };

    const getSweetAlert = () => window.Swal || window.Sweetalert2 || null;

    const escapeHtml = (value) => String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    const fallbackAlert = (options) => {
        const message = options.text || options.message || options.title || '';

        if (message) {
            window.alert(message);
        }

        return Promise.resolve({ isConfirmed: true });
    };

    const fireAlert = (options) => {
        const Swal = getSweetAlert();

        if (!Swal || typeof Swal.fire !== 'function') {
            return fallbackAlert(options);
        }

        return Swal.fire(options);
    };

    const iconFor = (value) => {
        const icon = String(value || 'info').toLowerCase();

        if (['success', 'error', 'warning', 'info', 'question'].includes(icon)) {
            return icon;
        }

        return icon === 'danger' ? 'error' : 'info';
    };

    const confirmationOptions = (element) => ({
        icon: iconFor(element.dataset.confirmIcon || 'warning'),
        title: element.dataset.confirmTitle || 'Are you sure?',
        text: element.dataset.confirmText || 'Please confirm before continuing.',
        showCancelButton: true,
        confirmButtonText: element.dataset.confirmButton || 'Continue',
        cancelButtonText: element.dataset.cancelButton || 'Cancel',
        reverseButtons: true,
        focusCancel: true,
    });

    const submitConfirmedForm = (form) => {
        form.dataset.confirmed = 'true';

        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit();
            return;
        }

        HTMLFormElement.prototype.submit.call(form);
    };

    const bindConfirmations = () => {
        document.addEventListener('submit', (event) => {
            const form = event.target;

            if (!(form instanceof HTMLFormElement) || !form.matches('[data-confirm]')) {
                return;
            }

            if (form.dataset.confirmed === 'true') {
                return;
            }

            event.preventDefault();

            fireAlert(confirmationOptions(form)).then((result) => {
                if (result.isConfirmed) {
                    submitConfirmedForm(form);
                }
            });
        });

        document.addEventListener('click', (event) => {
            const link = event.target.closest('a[data-confirm][href]');

            if (!link || link.dataset.confirmed === 'true') {
                return;
            }

            event.preventDefault();

            fireAlert(confirmationOptions(link)).then((result) => {
                if (result.isConfirmed) {
                    link.dataset.confirmed = 'true';
                    window.location.href = link.href;
                }
            });
        });
    };

    const showQueuedAlerts = async () => {
        const queuedAlerts = Array.isArray(window.NexHireAlerts?.messages)
            ? window.NexHireAlerts.messages
            : [];

        for (const alert of queuedAlerts) {
            const options = {
                icon: iconFor(alert.type || alert.icon),
                title: alert.title || 'Notice',
                confirmButtonText: alert.button || 'OK',
            };

            if (Array.isArray(alert.messages) && alert.messages.length > 0) {
                options.html = [
                    `<p class="mb-3">${escapeHtml(alert.message || 'Please review the errors below.')}</p>`,
                    '<ul class="text-start mb-0">',
                    ...alert.messages.map((message) => `<li>${escapeHtml(message)}</li>`),
                    '</ul>',
                ].join('');
            } else {
                options.text = alert.message || '';
            }

            await fireAlert(options);
        }
    };

    ready(() => {
        bindConfirmations();
        showQueuedAlerts();
    });
})();
