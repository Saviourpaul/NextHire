  document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.on-board');
            const progressItems = document.querySelectorAll('#progressbar li');
            const totalSteps = steps.length;
            let currentStep = 0;

            function showStep(index) {
                steps.forEach((step, i) => {
                    step.style.display = (i === index) ? 'block' : 'none';
                });
                progressItems.forEach((item, i) => {
                    item.classList.toggle('active', i <= index);
                });
                currentStep = index;
            }

            document.querySelectorAll('.next_btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (currentStep < totalSteps - 1) {
                        showStep(currentStep + 1);
                    }
                });
            });

            document.querySelectorAll('.prev_btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const step = parseInt(btn.getAttribute('data-step'));
                    if (step > 1) {
                        showStep(step - 2);
                    }
                });
            });
        });