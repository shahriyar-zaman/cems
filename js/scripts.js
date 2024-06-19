document.addEventListener("DOMContentLoaded", function() {
    // Event listener for form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            // Add custom validation logic or any other form submission handling
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '';
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });

    // Event listener for navigation toggle on smaller screens (if applicable)
    const navToggle = document.querySelector('.nav-toggle');
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            const nav = document.querySelector('nav ul');
            if (nav) {
                nav.classList.toggle('show');
            }
        });
    }

    // Event listener for showing and hiding additional event details
    const eventDetailsLinks = document.querySelectorAll('.event-details-link');
    eventDetailsLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const details = this.nextElementSibling;
            if (details) {
                details.classList.toggle('show');
            }
        });
    });
});
