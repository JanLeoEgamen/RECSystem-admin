<!-- Announcement Modal -->
<div id="announcementModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0">
    <div id="announcementModalContent" class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden transform transition-all duration-500 translate-y-8 opacity-0">
        
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] p-4 sm:p-6 relative">
            <button onclick="closeAnnouncementModal()" 
                    class="absolute top-3 right-3 sm:top-4 sm:right-4 text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="flex items-center space-x-3 sm:space-x-4">
                <div class="bg-white/20 p-2 sm:p-3 rounded-full flex-shrink-0">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg sm:text-2xl font-bold text-white">Important Announcement 🔔</h2>
                    <p class="text-white/80 text-xs sm:text-sm">Stay updated with the latest from <strong>Radio Engineering Circle Inc.</strong></p>
                </div>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-4 sm:p-6 overflow-y-auto max-h-[60vh]">
            <div class="space-y-3 sm:space-y-4">
                <!-- Date and Beta Badge Row -->
                <div class="flex flex-row flex-wrap items-center justify-between gap-2 sm:gap-3">
                    <!-- Date Badge -->
                    <div class="inline-flex items-center space-x-2 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-medium">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>October 1, 2025</span>
                    </div>

                    <!-- Beta Badge with Hover -->
                    <div class="relative group">
                        <div class="inline-flex items-center space-x-2 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm font-semibold border-2 border-yellow-300 dark:border-yellow-700 cursor-help transition-all hover:scale-105">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span class="whitespace-nowrap">SYSTEM IN BETA MODE</span>
                        </div>
                        
                        <!-- Beta Notice Tooltip (appears on hover) -->
                        <div class="absolute right-0 top-full mt-2 w-80 bg-yellow-50 dark:bg-yellow-900/90 border-2 border-yellow-300 dark:border-yellow-700 rounded-lg p-3 sm:p-4 shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10">
                            <p class="text-yellow-900 dark:text-yellow-200 font-semibold mb-2 flex items-center space-x-2 text-xs sm:text-sm">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <span>Beta Notice:</span>
                            </p>
                            <p class="text-yellow-800 dark:text-yellow-300 text-xs leading-relaxed text-justify">
                                This system is currently in <strong>BETA/TESTING mode</strong>. You may encounter minor bugs or features under development. 
                                Some functionalities are still being tested and refined for optimal performance.
                                We appreciate your patience and feedback as we continue to improve your experience.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Announcement Title -->
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 text-center sm:text-left">
                    Welcome to our new<br class="sm:hidden"> Member Portal! 🎉
                </h3>

                <!-- Announcement Content -->
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                        We're excited to announce the launch of our brand new membership portal! This platform has been designed 
                        with you in mind, offering enhanced features and improved user experience.
                    </p>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-3 sm:p-4 my-3 sm:my-4 rounded-r-lg">
                        <p class="text-blue-900 dark:text-blue-200 font-medium mb-2 text-sm sm:text-base">🥳What's New: </p>
                        <ul class="text-blue-800 dark:text-blue-300 space-y-1.5 sm:space-y-2 text-xs sm:text-sm">
                            <li>✓ Streamlined membership registration process</li>
                            <li>✓ Digital certificate downloads</li>
                            <li>✓ Real-time event notifications</li>
                            <li>✓ Enhanced member directory</li>
                            <li>✓ Mobile-responsive design</li>
                        </ul>
                    </div>

                    <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                        📣 Join us today and be part of the growing Radio Engineering Circle community. Whether you're a seasoned 
                        professional or just starting your journey in radio engineering, we have resources and connections to 
                        help you succeed. 🎊
                    </p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 dark:bg-gray-900 p-4 sm:p-6 flex flex-col sm:flex-row gap-3 justify-between items-center">
            <label class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 cursor-pointer">
                <input type="checkbox" id="dontShowAgain" 
                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2">
                <span class="text-xs sm:text-sm">Don't show this again</span>
            </label>
            
            <button onclick="closeAnnouncementModal()" 
                    class="w-full sm:w-auto px-5 sm:px-6 py-2 sm:py-2.5 bg-gradient-to-r from-[#101966] to-[#5e6ffb] text-white rounded-full hover:opacity-90 transition-opacity font-medium flex items-center justify-center space-x-2 text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>I Understand</span>
            </button>
        </div>
    </div>
</div>

<script>
// Show modal on page load (with delay for better UX)
window.addEventListener('DOMContentLoaded', function() {
    // Check if user has chosen not to see the modal
    if (!localStorage.getItem('hideAnnouncementModal')) {
        setTimeout(function() {
            showAnnouncementModal();
        }, 1000); // Show after 1 second
    }
});

function showAnnouncementModal() {
    const modal = document.getElementById('announcementModal');
    const modalContent = document.getElementById('announcementModalContent');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    // Trigger animations
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        modalContent.classList.remove('translate-y-8', 'opacity-0');
        modalContent.classList.add('translate-y-0', 'opacity-100');
    }, 10);
}

function closeAnnouncementModal() {
    const modal = document.getElementById('announcementModal');
    const modalContent = document.getElementById('announcementModalContent');
    const dontShowAgain = document.getElementById('dontShowAgain');
    
    // Save preference if checkbox is checked
    if (dontShowAgain.checked) {
        localStorage.setItem('hideAnnouncementModal', 'true');
    }
    
    // Animate out
    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    modalContent.classList.remove('translate-y-0', 'opacity-100');
    modalContent.classList.add('translate-y-8', 'opacity-0');
    
    // Hide after animation completes
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }, 300);
}

// Close modal when clicking outside
document.getElementById('announcementModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAnnouncementModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAnnouncementModal();
    }
});
</script>