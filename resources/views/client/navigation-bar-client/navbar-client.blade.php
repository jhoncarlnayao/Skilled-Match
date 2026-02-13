<aside id="application-sidebar"
class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">

    <!-- Logo -->
    <div class="flex items-center px-6 mb-8">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="mr-4 w-10 h-10">
        <a class="flex-none text-2xl font-bold text-slate-800" href="#">
            SkilledTrade
        </a>
    </div>

    <!-- Navigation -->
    <nav class="hs-accordion-group p-4 w-full flex flex-col flex-wrap">
        <ul class="space-y-1.5">

            <!-- Dashboard -->
            <li>
                <a href="{{ route('client.client_dashboard') }}"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg
                   {{ request()->routeIs('client.client_dashboard') ? 'bg-gray-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    Dashboard
                </a>
            </li>

            <!-- Post a Job -->
            <li>
                <a href="{{ route('client.client_post_job') }}"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg
                   {{ request()->routeIs('client.client_post_job') ? 'bg-gray-100 text-slate-900 font-medium' : 'text-slate-600 hover:bg-gray-50' }}">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Post a Job
                </a>
            </li>


            <!-- Completed Jobs -->
            <li>
                <a href="#?status=completed"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm rounded-lg text-slate-600 hover:bg-gray-50">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Completed Jobs
                </a>
            </li>

            <hr class="my-3 border-gray-200">

            <!-- Profile -->
            <li>
                <a href="#"
                   class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-600 hover:bg-gray-50 rounded-lg">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M5.5 21a8.38 8.38 0 0 1 13 0"/>
                    </svg>
                    Profile
                </a>
            </li>

            <!-- Settings -->
           <!-- Log out -->
<li>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-600 hover:bg-gray-50 rounded-lg w-full text-left">
      <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="3"/>
        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33"/>
      </svg>
      Log out
    </button>
  </form>
</li>


        </ul>
    </nav>
</aside>
