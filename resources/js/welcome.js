document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.classList.toggle('dark', savedTheme === 'dark');

    const radioWaves = document.querySelectorAll('.radio-wave');
    const heroSection = document.getElementById('hero');
    
    const LOADING_DURATION = 2000;
    
    function checkRadioWaveVisibility() {
        const heroRect = heroSection.getBoundingClientRect();
        const isHeroVisible = heroRect.bottom > 0 && heroRect.top < window.innerHeight;
        
        radioWaves.forEach(wave => {
            wave.classList.toggle('hidden', !isHeroVisible);
        });
    }
    
    window.addEventListener('scroll', checkRadioWaveVisibility);
    checkRadioWaveVisibility();

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('active');

                    if (entry.target.classList.contains('feature-card')) {
                        entry.target.classList.add('animate-in');
                    }

                    if (entry.target.classList.contains('testimonial-card')) {
                        entry.target.classList.add('animate-in');
                    }
                }, index * 100);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => {
        observer.observe(el);
    });

    document.querySelectorAll('.feature-card').forEach((el, index) => {
        setTimeout(() => observer.observe(el), index * 50);
    });

    document.querySelectorAll('.testimonial-card').forEach((el, index) => {
        setTimeout(() => observer.observe(el), index * 100);
    });

    if (window.innerWidth <= 768) {
        document.querySelectorAll('.floating').forEach(el => {
            el.classList.remove('floating');
        });
    }

    const loadingScreen = document.getElementById('loading-screen');
    
    function showLoadingScreen(e) {
        if (e && e.preventDefault) {
            e.preventDefault();
        }
        
        if (loadingScreen) {
            loadingScreen.classList.remove('hidden');
            
            const progressBar = document.getElementById('loading-progress');
            if (progressBar) {
                progressBar.style.width = '0%';
                setTimeout(() => {
                    progressBar.style.width = '100%';
                }, 500);
            }
            
            let targetUrl = null;
            if (e && e.currentTarget && e.currentTarget.href) {
                targetUrl = e.currentTarget.href;
            }

            setTimeout(() => {
                if (loadingScreen) {
                    loadingScreen.classList.add('fade-out');

                    loadingScreen.addEventListener('transitionend', () => {
                        loadingScreen.classList.add('hidden');
                        loadingScreen.classList.remove('fade-out');
                    }, { once: true });
                }

                if (targetUrl) {
                    window.location.href = targetUrl;
                }
            }, LOADING_DURATION);
        }
    }
    
    const loadingTriggers = [
        'a[href="/login"]',
        'a[href="/register"]',
        'a.btn-primary[href*="register"]'
    ];
    
    loadingTriggers.forEach(selector => {
        document.querySelectorAll(selector).forEach(element => {
            element.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && !href.startsWith('#')) {
                    showLoadingScreen(e);
                }
            });
        });
    });
    
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            showLoadingScreen(e);

            e.preventDefault();

            setTimeout(() => {
                form.submit();
            }, LOADING_DURATION);
        });
    });
});