// Password visibility toggle functionality
function handlePasswordInput(input) {
    const toggleButton = document.getElementById('password-toggle');
    
    if (input.value.length > 0) {
        toggleButton.classList.add('show');
    } else {
        toggleButton.classList.remove('show');
        
        input.type = 'password';
        document.getElementById('eye-icon').classList.remove('hidden');
        document.getElementById('eye-slash-icon').classList.add('hidden');
    }
}

function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashIcon = document.getElementById('eye-slash-icon');
    
    if (!passwordInput || !eyeIcon || !eyeSlashIcon) return;
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeSlashIcon.classList.remove('hidden');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeSlashIcon.classList.add('hidden');
    }
}

// Initialize all functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.slide-in');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.style.animationDelay = `${index * 0.1}s`;
            el.classList.add('animate');
        }, 100);
    });

    // Show reCAPTCHA only when both email and password fields are filled
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const recaptchaWrapper = document.getElementById("recaptcha-wrapper");

    function toggleRecaptcha() {
        if (emailInput.value.trim() !== "" && passwordInput.value.trim() !== "") {
            recaptchaWrapper.classList.remove("hidden");
            recaptchaWrapper.classList.add("block");
        } else {
            recaptchaWrapper.classList.add("hidden");
            recaptchaWrapper.classList.remove("block");
        }
    }

    emailInput.addEventListener("input", toggleRecaptcha);
    passwordInput.addEventListener("input", toggleRecaptcha);

    // Show loader on login submit
    const form = document.getElementById("login-form");
    const loader = document.getElementById("loading-screen");
    const submitBtn = document.getElementById("submit-btn");

    if (form && loader && submitBtn) {
        form.addEventListener("submit", (e) => {
            const recaptchaResponse = grecaptcha.getResponse();
            
            if (!recaptchaResponse) {
                e.preventDefault();
                alert('Please complete the reCAPTCHA verification.');
                return false;
            }
            
            loader.classList.remove("hidden");
        });
    }
});