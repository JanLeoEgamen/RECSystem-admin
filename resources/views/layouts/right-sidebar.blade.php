 @can('view admin dashboard')
<nav x-show="rightSidebarOpen" 
     class="bg-[#101966] dark:bg-gray-800 text-white w-64 fixed right-0 top-20 flex flex-col" 
     :class="{ 'w-20': !rightSidebarOpen }"
     style="background-color: #132080; height: calc(100vh - 80px); box-shadow: -8px 0 15px -5px rgba(0, 0, 0, 0.7);">
   
    <div class="p-4 flex flex-col items-center">
        <div class="w-full flex items-center justify-center mb-2">
            <span class="text-gray-300 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                QUICK ACTIONS
            </span>
        </div>
        <div class="border-t border-gray-700 my-3 w-3/4"></div>
    </div>

    <div class="flex-1 overflow-y-auto py-2 space-y-4" style="scrollbar-width: thin; scrollbar-color: #5E6FFB #101966;">
        
        @canany(['view applicants', 'view  s', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="px-2" x-data="{ membershipOpen: true }">
            <button @click="membershipOpen = !membershipOpen" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none">
                <div class="flex items-center">
                    <img width="20" height="20" src="https://img.icons8.com/ios-glyphs/50/FFFFFF/add-user-group-man-man.png" alt="new-member" class="w-5 h-5 mr-2">
                    <span>Membership</span>
                </div>
                <svg class="h-4 w-4" :class="{ 'rotate-180': membershipOpen }" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="membershipOpen" class="pl-12 mt-2 space-y-2">
                @can('view applicants')
                    <x-nav-link :href="route('applicants.showApplicantCreateForm')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Applicant</span>
                    </x-nav-link>
                @endcan

                @can('create members')
                    <x-nav-link :href="route('members.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-member" class="w-5 h-5 mr-2">
                        <span>New Member</span>
                    </x-nav-link>
                @endcan

                @can('view applicants')
                    <x-nav-link :href="route('applicants.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="assessment" class="w-5 h-5 mr-2">
                        <span>Assess Applicants</span>
                    </x-nav-link>
                @endcan

                @can('renew members')
                    <x-nav-link :href="route('members.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="renew" class="w-5 h-5 mr-2">
                        <span>Renew Members</span>
                    </x-nav-link>
                @endcan
            </div>
        </div>
        @endcanany

        @canany(['view faqs', 'view main carousels', 'view event announcements', 'view communities', 'view articles', 'view supporters'])
        <div class="px-2" x-data="{ websiteOpen: true }">
            <button @click="websiteOpen = !websiteOpen" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Website Content</span>
                </div>
                <svg class="h-4 w-4" :class="{ 'rotate-180': websiteOpen }" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="websiteOpen" class="pl-12 mt-2 space-y-2">
                @can('view event-announcements')
                    <x-nav-link :href="route('event-announcements.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Event</span>
                    </x-nav-link>
                @endcan

                @can('view articles')
                    <x-nav-link :href="route('articles.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Article</span>
                    </x-nav-link>
                @endcan

                @can('view communities')
                    <x-nav-link :href="route('communities.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Community</span>
                    </x-nav-link>
                @endcan

                @can('view faqs')
                    <x-nav-link :href="route('faqs.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New FAQ</span>
                    </x-nav-link>
                @endcan

                @can('view markees')
                    <x-nav-link :href="route('markees.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Markee</span>
                    </x-nav-link>
                @endcan

                @can('view main-carousels')
                    <x-nav-link :href="route('main-carousels.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Carousel</span>
                    </x-nav-link>
                @endcan

                @can('view supporters')
                    <x-nav-link :href="route('supporters.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Supporter</span>
                    </x-nav-link>
                @endcan
            </div>
        </div>
        @endcanany
        
        @canany(['view bureaus', 'view sections', 'view users', 'view roles', 'view permissions', 'view supporters'])
        <div class="px-2" x-data="{ maintenanceOpen: false }">
            <button @click="maintenanceOpen = !maintenanceOpen" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-[#5E6FFB] focus:outline-none">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Maintenance</span>
                </div>
                <svg class="h-4 w-4" :class="{ 'rotate-180': maintenanceOpen }" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="maintenanceOpen" class="pl-12 mt-2 space-y-2">
                @can('view bureaus')
                    <x-nav-link :href="route('bureaus.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Bureau</span>
                    </x-nav-link>
                @endcan

                @can('view sections')
                    <x-nav-link :href="route('sections.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Section</span>
                    </x-nav-link>
                @endcan

                @can('view users')
                    <x-nav-link :href="route('users.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New User</span>
                    </x-nav-link>
                @endcan

                @can('view roles')
                    <x-nav-link :href="route('roles.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Role</span>
                    </x-nav-link>
                @endcan

                @can('view permissions')
                    <x-nav-link :href="route('permissions.index')" class="justify-start py-2">
                        <img width="20" height="20" src="https://img.icons8.com/glyph-neue/50/FFFFFF/add--v1.png" alt="new-applicant" class="w-5 h-5 mr-2">
                        <span>New Permission</span>
                    </x-nav-link>
                @endcan
            </div>
        </div>
        @endcanany

        <div class="flex justify-center">
            <div class="border-t border-gray-700 my-3 w-3/4"></div>
        </div>
    </div>
</nav>
@endcan