document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.slide-in');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.style.animationDelay = `${index * 0.1}s`;
            el.classList.add('animate');
        }, 100);
    });
    
    // Check if we should disable the email field and start timer
    checkExistingTimer();
    checkEmailLockState();
});

const TIMER_DURATION = 60;
let countdownInterval = null;

function checkEmailLockState() {
    const emailLocked = localStorage.getItem('passwordResetEmailLocked');
    const lockedEmail = localStorage.getItem('passwordResetLockedEmail');
    const lockTime = localStorage.getItem('passwordResetLockTime');
    
    if (emailLocked === 'true' && lockedEmail && lockTime) {
        const currentTime = Date.now();
        const lockDuration = 60 * 1000; 
        const timeElapsed = currentTime - parseInt(lockTime);
        const timeRemaining = lockDuration - timeElapsed;
        
        if (timeRemaining > 0) {
            disableEmailField(lockedEmail, timeRemaining);
        } else {
            enableEmailField();
            clearLockState();
        }
    }
}

function disableEmailField(email, duration) {
    const emailInput = document.getElementById('email');
    const submitBtn = document.getElementById('submitBtn');
    const countdownContainer = document.getElementById('countdownContainer');
    
    if (emailInput) {
        emailInput.value = email;
        emailInput.disabled = true;
        emailInput.classList.add('disabled-input');
    }
    
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.remove('pulse');
    }
    
    if (countdownContainer) {
        countdownContainer.classList.remove('hidden');
    }
    
    // Start countdown with the remaining time in seconds
    startCountdown(Math.ceil(duration / 1000));
}

function enableEmailField() {
    const emailInput = document.getElementById('email');
    const submitBtn = document.getElementById('submitBtn');
    const countdownContainer = document.getElementById('countdownContainer');
    
    if (emailInput) {
        emailInput.disabled = false;
        emailInput.classList.remove('disabled-input');
    }
    
    if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.classList.add('pulse');
    }
    
    if (countdownContainer) {
        countdownContainer.classList.add('hidden');
    }
}

function clearLockState() {
    localStorage.removeItem('passwordResetEmailLocked');
    localStorage.removeItem('passwordResetLockedEmail');
    localStorage.removeItem('passwordResetLockTime');
    localStorage.removeItem('passwordResetTimer');
}

function checkExistingTimer() {
    const endTime = localStorage.getItem('passwordResetTimer');
    if (endTime) {
        const remaining = Math.ceil((endTime - Date.now()) / 1000);
        if (remaining > 0) {
            startCountdown(remaining);
        } else {
            localStorage.removeItem('passwordResetTimer');
        }
    }
}

function startCountdown(seconds = TIMER_DURATION) {
    const submitBtn = document.getElementById('submitBtn');
    const countdownContainer = document.getElementById('countdownContainer');
    const minutesElement = document.getElementById('minutes');
    const secondsElement = document.getElementById('seconds');
    const progressBar = document.getElementById('progressBar');
    
    if (!submitBtn || !countdownContainer) return;
    
    submitBtn.disabled = true;
    submitBtn.classList.remove('pulse');
    countdownContainer.classList.remove('hidden');
    
    const endTime = Date.now() + (seconds * 1000);
    localStorage.setItem('passwordResetTimer', endTime);
    
    let timeLeft = seconds;
    const totalTime = TIMER_DURATION;
    
    updateCountdownDisplay(timeLeft);
    
    if (countdownInterval) {
        clearInterval(countdownInterval);
    }
    
    countdownInterval = setInterval(() => {
        timeLeft--;
        updateCountdownDisplay(timeLeft);
        
        const progressPercent = (timeLeft / totalTime) * 100;
        if (progressBar) {
            progressBar.style.width = `${progressPercent}%`;
        }
        
        if (timeLeft <= 0) {
            clearInterval(countdownInterval);
            enableEmailField();
            clearLockState();
        }
    }, 1000);
    
    function updateCountdownDisplay(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        
        if (minutesElement && secondsElement) {
            minutesElement.textContent = minutes.toString().padStart(2, '0');
            secondsElement.textContent = remainingSeconds.toString().padStart(2, '0');
        }
    }
}

document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const emailInput = document.getElementById('email');
    
    if (submitBtn.disabled) {
        e.preventDefault();
        return;
    }
    
    // Store email lock state
    if (emailInput) {
        localStorage.setItem('passwordResetEmailLocked', 'true');
        localStorage.setItem('passwordResetLockedEmail', emailInput.value);
        localStorage.setItem('passwordResetLockTime', Date.now());
    }
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
    submitBtn.classList.remove('pulse');
    
    localStorage.setItem('passwordResetRequested', Date.now());
});

// Handle successful form submission
window.addEventListener('load', function() {
    const hasSuccessStatus = document.querySelector('.bg-green-500\\/20');
    const recentRequest = localStorage.getItem('passwordResetRequested');
    
    if (hasSuccessStatus && recentRequest) {
        localStorage.removeItem('passwordResetRequested');
        
        // Start countdown and disable email field
        const emailInput = document.getElementById('email');
        if (emailInput) {
            disableEmailField(emailInput.value, TIMER_DURATION * 1000);
        }
        
        setTimeout(() => {
            slideUpSuccessNotification(hasSuccessStatus);
        }, 5000);
    }
});

function slideUpSuccessNotification(element) {
    if (!element) return;
    
    const elementHeight = element.offsetHeight;
    const computedStyle = window.getComputedStyle(element);
    const marginTop = parseInt(computedStyle.marginTop);
    const marginBottom = parseInt(computedStyle.marginBottom);
    const totalHeight = elementHeight + marginTop + marginBottom;
    
    element.style.height = elementHeight + 'px';
    element.style.overflow = 'hidden';
    element.style.transition = 'all 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
    element.style.transformOrigin = 'top';

    element.offsetHeight;
    
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            element.style.transform = 'translateY(-100%) scaleY(0)';
            element.style.height = '0px';
            element.style.marginTop = '0px';
            element.style.marginBottom = '0px';
            element.style.paddingTop = '0px';
            element.style.paddingBottom = '0px';
            element.style.opacity = '0.3';
        });
    });
    
    setTimeout(() => {
        if (element && element.parentNode) {
            element.parentNode.removeChild(element);
        }
    }, 1600);
}

// Clear lock state when navigating away from the page
window.addEventListener('beforeunload', function() {
    // Only clear if the form wasn't just submitted
    const recentRequest = localStorage.getItem('passwordResetRequested');
    if (!recentRequest) {
        localStorage.removeItem('passwordResetEmailLocked');
        localStorage.removeItem('passwordResetLockedEmail');
        localStorage.removeItem('passwordResetLockTime');
    }
});