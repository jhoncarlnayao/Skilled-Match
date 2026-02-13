<aside id="application-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0">
    <div class="flex items-center px-6 mb-8">
      <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="mr-4 w-10 h-10">
      <a class="flex-none text-2xl font-bold text-slate-800" href="{{ route('admin.dashboard') }}">SkilledTrade</a>
    </div>

    <nav class="hs-accordion-group p-4 w-full flex flex-col flex-wrap">
      <ul class="space-y-1.5">
        <li>
          <a class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-slate-900 font-medium rounded-lg" href="{{ route('admin.dashboard') }}">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Overview
          </a>
        </li>
        <li>
        </li>
        <li><a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-600 hover:bg-gray-50 rounded-lg" href="{{ route('admin.pending.accounts') }}">Worker's Account</a></li>
        <li><a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-600 hover:bg-gray-50 rounded-lg" href="{{ route('admin.client.accounts') }}">Client's Account</a></li>
        <li><a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-600 hover:bg-gray-50 rounded-lg" href="{{ route('admin.trades') }}">Trade List</a></li>
        
        <li>
            {{-- Use the admin guard explicitly --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-600 hover:bg-gray-50 rounded-lg" type="submit">
                    Log out 
                </button>
            </form>
        </li>
      </ul>
    </nav>
</aside>
