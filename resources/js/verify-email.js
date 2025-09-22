document.addEventListener('DOMContentLoaded', function() {
    const resendForm = document.getElementById('resendForm');
    const resendButton = document.getElementById('resendButton');
    const countdownContainer = document.getElementById('countdownContainer');
    const minutesElement = document.getElementById('minutes');
    const secondsElement = document.getElementById('seconds');
    const progressBar = document.getElementById('progressBar');
    const statusMessage = document.getElementById('statusMessage');
    const statusText = document.getElementById('statusText');
    const statusIcon = document.getElementById('statusIcon');
    
    let countdownInterval;
    const COUNTDOWN_TIME = 120;
    
    checkExistingCountdown();
    
    resendForm.addEventListener('submit', handleResendSubmit);
    
    async function handleResendSubmit(e) {
        e.preventDefault();
        
        resendButton.disabled = true;
        resendButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
        resendButton.classList.remove('pulse');
        
        try {
            const formAction = resendForm.getAttribute('action');
            
            const response = await fetch(formAction, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({}),
                credentials: 'same-origin'
            });
            
            if (response.ok) {
                showStatus('A new verification link has been sent to the email address you provided during registration.', 'success');
                
                resendButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Resend Verification Email';
                countdownContainer.classList.remove('hidden');
                
                const now = new Date().getTime();
                const endTime = now + (COUNTDOWN_TIME * 1000);
                localStorage.setItem('resendCooldownEnd', endTime.toString());
                
                startCountdown(endTime);
                
                // REMOVED the automatic page reload that was causing the navigation issue
            } else {
                showStatus('Failed to send verification email. Please try again.', 'error');
                resendButton.disabled = false;
                resendButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Resend Verification Email';
                resendButton.classList.add('pulse');
            }
        } catch (error) {
            console.error('Error:', error);
            showStatus('An error occurred. Please try again.', 'error');
            resendButton.disabled = false;
            resendButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Resend Verification Email';
            resendButton.classList.add('pulse');
        }
    }
    
    function showStatus(message, type) {
        statusText.textContent = message;
        statusMessage.classList.remove('hidden', 'success-message', 'error-message', 'info-message');
        
        if (type === 'success') {
            statusMessage.classList.add('success-message');
            statusIcon.classList.remove('fa-exclamation-circle');
            statusIcon.classList.add('fa-check-circle');
        } else if (type === 'error') {
            statusMessage.classList.add('error-message');
            statusIcon.classList.remove('fa-check-circle');
            statusIcon.classList.add('fa-exclamation-circle');
        } else {
            statusMessage.classList.add('info-message');
            statusIcon.classList.remove('fa-check-circle', 'fa-exclamation-circle');
            statusIcon.classList.add('fa-info-circle');
        }
        
        setTimeout(() => {
            statusMessage.classList.add('hidden');
        }, 5000);
    }
    
    function startCountdown(endTime) {
        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = Math.max(0, Math.floor((endTime - now) / 1000));
            
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            minutesElement.textContent = minutes.toString().padStart(2, '0');
            secondsElement.textContent = seconds.toString().padStart(2, '0');
            
            const progressPercent = (timeLeft / COUNTDOWN_TIME) * 100;
            progressBar.style.width = `${progressPercent}%`;
            
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                resendButton.disabled = false;
                resendButton.classList.add('pulse');
                countdownContainer.classList.add('hidden');
                localStorage.removeItem('resendCooldownEnd');
            }
        }
        
        updateCountdown();
        
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }
        
        countdownInterval = setInterval(updateCountdown, 1000);
    }
    
    function checkExistingCountdown() {
        const storedEndTime = localStorage.getItem('resendCooldownEnd');
        if (storedEndTime) {
            const endTime = parseInt(storedEndTime);
            const now = new Date().getTime();
            
            if (endTime > now) {
                resendButton.disabled = true;
                resendButton.classList.remove('pulse');
                countdownContainer.classList.remove('hidden');
                startCountdown(endTime);
            } else {
                localStorage.removeItem('resendCooldownEnd');
                resendButton.disabled = false;
                resendButton.classList.add('pulse');
                countdownContainer.classList.add('hidden');
            }
        }
    }
});