document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const passwordToggle = document.getElementById('password-toggle');
    const confirmPasswordToggle = document.getElementById('confirm-password-toggle');
    const form = document.getElementById("reset-password-form");
    const loader = document.getElementById("loading-screen");
    const recaptchaWrapper = document.getElementById("recaptcha-wrapper");

    // Password visibility toggle for password field
    if (passwordInput && passwordToggle) {
        const eyeIcon = passwordToggle.querySelector('#password-eye-icon');
        const eyeSlashIcon = passwordToggle.querySelector('#password-eye-slash-icon');
        
        // Show/hide toggle button only if input has value
        passwordInput.addEventListener('input', (e) => {
            if (e.target.value.trim().length > 0) {
                passwordToggle.classList.add('show');
            } else {
                passwordToggle.classList.remove('show');
                passwordInput.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            }
            checkPasswordStrength();
        });

        // Toggle visibility on button click
        passwordToggle.addEventListener('click', (e) => {
            e.preventDefault();
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            }
        });
    }

    // Password visibility toggle for confirm password field
    if (confirmPasswordInput && confirmPasswordToggle) {
        const eyeIcon = confirmPasswordToggle.querySelector('#confirm-password-eye-icon');
        const eyeSlashIcon = confirmPasswordToggle.querySelector('#confirm-password-eye-slash-icon');
        
        // Show/hide toggle button only if input has value
        confirmPasswordInput.addEventListener('input', (e) => {
            if (e.target.value.trim().length > 0) {
                confirmPasswordToggle.classList.add('show');
                checkPasswordMatch();
            } else {
                confirmPasswordToggle.classList.remove('show');
                confirmPasswordInput.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
                checkPasswordMatch();
            }
        });

        // Toggle visibility on button click
        confirmPasswordToggle.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            } else {
                confirmPasswordInput.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            }
        });
    }

    // Password visibility toggle for current password field
    const currentPasswordInput = document.getElementById('current_password');
    const currentPasswordToggle = document.getElementById('current-password-toggle');

    if (currentPasswordInput && currentPasswordToggle) {
        const eyeIcon = currentPasswordToggle.querySelector('#current-password-eye-icon');
        const eyeSlashIcon = currentPasswordToggle.querySelector('#current-password-eye-slash-icon');
        
        // Show/hide toggle button only if input has value
        currentPasswordInput.addEventListener('input', (e) => {
            if (e.target.value.trim().length > 0) {
                currentPasswordToggle.classList.add('show');
            } else {
                currentPasswordToggle.classList.remove('show');
                currentPasswordInput.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            }
        });

        // Toggle visibility on button click
        currentPasswordToggle.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPasswordInput.type === 'password') {
                currentPasswordInput.type = 'text';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            } else {
                currentPasswordInput.type = 'password';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
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
        if (passwordInput.value.trim() !== "" && confirmPasswordInput.value.trim() !== "") {
            recaptchaWrapper.classList.remove("hidden");
            recaptchaWrapper.classList.add("block");
        } else {
            recaptchaWrapper.classList.add("hidden");
            recaptchaWrapper.classList.remove("block");
        }
    }

    if (passwordInput && confirmPasswordInput && recaptchaWrapper) {
        passwordInput.addEventListener("input", toggleRecaptcha);
        confirmPasswordInput.addEventListener("input", toggleRecaptcha);
    }

    // --- Form validation and submission ---
    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            // Password validation
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            
            if (!hasMinLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecialChar) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Requirements Not Met',
                    html: `
                        <div class="text-left">
                            <p class="mb-2">Please make sure your password meets all the requirements:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li class="${hasMinLength ? 'text-green-600' : 'text-red-600'}">Minimum 8 characters</li>
                                <li class="${hasUppercase ? 'text-green-600' : 'text-red-600'}">At least one uppercase letter (A-Z)</li>
                                <li class="${hasLowercase ? 'text-green-600' : 'text-red-600'}">At least one lowercase letter (a-z)</li>
                                <li class="${hasNumber ? 'text-green-600' : 'text-red-600'}">At least one number (0-9)</li>
                                <li class="${hasSpecialChar ? 'text-green-600' : 'text-red-600'}">At least one special character (!@#$%^&*)</li>
                            </ul>
                        </div>
                    `,
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'OK, I\'ll fix it'
                });
                return;
            }
            
            // Password match validation
            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords Do Not Match',
                    text: 'Please make sure your passwords match before submitting.',
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // reCAPTCHA validation
            if (typeof grecaptcha !== 'undefined') {
                const recaptchaResponse = grecaptcha.getResponse();
                if (!recaptchaResponse) {
                    Swal.fire({
                        icon: 'error',
                        title: 'reCAPTCHA Required',
                        text: 'Please complete the reCAPTCHA verification.',
                        confirmButtonColor: '#101966',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }

            // All validations passed, show loading screen
            if (loader) {
                loader.classList.remove("hidden");
            }

            try {
                // Create FormData from the form
                const formData = new FormData(form);
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Submit the form via AJAX
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (loader) {
                    loader.classList.add("hidden");
                }

                if (response.ok) {
                    // Check if it's a redirect response (successful password reset)
                    if (response.redirected || response.url.includes('/login')) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Password Reset Successful!',
                            html: `
                                <div class="text-center">
                                    <p class="mb-4 text-lg">Your password has been successfully reset!</p>
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-center justify-center mb-2">
                                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-green-800 font-medium">Security Enhanced</span>
                                        </div>
                                        <p class="text-green-700 text-sm">
                                            Your account security has been updated. Please log in with your new password.
                                        </p>
                                    </div>
                                    <p class="text-gray-600">You will be redirected to the login page.</p>
                                </div>
                            `,
                            confirmButtonColor: '#101966',
                            confirmButtonText: 'Continue to Login',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                        
                        // Redirect to login page
                        window.location.href = '/login';
                        return;
                    }

                    // If we get here, check the response for JSON
                    const result = await response.json();
                    
                    if (result.success) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Password Reset Successful!',
                            html: `
                                <div class="text-center">
                                    <p class="mb-4 text-lg">Your password has been successfully reset!</p>
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-center justify-center mb-2">
                                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-green-800 font-medium">Security Enhanced</span>
                                        </div>
                                        <p class="text-green-700 text-sm">
                                            Your account security has been updated. Please log in with your new password.
                                        </p>
                                    </div>
                                    <p class="text-gray-600">You will be redirected to the login page.</p>
                                </div>
                            `,
                            confirmButtonColor: '#101966',
                            confirmButtonText: 'Continue to Login',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                        
                        if (result.redirect) {
                            window.location.href = result.redirect;
                        } else {
                            window.location.href = '/login';
                        }
                    } else {
                        // Handle server-side validation errors
                        Swal.fire({
                            icon: 'error',
                            title: 'Password Reset Failed',
                            text: result.status || 'An error occurred while resetting your password. Please try again.',
                            confirmButtonColor: '#101966',
                            confirmButtonText: 'Try Again'
                        });
                    }
                } else {
                    // Handle HTTP errors
                    const text = await response.text();
                    const doc = new DOMParser().parseFromString(text, 'text/html');
                    const errorMessages = doc.querySelectorAll('.error-message');
                    
                    if (errorMessages.length > 0) {
                        const errors = Array.from(errorMessages).map(el => el.textContent.trim());
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Password Reset Failed',
                            html: `
                                <div class="text-left">
                                    <p class="mb-2">Please fix the following issues:</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        ${errors.map(error => `<li class="text-red-600">${error}</li>`).join('')}
                                    </ul>
                                </div>
                            `,
                            confirmButtonColor: '#101966',
                            confirmButtonText: 'Try Again'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Password Reset Failed',
                            text: 'An error occurred while resetting your password. Please try again.',
                            confirmButtonColor: '#101966',
                            confirmButtonText: 'Try Again'
                        });
                    }
                }
            } catch (error) {
                if (loader) {
                    loader.classList.add("hidden");
                }
                
                console.error('Password reset error:', error);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Error',
                    html: `
                        <div class="text-center">
                            <p class="mb-4">Unable to connect to the server. Please check your internet connection and try again.</p>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="text-red-800 font-medium">Network Issue</span>
                                </div>
                                <p class="text-red-700 text-sm">If the problem persists, please contact support.</p>
                            </div>
                        </div>
                    `,
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'Try Again'
                });
            }
        });
    }

    // Hide strength meter initially
    const meterContainer = document.querySelector('.password-strength-meter');
    const textElement = document.getElementById('passwordStrengthText');
    if (meterContainer && textElement) {
        meterContainer.style.display = 'none';
        textElement.style.display = 'none';
    }
    
    // Tooltip hover behavior
    const tooltip = document.getElementById('passwordValidationTooltip');
    if (tooltip) {
        tooltip.addEventListener('mouseenter', function() {});
        
        tooltip.addEventListener('mouseleave', function() {
            const password = document.getElementById('password').value;
            if (password.length === 0) {
                tooltip.classList.add('hidden');
            }
        });
    }

    // Show existing errors with SweetAlert
    const errorElements = document.querySelectorAll('.error-message');
    if (errorElements.length > 0) {
        const errorMessages = Array.from(errorElements).map(el => el.textContent.trim()).filter(msg => msg !== '');
        
        if (errorMessages.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Password Reset Error',
                html: `
                    <div class="text-left">
                        <p class="mb-2">Please fix the following errors:</p>
                        <ul class="list-disc pl-5 space-y-1">
                            ${errorMessages.map(msg => `<li class="text-red-600">${msg}</li>`).join('')}
                        </ul>
                    </div>
                `,
                confirmButtonColor: '#101966',
                confirmButtonText: 'OK'
            });
        }
    }
});

function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthMeter = document.getElementById('passwordStrengthMeter');
    const strengthText = document.getElementById('passwordStrengthText');
    const tooltip = document.getElementById('passwordValidationTooltip');
    
    // Show tooltip and strength meter when user starts typing
    if (password.length > 0) {
        tooltip.classList.remove('hidden');
        const meterContainer = document.querySelector('.password-strength-meter');
        meterContainer.style.display = 'block';
        strengthText.style.display = 'block';
    } else {
        tooltip.classList.add('hidden');
        const meterContainer = document.querySelector('.password-strength-meter');
        meterContainer.style.display = 'none';
        strengthText.style.display = 'none';
    }
    
    // Validation checks
    const hasMinLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecialChar = /[!@#$%^&*]/.test(password);
    
    // Update validation icons
    updateValidationIcon('lengthIcon', hasMinLength);
    updateValidationIcon('uppercaseIcon', hasUppercase);
    updateValidationIcon('lowercaseIcon', hasLowercase);
    updateValidationIcon('numberIcon', hasNumber);
    updateValidationIcon('specialIcon', hasSpecialChar);
    
    // Calculate strength
    let strength = 0;
    if (hasMinLength) strength += 20;
    if (hasUppercase) strength += 20;
    if (hasLowercase) strength += 20;
    if (hasNumber) strength += 20;
    if (hasSpecialChar) strength += 20;
    
    strengthMeter.style.width = `${strength}%`;
    
    // Update strength display
    if (password.length === 0) {
        strengthText.textContent = '';
        strengthMeter.style.backgroundColor = 'transparent';
    } else if (strength < 60) {
        strengthText.textContent = 'Weak password';
        strengthText.className = 'password-strength-text text-red-400';
        strengthMeter.style.backgroundColor = '#f56565';
    } else if (strength < 100) {
        strengthText.textContent = 'Medium password';
        strengthText.className = 'password-strength-text text-yellow-400';
        strengthMeter.style.backgroundColor = '#ecc94b';
    } else {
        strengthText.textContent = 'Strong password';
        strengthText.className = 'password-strength-text text-green-400';
        strengthMeter.style.backgroundColor = '#48bb78';
    }
    
    // Also check password match when password changes
    checkPasswordMatch();
}

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const matchText = document.getElementById('passwordMatchText');
    
    if (confirmPassword.length === 0) {
        matchText.textContent = '';
        matchText.className = 'text-sm mt-1 h-5';
    } else if (password !== confirmPassword) {
        matchText.textContent = 'Passwords do not match';
        matchText.className = 'text-sm mt-1 h-5 text-red-400';
    } else {
        matchText.textContent = 'Passwords match';
        matchText.className = 'text-sm mt-1 h-5 text-green-400';
    }
}

function updateValidationIcon(iconId, isValid) {
    const icon = document.getElementById(iconId);
    icon.className = `validation-icon ${isValid ? 'valid' : 'invalid'}`;
    icon.innerHTML = isValid ? '✓' : '✕';
}

function showPasswordValidation() {
    const tooltip = document.getElementById('passwordValidationTooltip');
    const password = document.getElementById('password').value;
    
    if (password.length > 0) {
        tooltip.classList.remove('hidden');
    }
}

function hidePasswordValidation() {
    const tooltip = document.getElementById('passwordValidationTooltip');
    const password = document.getElementById('password').value;
    
    // Only hide if password is empty
    if (password.length === 0) {
        setTimeout(() => {
            if (!tooltip.matches(':hover')) {
                tooltip.classList.add('hidden');
            }
        }, 300);
    }
}

function showLoadingScreen() {
    const loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        loadingScreen.classList.remove('hidden');
    }
}

function hideLoadingScreen() {
    const loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        loadingScreen.classList.add('hidden');
    }
}

// Make functions globally available
window.showPasswordValidation = showPasswordValidation;
window.hidePasswordValidation = hidePasswordValidation;
window.checkPasswordStrength = checkPasswordStrength;
window.checkPasswordMatch = checkPasswordMatch;
window.showLoadingScreen = showLoadingScreen;
window.hideLoadingScreen = hideLoadingScreen;   