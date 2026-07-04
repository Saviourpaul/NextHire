<style>
    .password-toggle-wrapper {
        position: relative;
    }

    .password-toggle-btn {
        position: absolute;
        top: 50%;
        right: 0.75rem;
        transform: translateY(-50%);
        border: 0;
        background: transparent;
        color: #647084;
        padding: 0;
        line-height: 1;
    }

    .password-toggle-btn:hover,
    .password-toggle-btn:focus {
        color: #0073b1;
        box-shadow: none;
    }
</style>
<script>
    (function() {
        const attachPasswordToggle = function(input) {
            if (!input || input.type !== 'password' || input.dataset.passwordToggleBound === '1') {
                return;
            }

            if (input.closest('.password-toggle-wrapper')) {
                return;
            }

            input.setAttribute('minlength', input.getAttribute('minlength') || '8');
            input.dataset.passwordToggleBound = '1';

            const wrapper = document.createElement('div');
            wrapper.className = 'password-toggle-wrapper';
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'password-toggle-btn';
            button.setAttribute('aria-label', 'Show password');
            button.innerHTML = '<i class="fas fa-eye"></i>';

            button.addEventListener('click', function() {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                button.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
                button.innerHTML = isHidden ? '<i class="fas fa-eye-slash"></i>' :
                    '<i class="fas fa-eye"></i>';
            });

            wrapper.appendChild(button);
        };

        const initialize = function() {
            document.querySelectorAll('input[type="password"]').forEach(attachPasswordToggle);
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initialize);
        } else {
            initialize();
        }
    })();
</script>