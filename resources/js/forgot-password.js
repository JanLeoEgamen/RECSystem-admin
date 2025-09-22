document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.slide-in');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.style.animationDelay = `${index * 0.1}s`;
            el.classList.add('animate');
        }, 100);
    });
    
    const hasSuccessStatus = document.querySelector('.bg-green-500\\/20');
    if (hasSuccessStatus) {
        checkExistingTimer();
    }
});

const TIMER_DURATION = 60;
let countdownInterval = null;

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
    
    submitBtn.disabled = true;
    submitBtn.classList.remove('pulse');
    countdownContainer.classList.remove('hidden');
    
    const endTime = Date.now() + (seconds * 1000);
    localStorage.setItem('passwordResetTimer', endTime);
    
    let timeLeft = seconds;
    const totalTime = TIMER_DURATION;
    
    updateCountdownDisplay(timeLeft);
    
    countdownInterval = setInterval(() => {
        timeLeft--;
        updateCountdownDisplay(timeLeft);
        
        const progressPercent = (timeLeft / totalTime) * 100;
        progressBar.style.width = `${progressPercent}%`;
        
        if (timeLeft <= 0) {
            clearInterval(countdownInterval);
            submitBtn.disabled = false;
            submitBtn.classList.add('pulse');
            countdownContainer.classList.add('hidden');
            localStorage.removeItem('passwordResetTimer');
        }
    }, 1000);
    
    function updateCountdownDisplay(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        
        minutesElement.textContent = minutes.toString().padStart(2, '0');
        secondsElement.textContent = remainingSeconds.toString().padStart(2, '0');
    }
}

document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
    if (document.getElementById('submitBtn').disabled) {
        e.preventDefault();
        return;
    }
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
    submitBtn.classList.remove('pulse');
    
    localStorage.setItem('passwordResetRequested', Date.now());
});

window.addEventListener('load', function() {
    const hasSuccessStatus = document.querySelector('.bg-green-500\\/20');
    const recentRequest = localStorage.getItem('passwordResetRequested');
    
    if (hasSuccessStatus && recentRequest) {
        localStorage.removeItem('passwordResetRequested');
        
        setTimeout(() => {
            slideUpSuccessNotification(hasSuccessStatus);
        }, 5000);
        
        setTimeout(() => {
            startCountdown();
        }, 500);
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
