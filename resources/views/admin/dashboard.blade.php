<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sociotix Light Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  <link rel="stylesheet" href="https://preline.co/assets/css/main.min.css">
  <style>
    /* Custom font to match the clean UI look */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-[#f8fafc]">

@include('admin.navigation-bar-admin.navbar-admin')

  <div class="w-full lg:ps-64">
    
    <header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white/80 backdrop-blur-md border-b py-3 px-4 sm:px-6 md:px-8">
      <div class="w-full flex items-center justify-between gap-x-5">
        <div class="relative w-full max-w-md">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
          </div>
          <input type="text" class="py-2 px-3 ps-10 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Search">
        </div>

        <div class="flex flex-row items-center justify-end gap-2">
          <button class="w-[2.375rem] h-[2.375rem] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
          </button>
          <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?auto=format&fit=facearea&facepad=2&w=300&h=300&q=80" alt="Avatar">
        </div>
      </div>
    </header>

    <main class="p-4 sm:p-6 space-y-6 ">
      
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-xl font-semibold text-slate-900 tracking-tight">Overview</h1>
          <p class="text-sm text-slate-500 mt-1">Manage your client's posted jobs and track worker progress.</p>
        </div>
        {{-- <button class="inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors shadow-sm ring-1 ring-slate-900 ring-offset-1">
          <iconify-icon icon="solar:add-circle-linear" width="18" height="18"></iconify-icon>
          Post New Job
        </button> --}}
      </div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

  <!-- Total Clients -->
  <a href="{{ route('admin.client.accounts') }}">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32 hover:scale-105 transition duration-300">
      <div class="flex items-start justify-between">
        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
          <iconify-icon icon="solar:case-round-linear" width="20" height="20"></iconify-icon>
        </div>
        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">
          +{{ $newClientsThisMonth }}%
        </span>
      </div>
      <div>
        <p class="text-2xl font-semibold text-slate-900">{{ $totalClients }}</p>
        <p class="text-xs text-slate-500 font-medium">Total Clients</p>
      </div>
    </div>
  </a>

  <!-- Total Workers -->
  <a href="{{ route('admin.pending.accounts', ['status' => 'approved']) }}">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32 hover:scale-105 transition duration-300">
      <div class="flex items-start justify-between">
        <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
          <iconify-icon icon="solar:users-group-rounded-linear" width="20" height="20"></iconify-icon>
        </div>
      </div>
      <div>
        <p class="text-2xl font-semibold text-slate-900">{{ $totalWorkers }}</p>
        <p class="text-xs text-slate-500 font-medium">Total Workers</p>
      </div>
    </div>
  </a>

  <!-- Pending Approvals -->
  <a href="{{ route('admin.pending.accounts', ['status' => 'pending']) }}">
    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32 hover:scale-105 transition duration-300">
      <div class="flex items-start justify-between">
        <div class="p-2 bg-amber-50 text-amber-600 rounded-lg">
          <iconify-icon icon="solar:hourglass-line-linear" width="20" height="20"></iconify-icon>
        </div>
      </div>
      <div>
        <p class="text-2xl font-semibold text-slate-900">{{ $pendingWorkers }}</p>
        <p class="text-xs text-slate-500 font-medium">Pending Review</p>
      </div>
    </div>
  </a>

  <!-- Active Jobs -->
  <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32 hover:scale-105 transition duration-300">
    <div class="flex items-start justify-between">
      <div class="p-2 bg-cyan-50 text-cyan-600 rounded-lg">
        <iconify-icon icon="solar:wallet-money-linear" width="20" height="20"></iconify-icon>
      </div>
    </div>
    <div>
      <p class="text-2xl font-semibold text-slate-900">{{ $activeJobs ?? '—' }}</p>
      <p class="text-xs text-slate-500 font-medium">Active Jobs</p>
    </div>
  </div>

</div>
<!-- ================= MAIN GRID LAYOUT ================= -->
<div class="grid lg:grid-cols-3 gap-6 mt-6">

  <!-- LEFT COLUMN (New Accounts + New Jobs) -->
  <div class="lg:col-span-2 space-y-6">

    <!-- NEW ACCOUNTS TODAY -->
    <section class="space-y-4">

      <!-- Header -->
     <div class="flex flex-col sm:flex-row sm:justify-between px-6 py-5 border-b border-slate-100">
  <div>
    <h2 class="text-base font-semibold text-slate-900">New Accounts Today</h2>
    <p class="text-xs text-slate-500 mt-1">
      See the latest accounts registered on the platform
    </p>
  </div>
  <a href="#" class="text-xs font-medium text-blue-600 hover:text-blue-700 mt-2 sm:mt-0">
    View All
  </a>
</div>


      <!-- Table -->
      <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                <th class="px-6 py-3 font-medium">Name</th>
                <th class="px-6 py-3 font-medium">Role</th>
                <th class="px-6 py-3 font-medium">Email</th>
                <th class="px-6 py-3 font-medium">Registered</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @forelse($newAccountsToday as $user)
                <tr class="group hover:bg-slate-50/50 transition-colors">
                  <!-- Name + mini description -->
                  <td class="px-6 py-4">
                    <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">
                      Joined as {{ ucfirst($user->role) }} | {{ $user->created_at->diffForHumans() }}
                    </p>
                  </td>
                  <!-- Role -->
                  <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium
                      {{ $user->role == 'client'
                          ? 'bg-blue-50 text-blue-600 border border-blue-100'
                          : 'bg-purple-50 text-purple-600 border border-purple-100' }}">
                      {{ ucfirst($user->role) }}
                    </span>
                  </td>
                  <!-- Email -->
                  <td class="px-6 py-4 text-sm text-slate-700">{{ $user->email }}</td>
                  <!-- Registered -->
                  <td class="px-6 py-4 text-sm text-slate-500">{{ $user->created_at->format('M d, Y H:i') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-sm">
                    No new accounts today.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-center">
          <a href="#" class="text-xs font-medium text-slate-500 hover:text-slate-900 flex items-center gap-1 transition-colors">
            View All Accounts <iconify-icon icon="solar:alt-arrow-down-linear"></iconify-icon>
          </a>
        </div>
      </div>
    </section>

    <!-- NEW JOBS TODAY -->
    <section class="space-y-4">

      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:justify-between px-6 py-5 border-b border-slate-100">
  <div>
    <h2 class="text-base font-semibold text-slate-900">New Jobs Today</h2>
    <p class="text-xs text-slate-500 mt-1">
      Monitor recently posted jobs and their current status
    </p>
  </div>
  <a href="{{ route('admin.jobs_list') }}" class="text-xs font-medium text-blue-600 hover:text-blue-700 mt-2 sm:mt-0">
    View All
  </a>
</div>


      <!-- Table Card -->
      <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                <th class="px-6 py-3 font-medium">Job Details</th>
                <th class="px-6 py-3 font-medium">Budget</th>
                <th class="px-6 py-3 font-medium">Client</th>
                <th class="px-6 py-3 font-medium">Trade</th>
                <th class="px-6 py-3 font-medium text-right">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              @forelse($newJobsToday as $job)
                <tr class="group hover:bg-slate-50/50 transition-colors">
                  <!-- Job Details -->
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <iconify-icon icon="solar:pen-new-square-linear" width="20"></iconify-icon>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-slate-900">{{ $job->title }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">
                          Posted {{ $job->created_at->diffForHumans() }} | ₱{{ number_format($job->budget, 2) }}
                        </p>
                      </div>
                    </div>
                  </td>
                  <!-- Budget -->
                  <td class="px-6 py-4 text-sm font-medium text-slate-700">₱{{ number_format($job->budget, 2) }}</td>
                  <!-- Client -->
                  <td class="px-6 py-4 text-sm text-slate-700">{{ $job->client->name ?? 'N/A' }}</td>
                  <!-- Trade -->
                  <td class="px-6 py-4 text-sm text-slate-700">{{ $job->trade->name ?? 'N/A' }}</td>
                  <!-- Status -->
                  <td class="px-6 py-4 text-right">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium
                      @if($job->status == 'open') bg-emerald-50 text-emerald-600 border border-emerald-100
                      @elseif($job->status == 'assigned') bg-amber-50 text-amber-600 border border-amber-100
                      @elseif($job->status == 'completed') bg-blue-50 text-blue-600 border border-blue-100
                      @else bg-slate-100 text-slate-600 border border-slate-200
                      @endif">
                      {{ ucfirst($job->status) }}
                    </span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">
                    No new jobs today.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-center">
          <a href="#" class="text-xs font-medium text-slate-500 hover:text-slate-900 flex items-center gap-1 transition-colors">
            View All Jobs <iconify-icon icon="solar:alt-arrow-down-linear"></iconify-icon>
          </a>
        </div>
      </div>
    </section>

  </div>

  <!-- RIGHT COLUMN (Quick Post Widget) -->
  <div class="space-y-6">

 <div class="flex flex-col sm:flex-row sm:justify-between px-6 py-4 ">
  <div>
    <h2 class="text-base font-semibold text-slate-900">Quick Add Trade</h2>
    <p class="text-xs text-slate-500 mt-1">
      Add a new trade quickly for your clients and workers
    </p>
  </div>
</div>


    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
      <form action="{{ route('admin.trades.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Trade Name -->
        <div>
          <label class="block text-xs font-medium text-slate-700 mb-1.5">Trade Name</label>
          <input type="text" name="name" required
            value="{{ old('name') }}"
            class="w-full rounded-lg border border-slate-200 bg-slate-50 text-sm
                   focus:border-slate-900 focus:ring-slate-900
                   py-2.5 px-3 shadow-sm transition-all"
            placeholder="e.g. Graphic Design">
        </div>

        <!-- Trade Description -->
        <div>
          <label class="block text-xs font-medium text-slate-700 mb-1.5">Description (Optional)</label>
          <textarea name="description" rows="3"
            class="w-full rounded-lg border border-slate-200 bg-slate-50 text-sm
                   focus:border-slate-900 focus:ring-slate-900
                   py-2.5 px-3 shadow-sm transition-all resize-none"
            placeholder="Brief description of this trade">{{ old('description') }}</textarea>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full bg-slate-900 hover:bg-slate-800 text-white
                 text-sm font-medium py-2.5 px-4 rounded-lg
                 transition-colors shadow-sm">
          Add Trade
        </button>
      </form>
    </div>

  </div>

</div>


    </main>
  </div>

  <script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
  
  </script>
</body>
</html>