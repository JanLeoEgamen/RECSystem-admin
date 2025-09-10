<footer class="footer-shadow bg-[#101966] dark:bg-gray-900 text-white py-4">
    <div class="container mx-auto px-6 w-full">
        <!-- Desktop Layout -->
        <div class="hidden md:flex justify-center items-center space-x-6">
            <!-- Logo and Name -->
            <div class="flex items-center space-x-2">
                <x-application-logo class="block h-6 w-auto fill-current text-white dark:text-gray-200"/>
                <span class="text-sm font-semibold text-white dark:text-gray-200">
                    Radio Engineering Circle Inc.
                </span>
            </div>

            <!-- Copyright -->
            <div class="text-gray-400 dark:text-gray-400 text-xs text-center px-8">
                &copy; {{ date('Y') }} Radio Engineering Circle Inc. All rights reserved.
            </div>

            <!-- Social Icons -->
            <div class="flex space-x-3">
                <a href="#" aria-label="Facebook" class="hover:opacity-80 transition">
                    <img width="20" height="20" src="https://img.icons8.com/fluency/48/facebook-new.png" alt="facebook" class="w-5 h-5">
                </a>
                <a href="#" aria-label="YouTube" class="hover:opacity-80 transition">
                    <img width="20" height="20" src="https://img.icons8.com/color/48/youtube-play.png" alt="youtube" class="w-5 h-5">
                </a>
                <a href="#" aria-label="Instagram" class="hover:opacity-80 transition">
                    <img width="20" height="20" src="https://img.icons8.com/color/48/instagram-new.png" alt="instagram" class="w-5 h-5">
                </a>
                <a href="#" aria-label="Messenger" class="hover:opacity-80 transition">
                    <img width="20" height="20" src="https://img.icons8.com/color/48/facebook-messenger.png" alt="messenger" class="w-5 h-5">
                </a>
                <a href="#" aria-label="GitHub" class="hover:opacity-80 transition">
                    <img width="20" height="20" src="https://img.icons8.com/color-glass/50/github.png" alt="github" class="w-5 h-5">
                </a>
            </div>
        </div>

        <!-- Mobile Layout -->
        <div class="md:hidden w-full">
            <div class="w-full flex flex-col items-center justify-center text-center mx-auto">
                <div class="w-full flex justify-center items-center space-x-2 mb-2">
                    <x-application-logo class="block h-6 w-auto fill-current text-white dark:text-gray-200"/>
                    <span class="text-sm font-semibold text-white dark:text-gray-200">
                        REC Inc.
                    </span>
                </div>
                <div class="w-full text-center">
                    <div class="text-gray-400 dark:text-gray-500 text-xs">
                        &copy; {{ date('Y') }} Radio Engineering Circle Inc.
                    </div>
                    <div class="text-gray-400 dark:text-gray-500 text-xs">
                        All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>