function togglePasswordVisibility(fieldId) {
    const passwordInput = document.getElementById(fieldId);
    const eyeIcon = document.getElementById(`${fieldId}-eye-icon`);
    const eyeSlashIcon = document.getElementById(`${fieldId}-eye-slash-icon`);
    
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

function showPasswordValidation() {
    const tooltip = document.getElementById('passwordValidationTooltip');
    tooltip.classList.remove('hidden');
}

function hidePasswordValidation() {
    const tooltip = document.getElementById('passwordValidationTooltip');
    
    setTimeout(() => {
        if (!tooltip.matches(':hover')) {
            tooltip.classList.add('hidden');
        }
    }, 200);
}

function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthMeter = document.getElementById('passwordStrengthMeter');
    const strengthText = document.getElementById('passwordStrengthText');
    const tooltip = document.getElementById('passwordValidationTooltip');
    
    // Show strength meter when user starts typing
    if (password.length > 0) {
        const meterContainer = document.querySelector('.password-strength-meter');
        const textElement = document.getElementById('passwordStrengthText');
        meterContainer.style.display = 'block';
        textElement.style.display = 'block';
        tooltip.classList.remove('hidden');
    } else {
        const meterContainer = document.querySelector('.password-strength-meter');
        const textElement = document.getElementById('passwordStrengthText');
        meterContainer.style.display = 'none';
        textElement.style.display = 'none';
    }
    
    const hasMinLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecialChar = /[!@#$%^&*]/.test(password);
    
    document.getElementById('lengthIcon').className = `validation-icon ${hasMinLength ? 'valid' : 'invalid'}`;
    document.getElementById('lengthIcon').innerHTML = hasMinLength ? '✓' : '✕';
    
    document.getElementById('uppercaseIcon').className = `validation-icon ${hasUppercase ? 'valid' : 'invalid'}`;
    document.getElementById('uppercaseIcon').innerHTML = hasUppercase ? '✓' : '✕';
    
    document.getElementById('lowercaseIcon').className = `validation-icon ${hasLowercase ? 'valid' : 'invalid'}`;
    document.getElementById('lowercaseIcon').innerHTML = hasLowercase ? '✓' : '✕';
    
    document.getElementById('numberIcon').className = `validation-icon ${hasNumber ? 'valid' : 'invalid'}`;
    document.getElementById('numberIcon').innerHTML = hasNumber ? '✓' : '✕';
    
    document.getElementById('specialIcon').className = `validation-icon ${hasSpecialChar ? 'valid' : 'invalid'}`;
    document.getElementById('specialIcon').innerHTML = hasSpecialChar ? '✓' : '✕';
    
    let strength = 0;
    if (hasMinLength) strength += 20;
    if (hasUppercase) strength += 20;
    if (hasLowercase) strength += 20;
    if (hasNumber) strength += 20;
    if (hasSpecialChar) strength += 20;
    
    strengthMeter.style.width = `${strength}%`;
    
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

function validateName(input) {
    const errorElement = document.getElementById(`${input.id}_error`);
    const namePattern = /^[A-Za-z. ]+$/;
    
    if (input.value.length === 0) {
        errorElement.textContent = '';
    } else if (!namePattern.test(input.value)) {
        errorElement.textContent = 'Name can only contain letters, spaces, and dots (.)';
    } else {
        errorElement.textContent = '';
    }
}

// Function to show loading screen
function showLoadingScreen() {
    const loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        loadingScreen.classList.remove('hidden');
    }
}

// Function to hide loading screen
function hideLoadingScreen() {
    const loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        loadingScreen.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Hide strength meter initially
    const meterContainer = document.querySelector('.password-strength-meter');
    const textElement = document.getElementById('passwordStrengthText');
    if (meterContainer && textElement) {
        meterContainer.style.display = 'none';
        textElement.style.display = 'none';
    }
    
    const tooltip = document.getElementById('passwordValidationTooltip');
    if (tooltip) {
        tooltip.addEventListener('mouseenter', function() {});
        
        tooltip.addEventListener('mouseleave', function() {
            tooltip.classList.add('hidden');
        });
    }

    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const password = document.getElementById('password').value;
            
            const hasMinLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
            
            if (!hasMinLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecialChar) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Requirements <br> Not Met',
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
            
            const confirmPassword = document.getElementById('password_confirmation').value;
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

            const firstName = document.getElementById('first_name').value;
            const lastName = document.getElementById('last_name').value;
            const namePattern = /^[A-Za-z. ]+$/;
            
            if (!namePattern.test(firstName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid First Name',
                    text: 'First name can only contain letters, spaces, and dots (.)',
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            if (!namePattern.test(lastName)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Last Name',
                    text: 'Last name can only contain letters, spaces, and dots (.)',
                    confirmButtonColor: '#101966',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // All validations passed, show loading screen and submit form
            showLoadingScreen();
            
            setTimeout(() => {
                registerForm.submit();
            }, 100);
        });
    }

    const errorElements = document.querySelectorAll('.text-red-300');
    if (errorElements.length > 0) {
        const errorMessages = Array.from(errorElements).map(el => el.textContent.trim()).filter(msg => msg !== '');
        
        if (errorMessages.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Registration Error',
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

    const elements = document.querySelectorAll('.slide-in');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.style.animationDelay = `${index * 0.1}s`;
            el.classList.add('animate');
        }, 100);
    });
});

window.togglePasswordVisibility = togglePasswordVisibility;
window.showPasswordValidation = showPasswordValidation;
window.hidePasswordValidation = hidePasswordValidation;
window.checkPasswordStrength = checkPasswordStrength;
window.checkPasswordMatch = checkPasswordMatch;
window.validateName = validateName;
window.showLoadingScreen = showLoadingScreen;
window.hideLoadingScreen = hideLoadingScreen;
