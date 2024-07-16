<div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative inline-block" id="dropdown">
    <!-- Dropdown Button -->
    <button
        class="flex h-12 w-12 items-center justify-center rounded-lg bg-slate-900 text-slate-100 ring-slate-100 transition hover:shadow-md hover:ring-2 overflow-hidden"
        @click="isOpen = !isOpen">
        <img class="w-full object-cover"
            src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?crop=top&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;h=100&amp;ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTY2Mjk2MTgwNw&amp;ixlib=rb-1.2.1&amp;q=80&amp;utm_campaign=api-credit&amp;utm_medium=referral&amp;utm_source=unsplash_source&amp;w=100"
            alt="Profile">
    </button>

    <!-- Dropdown Menu -->
    <div x-show="isOpen"
        class="absolute right-0 mt-3 flex w-60 flex-col gap-3 rounded-xl bg-slate-900 p-4 text-slate-100 shadow-lg">

        @if (Auth::check())
            <div class="dropdown-profile">
                <div class="flex gap-3 items-center">
                    <div
                        class="flex items-center justify-center rounded-lg h-12 w-12 overflow-hidden border-2 border-slate-600">
                        <img class="w-full object-cover"
                            src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?crop=top&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;h=100&amp;ixid=MnwxfDB8MXxyYW5kb218MHx8fHx8fHx8MTY2Mjk2MTgwNw&amp;ixlib=rb-1.2.1&amp;q=80&amp;utm_campaign=api-credit&amp;utm_medium=referral&amp;utm_source=unsplash_source&amp;w=100"
                            alt="Profile">
                    </div>
                    <div>
                        <div class="flex gap-1 text-sm font-semibold">
                            <span>{{ Auth::user()->name }}</span>
                            <span class="text-sky-400" style="color: aqua;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                        <div class="text-xs text-slate-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="border-t border-slate-500/30"></div>
                <div class="flex justify-around">
                    <div class="flex flex-col items-center justify-center">
                        <span class="text-3xl font-semibold">268</span>
                        <span class="text-sm text-slate-400">Following</span>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <span class="text-3xl font-semibold">897</span>
                        <span class="text-sm text-slate-400">Followers</span>
                    </div>
                </div>
                <div class="border-t border-slate-500/30"></div>
                <div class="flex flex-col">
                    <a href="#" class="flex items-center gap-3 rounded-md py-2 px-3 hover:bg-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Profile</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 rounded-md py-2 px-3 hover:bg-slate-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 01-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 01-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 01-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584zM12 18a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Help Center</span>
                    </a>
                </div>
                <button
                    class="flex justify-center gap-3 rounded-md bg-red-600 py-2 px-3 font-semibold hover:bg-red-500 focus:ring-2 focus:ring-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                        <path fill-rule="evenodd"
                            d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>Logout</span>
                </button>
            </div>
        @else
            <p>You Haven't Login,</p>
            <p>Please Login First</p>
            <a href="/log-reg">
                <button
                    class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-green-200 dark:focus:ring-green-800">
                    <span
                        class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        Login
                    </span>
                </button>
            </a>
        @endif
    </div>
</div>
