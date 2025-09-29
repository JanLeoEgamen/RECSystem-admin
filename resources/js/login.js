// login.js
document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('password-toggle');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashIcon = document.getElementById('eye-slash-icon');
    const emailInput = document.getElementById("email");
    const recaptchaWrapper = document.getElementById("recaptcha-wrapper");
    const form = document.getElementById("login-form");
    const loader = document.getElementById("loading-screen");

    // --- Password visibility toggle ---
    if (passwordInput && toggleButton && eyeIcon && eyeSlashIcon) {
        // ensure initial state: toggle hidden
        toggleButton.classList.remove('show');
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');

        // show/hide toggle button only if input has value
        passwordInput.addEventListener('input', (e) => {
            if (e.target.value.trim().length > 0) {
                toggleButton.classList.add('show');
            } else {
                toggleButton.classList.remove('show');
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });

        // toggle visibility on button click
        toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        });
    }

    // --- Slide-in animations ---
    const elements = document.querySelectorAll('.slide-in');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.style.animationDelay = `${index * 0.1}s`;
            el.classList.add('animate');
        }, 100);
    });

    // --- reCAPTCHA toggle ---
    function toggleRecaptcha() {
        if (emailInput.value.trim() !== "" && passwordInput.value.trim() !== "") {
            recaptchaWrapper.classList.remove("hidden");
            recaptchaWrapper.classList.add("block");
        } else {
            recaptchaWrapper.classList.add("hidden");
            recaptchaWrapper.classList.remove("block");
        }
    }

    if (emailInput && passwordInput && recaptchaWrapper) {
        emailInput.addEventListener("input", toggleRecaptcha);
        passwordInput.addEventListener("input", toggleRecaptcha);
    }

    // --- Loader on submit ---
    if (form && loader) {
        form.addEventListener("submit", (e) => {
            // if reCAPTCHA is used
            if (typeof grecaptcha !== 'undefined') {
                const recaptchaResponse = grecaptcha.getResponse();
                if (!recaptchaResponse) {
                    e.preventDefault();
                    alert('Please complete the reCAPTCHA verification.');
                    return false;
                }
            }
            loader.classList.remove("hidden");
        });
    }
});