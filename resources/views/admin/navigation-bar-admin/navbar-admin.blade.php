<aside id="application-sidebar" class="hs-overlay -translate-x-full transition-all duration-300 transform fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">
    <div class="flex items-center px-6 mb-8">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="mr-4 w-10 h-10">
    <a 
  class="flex-none text-2xl font-bold" 
  href="{{ route('admin.dashboard') }}"
  style="
    background: linear-gradient(135deg, #FD5068 0%, #FF7854 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  "
>
  SkilledTrade
</a>

    </div>

    <nav class="hs-accordion-group p-4 w-full flex flex-col flex-wrap">
        <ul class="space-y-1.5">

            <!-- Dashboard / Overview -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg transition
                   {{ Route::is('admin.dashboard') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-slate-600 hover:bg-gray-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Overview
                </a>
            </li>

            <!-- Worker's Account -->
            <li>
                <a href="{{ route('admin.pending.accounts') }}"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg transition
                   {{ Route::is('admin.pending.accounts') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-slate-600 hover:bg-gray-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z" />
                    </svg>
                    Worker's Account
                </a>
            </li>

            <!-- Client's Account -->
            <li>
                <a href="{{ route('admin.client.accounts') }}"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg transition
                   {{ Route::is('admin.client.accounts') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-slate-600 hover:bg-gray-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 0 0-4-4h-1M9 20H4v-2a4 4 0 0 1 4-4h1M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4z" />
                    </svg>
                    Client's Account
                </a>
            </li>

            <!-- Trade List -->
            <li>
                <a href="{{ route('admin.trades') }}"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg transition
                   {{ Route::is('admin.trades') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-slate-600 hover:bg-gray-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 0 0-2-2h-6m-4 0H4a2 2 0 0 0-2 2v6m16 0v6a2 2 0 0 1-2 2h-6m-4 0H4a2 2 0 0 1-2-2v-6" />
                    </svg>
                    Trade List
                </a>
            </li>

            <!-- Jobs List -->
            <li>
                <a href="{{ route('admin.jobs_list') }}"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg transition
                   {{ Route::is('admin.jobs_list') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-slate-600 hover:bg-gray-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 0 1 4-4h4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 11h16M4 15h16M4 19h16" />
                    </svg>
                    Job's List
                </a>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-600 hover:bg-gray-50 rounded-lg hover:text-red-600 transition w-full text-left" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1" />
                        </svg>
                        Log out
                    </button>
                </form>
            </li>

        </ul>
    </nav>
</aside>
