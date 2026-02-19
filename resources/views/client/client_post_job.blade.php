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

@include('client.navigation-bar-client.navbar-client')

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
<main class="flex-1 p-6 lg:p-8 bg-slate-50" 
      x-data="{
        openModal: false,
        search: '',
      }">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
      <h1 class="text-xl font-semibold text-slate-900 tracking-tight">
        My Jobs
      </h1>
      <p class="text-sm text-slate-500 mt-1">
        Manage {{ $jobs->count() }} posted jobs.
      </p>
    </div>

    <button @click="openModal = true"
      class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition shadow-sm">
      <iconify-icon icon="solar:add-circle-linear" width="18"></iconify-icon>
      Post New Job
    </button>
  </div>

  <!-- Jobs List -->
  <div class="space-y-4">

    @forelse($jobs as $job)

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition-all group">

      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <!-- Left Side -->
        <div class="flex items-start gap-4 flex-1">

          <!-- Icon -->
          <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 shrink-0">
            <iconify-icon icon="solar:case-round-linear" width="24"></iconify-icon>
          </div>

          <!-- Title + Meta -->
          <div>
            <div class="flex items-center gap-2 mb-1">
              <h3 class="text-base font-semibold text-slate-900 group-hover:text-blue-600 transition">
                {{ $job->title }}
              </h3>

              <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium
                {{ $job->status === 'open' ? 'bg-blue-50 text-blue-600 border border-blue-100' : '' }}
                {{ $job->status === 'assigned' ? 'bg-yellow-50 text-yellow-600 border border-yellow-100' : '' }}
                {{ $job->status === 'completed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}">
                {{ ucfirst($job->status) }}
              </span>
            </div>

            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500">
              <span class="flex items-center gap-1">
                <iconify-icon icon="solar:calendar-linear" width="14"></iconify-icon>
                {{ $job->created_at->format('M d, Y') }}
              </span>

              <span class="flex items-center gap-1">
                <iconify-icon icon="solar:tag-linear" width="14"></iconify-icon>
                {{ $job->trade->name }}
              </span>

              <span class="flex items-center gap-1">
                <iconify-icon icon="solar:map-point-linear" width="14"></iconify-icon>
                {{ $job->location }}
              </span>
            </div>
          </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center justify-between md:justify-end gap-6 md:w-auto w-full border-t md:border-t-0 border-slate-100 pt-3 md:pt-0 md:pl-6">

          <!-- Budget -->
          <div class="text-left md:text-right">
            <p class="text-xs text-slate-500 font-medium">Budget</p>
            <p class="text-base font-semibold text-slate-900">
              ₱{{ number_format($job->budget, 2) }}
            </p>
          </div>

          <!-- Actions -->
          <div class="flex items-center gap-2">
            <button class="text-slate-400 hover:text-slate-600 p-2 hover:bg-slate-50 rounded-lg transition">
              <iconify-icon icon="solar:pen-linear" width="18"></iconify-icon>
            </button>

            <button class="text-red-400 hover:text-red-600 p-2 hover:bg-red-50 rounded-lg transition">
              <iconify-icon icon="solar:trash-bin-trash-linear" width="18"></iconify-icon>
            </button>
          </div>

        </div>
      </div>
    </div>

    @empty
      <div class="text-center text-slate-500 py-12">
        No jobs posted yet.
      </div>
    @endforelse

  </div>

  <!-- Pagination -->
  {{-- <div class="mt-8 border-t border-slate-200 pt-6">
    {{ $jobs->links() }}
  </div> --}}

  <!-- Modal -->
  <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-transition>
    <div @click.away="openModal = false" class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
      <h2 class="text-lg font-semibold mb-4 text-slate-900">Post a New Job</h2>

      <form action="{{ route('client.jobs.store') }}" method="POST" class="space-y-4">
        @csrf

        <input type="text" name="title" placeholder="Job Title"
          class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-slate-900">

        <select name="trade_id"
          class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-slate-900">
          <option value="">Select Trade</option>
          @foreach($trades as $trade)
            <option value="{{ $trade->id }}">{{ $trade->name }}</option>
          @endforeach
        </select>

        <input type="number" name="budget" placeholder="Budget"
          class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-slate-900">

        <input type="text" name="location" placeholder="Location"
          class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-slate-900">

        <textarea name="description" rows="3" placeholder="Describe the job..."
          class="w-full px-4 py-3 text-sm border border-slate-200 rounded-lg focus:ring-2 focus:ring-slate-900"></textarea>

        <div class="flex justify-end gap-3 pt-4">
          <button type="button" @click="openModal = false"
            class="px-4 py-2 text-sm border border-slate-200 rounded-lg hover:bg-slate-50">
            Cancel
          </button>

          <button type="submit"
            class="px-4 py-2 text-sm bg-slate-900 text-white rounded-lg hover:bg-slate-800">
            Post Job
          </button>
        </div>
      </form>
    </div>
  </div>

</main>




  </div>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>
</html>