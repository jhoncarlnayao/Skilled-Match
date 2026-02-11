<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sociotix Light Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
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

   <main class="p-6" x-data="{ openModal: false }">

<!-- Header -->
<div class="flex flex-col mb-6">

  <!-- Top row: Title + Job tag on left, Button on right -->
  <div class="flex items-center justify-between mb-2">
    <div class="flex items-center gap-2">
      <h1 class="text-2xl font-semibold text-gray-800">My Jobs</h1>
      <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full">
        {{ $jobs->count() }} jobs
      </span>
    </div>

    <!-- Post Job Button -->
    <button @click="openModal = true"
            class="flex items-center gap-1 px-3 py-1 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
      <!-- Plus Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Post Job
    </button>
  </div>

  <!-- Mini Description below -->
  <p class="text-sm text-gray-500">
    Overview of your posted jobs and their status.
  </p>

</div>

<!-- Jobs Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($jobs as $job)
        <div class="w-full bg-white rounded-md p-5 border border-gray-200">
            <!-- Date and Status -->
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs text-gray-500">{{ $job->created_at->format('M d, Y') }}</span>
                <span class="px-2 py-1 text-xs rounded-full
                    {{ $job->status == 'open' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $job->status == 'assigned' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $job->status == 'completed' ? 'bg-blue-100 text-blue-700' : '' }}">
                    {{ ucfirst($job->status) }}
                </span>
            </div>

            <!-- Job Title -->
            <h2 class="mt-1 text-lg font-semibold text-gray-800">{{ $job->title }}</h2>

            <!-- Job Description -->
            <p class="mt-1 text-sm text-gray-600 line-clamp-3">{{ $job->description }}</p>

            <!-- Trade and Budget -->
            <div class="mt-3 flex justify-between text-sm text-gray-500">
                <span>{{ $job->trade }}</span>
                <span>₱{{ number_format($job->budget, 2) }}</span>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-500 py-10">
            No jobs posted yet.
        </div>
    @endforelse
</div>


  <!-- Modal -->
  <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" x-transition>
    <div @click.away="openModal = false" class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
      <h2 class="text-lg font-semibold mb-4">Post a New Job</h2>

      <form action="{{ route('client.jobs.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="text" name="title" placeholder="Job Title" required class="w-full px-4 py-3 text-sm border rounded-lg focus:ring focus:ring-blue-200">
      <select name="trade" required class="w-full px-4 py-3 text-sm border rounded-lg focus:ring focus:ring-blue-200">
    <option value="">Select Trade</option>
    @foreach($trades as $trade)
        <option value="{{ $trade->name }}">{{ $trade->name }}</option>
    @endforeach
</select>
        <input type="number" name="budget" placeholder="Budget" class="w-full px-4 py-3 text-sm border rounded-lg focus:ring focus:ring-blue-200">
        <input type="text" name="location" placeholder="Location" required class="w-full px-4 py-3 text-sm border rounded-lg focus:ring focus:ring-blue-200">
        <textarea name="description" placeholder="Describe the job..." rows="3" required class="w-full px-4 py-3 text-sm border rounded-lg focus:ring focus:ring-blue-200"></textarea>

        <div class="flex justify-end gap-3 pt-4">
          <button type="button" @click="openModal = false" class="px-4 py-2 text-sm border rounded-lg hover:bg-gray-100">Cancel</button>
          <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">Post Job</button>
        </div>
      </form>
    </div>
  </div>

</main>



  </div>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    window.addEventListener('load', () => {
      const options = {
        chart: {
          height: 350,
          type: 'line',
          toolbar: { show: false },
          zoom: { enabled: false }
        },
        series: [
          { name: 'Reach', data: [25, 35, 20, 45, 38, 55, 48, 62, 58, 70, 65, 80] },
          { name: 'Engagement', data: [15, 25, 40, 30, 45, 35, 50, 45, 60, 55, 75, 70] },
          { name: 'Impression', data: [10, 20, 15, 25, 20, 30, 25, 35, 30, 45, 40, 50] }
        ],
        stroke: { curve: 'smooth', width: 3 },
        colors: ['#facc15', '#22d3ee', '#a855f7'],
        grid: {
          borderColor: '#f1f5f9',
          strokeDashArray: 4,
          xaxis: { lines: { show: true } }
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          axisBorder: { show: false },
          axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: '#94a3b8' } } },
        legend: { show: false }
      };

      const chart = new ApexCharts(document.querySelector("#sociotix-main-chart"), options);
      chart.render();
    });
  </script>
</body>
</html>