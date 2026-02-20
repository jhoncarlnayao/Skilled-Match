<!-- Sidebar -->
<aside id="application-sidebar"
class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform
fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-r border-slate-200
pt-6 pb-6 overflow-y-auto lg:block lg:translate-x-0">

  <div class="h-full px-4 flex flex-col justify-between">

    <!-- Logo -->
    <div>
      <div class="mb-8 px-2 flex items-center gap-3">
        <div class="w-9 h-9 bg-slate-900 rounded-lg flex items-center justify-center text-white">
          <span class="font-semibold text-sm tracking-tight">S</span>
        </div>
        <span class="text-lg font-semibold tracking-tight text-slate-900">
          SkilledTrade
        </span>
      </div>

      <!-- Navigation -->
      <nav class="space-y-1 text-sm font-medium">

        <!-- Dashboard -->
        <a href="{{ route('client.client_dashboard') }}"
           class="flex items-center p-2 rounded-lg transition-colors
           {{ request()->routeIs('client.client_dashboard') 
              ? 'bg-slate-100 text-slate-900' 
              : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
          
          <iconify-icon icon="solar:widget-5-linear" width="20" height="20"></iconify-icon>
          <span class="ms-3">Dashboard</span>
        </a>

        <!-- Post a Job -->
        <a href="{{ route('client.client_post_job') }}"
           class="flex items-center p-2 rounded-lg transition-colors
           {{ request()->routeIs('client.client_post_job') 
              ? 'bg-slate-100 text-slate-900' 
              : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
          
            <iconify-icon icon="solar:case-round-linear" width="20" height="20"></iconify-icon>
          <span class="ms-3">My Jobs</span>
        </a>


        <!-- Completed Jobs -->
        <a href="#"
           class="flex items-center p-2 rounded-lg transition-colors
           text-slate-500 hover:bg-slate-50 hover:text-slate-900">
          
          <iconify-icon icon="solar:check-circle-linear" width="20" height="20"></iconify-icon>
          <span class="ms-3">Completed Jobs</span>
        </a>

        <div class="border-t border-slate-100 my-4"></div>

        <!-- Profile -->
        <a href="{{ route('client.client_profile') }}"
           class="flex items-center p-2 rounded-lg transition-colors
           text-slate-500 hover:bg-slate-50 hover:text-slate-900">
          
          <iconify-icon icon="solar:user-linear" width="20" height="20"></iconify-icon>
          <span class="ms-3">Profile</span>
        </a>

      </nav>
    </div>

    <!-- Bottom Section -->
    <div class="border-t border-slate-100 pt-4">

      <!-- Logout -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
          class="flex items-center w-full p-2 rounded-lg text-sm font-medium
          text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors text-left">
          
          <iconify-icon icon="solar:logout-2-linear" width="20" height="20"></iconify-icon>
          <span class="ms-3">Log out</span>
        </button>
      </form>

    </div>

  </div>
</aside>
