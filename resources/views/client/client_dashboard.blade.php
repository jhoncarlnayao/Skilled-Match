<html lang="en"><head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sociotix Client Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');
    body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
    /* Hide scrollbar for Chrome, Safari and Opera */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    /* Hide scrollbar for IE, Edge and Firefox */
    .no-scrollbar { -ms-overflow-style: none;  scrollbar-width: none; }
  </style>
</head>
<body class="bg-slate-50 text-slate-600">
@include('client.navigation-bar-client.navbar-client')
  <!-- Main Content -->
  <div class="lg:ml-64 min-h-screen flex flex-col">
    
    <!-- Top Header -->
    <header class="sticky top-0 z-30 w-full bg-white/80 backdrop-blur-xl border-b border-slate-200">
      <div class="px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between">
          <!-- Mobile Menu Button -->
          <button class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-md">
            <iconify-icon icon="solar:hamburger-menu-linear" width="24" height="24"></iconify-icon>
          </button>

          <!-- Search -->
          <div class="hidden sm:flex relative max-w-sm w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
              <iconify-icon icon="solar:magnifer-linear" width="18" height="18"></iconify-icon>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-1.5 border border-slate-200 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-slate-900 focus:border-slate-900 sm:text-sm transition-shadow" placeholder="Search jobs or workers...">
          </div>

          <!-- Right Actions -->
          <div class="flex items-center gap-4">
            <button class="relative p-2 text-slate-400 hover:text-slate-600 transition-colors">
              <iconify-icon icon="solar:bell-linear" width="20" height="20"></iconify-icon>
              <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>
            <div class="h-8 w-[1px] bg-slate-200 mx-1"></div>
            <div class="flex items-center gap-3">
              <div class="text-right hidden sm:block">
                <p class="text-sm font-medium text-slate-900">Acme Inc.</p>
                <p class="text-xs text-slate-500">Client Account</p>
              </div>
              <img class="h-9 w-9 rounded-full ring-2 ring-white object-cover shadow-sm" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80" alt="Avatar">
            </div>
          </div>
        </div>
      </div>
    </header>

    @if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        x-transition
        class="fixed top-5 right-5 z-50"
    >
        <div class="flex items-start gap-3 bg-white border border-emerald-200 shadow-lg rounded-xl p-4 min-w-[280px]">
            
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                <iconify-icon icon="solar:check-circle-linear" width="20"></iconify-icon>
            </div>

            <div class="flex-1">
                <p class="text-sm font-semibold text-slate-900">
                    Success
                </p>
                <p class="text-xs text-slate-500 mt-1">
                    {{ session('success') }}
                </p>
            </div>

            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon>
            </button>
        </div>
    </div>
@endif


    <!-- Main Dashboard Body -->
    <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-8">
      
      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-xl font-semibold text-slate-900 tracking-tight">Overview</h1>
          <p class="text-sm text-slate-500 mt-1">Manage your posted jobs and track worker progress.</p>
        </div>
      
      </div>

      <!-- Stats Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Stat Card 1 -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32">
          <div class="flex items-start justify-between">
            <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
              <iconify-icon icon="solar:case-round-linear" width="20" height="20"></iconify-icon>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">+12%</span>
          </div>
          <div>
            <p class="text-2xl font-semibold text-slate-900">14</p>
            <p class="text-xs text-slate-500 font-medium">Active Jobs</p>
          </div>
        </div>
        
        <!-- Stat Card 2 -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32">
          <div class="flex items-start justify-between">
            <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
              <iconify-icon icon="solar:users-group-rounded-linear" width="20" height="20"></iconify-icon>
            </div>
          </div>
          <div>
            <p class="text-2xl font-semibold text-slate-900">8</p>
            <p class="text-xs text-slate-500 font-medium">Active Workers</p>
          </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32">
          <div class="flex items-start justify-between">
            <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
               <iconify-icon icon="solar:hourglass-line-linear" width="20" height="20"></iconify-icon>
            </div>
          </div>
          <div>
            <p class="text-2xl font-semibold text-slate-900">3</p>
            <p class="text-xs text-slate-500 font-medium">Pending Review</p>
          </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32">
          <div class="flex items-start justify-between">
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
               <iconify-icon icon="solar:wallet-money-linear" width="20" height="20"></iconify-icon>
            </div>
          </div>
          <div>
            <p class="text-2xl font-semibold text-slate-900">$4,250</p>
            <p class="text-xs text-slate-500 font-medium">Total Spent</p>
          </div>
        </div>
      </div>

      <!-- Content Layout: Jobs List & Quick Post -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Active Jobs List (Span 2) -->
        <div class="lg:col-span-2 space-y-4">
          <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-900">Recent Postings</h2>
            <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-700">View All</a>
          </div>

          <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full text-left border-collapse">
                <thead>
                  <tr class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                    <th class="px-6 py-4 font-medium">Job Details</th>
                    <th class="px-6 py-4 font-medium">Budget</th>
                    <th class="px-6 py-4 font-medium">Worker Status</th>
                    <th class="px-6 py-4 font-medium text-right">Action</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                  
                  <!-- Job Item 1: In Progress -->
                  <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                          <iconify-icon icon="solar:pen-new-square-linear" width="20"></iconify-icon>
                        </div>
                        <div>
                          <p class="text-sm font-medium text-slate-900">Blog Post Writing</p>
                          <p class="text-xs text-slate-500">Posted 2 days ago</p>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <span class="text-sm font-medium text-slate-700">$150.00</span>
                    </td>
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-2">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&amp;fit=crop&amp;w=64&amp;h=64" alt="Worker" class="w-6 h-6 rounded-full ring-2 ring-white">
                        <span class="text-xs font-medium text-slate-700">Sarah J.</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-600 border border-blue-100">
                          In Progress
                        </span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                      <button class="text-slate-400 hover:text-slate-600">
                        <iconify-icon icon="solar:menu-dots-bold" width="20"></iconify-icon>
                      </button>
                    </td>
                  </tr>

                  <!-- Job Item 2: Open / No Worker -->
                  <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-600">
                          <iconify-icon icon="solar:code-circle-linear" width="20"></iconify-icon>
                        </div>
                        <div>
                          <p class="text-sm font-medium text-slate-900">React Landing Page</p>
                          <p class="text-xs text-slate-500">Posted 5 hours ago</p>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <span class="text-sm font-medium text-slate-700">$850.00</span>
                    </td>
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full border border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                          <iconify-icon icon="solar:user-linear" width="12"></iconify-icon>
                        </div>
                        <span class="text-xs font-medium text-slate-400 italic">Unassigned</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                          Open
                        </span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                      <button class="text-slate-400 hover:text-slate-600">
                        <iconify-icon icon="solar:menu-dots-bold" width="20"></iconify-icon>
                      </button>
                    </td>
                  </tr>

                  <!-- Job Item 3: Completed / Review Needed -->
                  <tr class="group hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                          <iconify-icon icon="solar:figma-file-linear" width="20"></iconify-icon>
                        </div>
                        <div>
                          <p class="text-sm font-medium text-slate-900">UI Kit Redesign</p>
                          <p class="text-xs text-slate-500">Posted 1 week ago</p>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4">
                      <span class="text-sm font-medium text-slate-700">$400.00</span>
                    </td>
                    <td class="px-6 py-4">
                      <div class="flex items-center gap-2">
                         <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&amp;fit=crop&amp;w=64&amp;h=64" alt="Worker" class="w-6 h-6 rounded-full ring-2 ring-white">
                        <span class="text-xs font-medium text-slate-700">Mike R.</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-50 text-emerald-600 border border-emerald-100">
                          Completed
                        </span>
                      </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                       <button class="text-xs font-medium text-slate-900 underline decoration-slate-300 hover:decoration-slate-900 underline-offset-2 transition-all">Review</button>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-center">
                <button class="text-xs font-medium text-slate-500 hover:text-slate-900 flex items-center gap-1 transition-colors">
                    Show older jobs <iconify-icon icon="solar:alt-arrow-down-linear"></iconify-icon>
                </button>
            </div>
          </div>
        </div>

        <!-- Right Column: Quick Post Widget (Span 1) -->
        <div class="space-y-4">
          <h2 class="text-base font-semibold text-slate-900">Quick Post</h2>
          
          <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
            <form action="{{ route('client.jobs.store') }}" method="POST" class="space-y-4">
    @csrf

    <!-- Title Input -->
    <div>
        <label for="title" class="block text-xs font-medium text-slate-700 mb-1.5">
            Job Title
        </label>
        <input 
            type="text" 
            name="title"
            id="title"
            value="{{ old('title') }}"
            class="block w-full rounded-lg border-slate-200 bg-slate-50 text-sm 
                   focus:border-slate-900 focus:ring-slate-900 
                   placeholder:text-slate-400 py-2 px-3 shadow-sm transition-all"
            placeholder="e.g. Logo Design"
            required
        >
    </div>

    <!-- Category / Trade -->
    <div>
        <label for="trade_id" class="block text-xs font-medium text-slate-700 mb-1.5">
            Category
        </label>

        <div class="relative">
            <select 
                name="trade_id"
                id="trade_id"
                required
                class="block w-full appearance-none rounded-lg border-slate-200 bg-slate-50 text-sm 
                       focus:border-slate-900 focus:ring-slate-900 
                       py-2 px-3 shadow-sm transition-all text-slate-600"
            >
                <option value="">Select Category</option>

                @foreach($trades as $trade)
                    <option value="{{ $trade->id }}">
                        {{ $trade->name }}
                    </option>
                @endforeach
            </select>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                <iconify-icon icon="solar:alt-arrow-down-linear" width="12"></iconify-icon>
            </div>
        </div>
    </div>

    <!-- Budget -->
    <div>
        <label for="budget" class="block text-xs font-medium text-slate-700 mb-1.5">
            Budget ($)
        </label>
        <input 
            type="number"
            step="0.01"
            name="budget"
            id="budget"
            value="{{ old('budget') }}"
            class="block w-full rounded-lg border-slate-200 bg-slate-50 text-sm 
                   focus:border-slate-900 focus:ring-slate-900 
                   placeholder:text-slate-400 py-2 px-3 shadow-sm transition-all"
            placeholder="0.00"
        >
    </div>

    <!-- Location -->
    <div>
        <label for="location" class="block text-xs font-medium text-slate-700 mb-1.5">
            Location
        </label>
        <input 
            type="text"
            name="location"
            id="location"
            value="{{ old('location') }}"
            class="block w-full rounded-lg border-slate-200 bg-slate-50 text-sm 
                   focus:border-slate-900 focus:ring-slate-900 
                   placeholder:text-slate-400 py-2 px-3 shadow-sm transition-all"
            placeholder="e.g. Davao City"
            required
        >
    </div>

    <!-- Description -->
    <div>
        <label for="description" class="block text-xs font-medium text-slate-700 mb-1.5">
            Description
        </label>
        <textarea 
            name="description"
            id="description"
            rows="3"
            required
            class="block w-full rounded-lg border-slate-200 bg-slate-50 text-sm 
                   focus:border-slate-900 focus:ring-slate-900 
                   placeholder:text-slate-400 py-2 px-3 shadow-sm transition-all resize-none"
            placeholder="Briefly describe the task..."
        >{{ old('description') }}</textarea>
    </div>

    <!-- Submit Button -->
    <div class="pt-2">
        <button 
            type="submit"
            class="w-full inline-flex justify-center items-center gap-2 
                   bg-slate-900 hover:bg-slate-800 
                   text-white text-sm font-medium 
                   py-2.5 px-4 rounded-lg transition-colors shadow-sm"
        >
            <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
            Publish Job
        </button>
    </div>
</form>

          </div>

          <!-- Helper Card -->
          <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 text-white shadow-md relative overflow-hidden">
    <!-- Decorative Icon -->
    <div class="absolute top-0 right-0 -mt-2 -mr-2 opacity-10">
        <iconify-icon icon="mdi:headset" width="100" height="100"></iconify-icon>
    </div>

    <!-- Card Content -->
    <h3 class="text-sm font-semibold mb-1 relative z-10">Need Assistance?</h3>
    <p class="text-xs text-slate-300 mb-3 relative z-10 leading-relaxed">
        If you encounter any issues or need help, contact our admin support for assistance.
    </p>

    <!-- Button -->
    <button class="text-xs font-medium bg-white/10 hover:bg-white/20 border border-white/10 px-3 py-1.5 rounded-md transition-colors relative z-10">
        Contact Support
    </button>
</div>

<!-- Iconify Script -->
<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        </div>
      </div>
    </main>
  </div>


</body></html>