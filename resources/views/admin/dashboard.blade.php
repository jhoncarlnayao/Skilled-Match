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

    <main class="p-4 sm:p-6 space-y-6">
      

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">

  <!-- Total Workers -->
  <div class="p-5 bg-[#f5f3ff] border border-purple-100 rounded-2xl">
    <div class="flex justify-between items-start">
      <span class="text-sm font-medium text-purple-600">Total Workers</span>
      <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path d="M17 20v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 20v-2a4 4 0 00-3-3.87"/>
        <path d="M16 3.13a4 4 0 010 7.75"/>
      </svg>
    </div>
    <div class="mt-2 flex items-baseline gap-x-2">
      <h3 class="text-2xl font-bold text-slate-800">{{ $totalWorkers }}</h3>
      <span class="text-xs font-semibold bg-white px-2 py-0.5 rounded-md text-green-600">
        +{{ $newWorkersThisMonth }}
      </span>
    </div>
  </div>

  <!-- Pending Approvals -->
  <div class="p-5 bg-[#fefce8] border border-yellow-100 rounded-2xl">
    <div class="flex justify-between items-start">
      <span class="text-sm font-medium text-yellow-600">Pending Approvals</span>
      <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path d="M12 8v4l3 3"/>
        <circle cx="12" cy="12" r="10"/>
      </svg>
    </div>
    <div class="mt-2 flex items-baseline gap-x-2">
      <h3 class="text-2xl font-bold text-slate-800">{{ $pendingWorkers }}</h3>
      <span class="text-xs font-semibold bg-white px-2 py-0.5 rounded-md text-red-600">
        Needs review
      </span>
    </div>
  </div>

  <!-- Active Jobs -->
  <div class="p-5 bg-[#ecfeff] border border-cyan-100 rounded-2xl">
    <div class="flex justify-between items-start">
      <span class="text-sm font-medium text-cyan-600">Active Jobs</span>
      <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <rect x="3" y="4" width="18" height="14" rx="2"/>
        <path d="M8 2v4M16 2v4"/>
      </svg>
    </div>
    <div class="mt-2 flex items-baseline gap-x-2">
      {{-- <h3 class="text-2xl font-bold text-slate-800">{{ $activeJobs }}</h3> --}}
      <span class="text-xs font-semibold bg-white px-2 py-0.5 rounded-md text-blue-600">
        In progress
      </span>
    </div>
  </div>

  <!-- Completed Jobs -->
  <div class="p-5 bg-[#f1f5f9] border border-slate-200 rounded-2xl">
    <div class="flex justify-between items-start">
      <span class="text-sm font-medium text-slate-600">Completed Jobs</span>
      <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path d="M5 13l4 4L19 7"/>
      </svg>
    </div>
    <div class="mt-2 flex items-baseline gap-x-2">
      {{-- <h3 class="text-2xl font-bold text-slate-800">{{ $completedJobs }}</h3> --}}
      <span class="text-xs font-semibold bg-white px-2 py-0.5 rounded-md text-green-600">
        {{-- {{ $completionRate }}% --}}
      </span>
    </div>
  </div>

</div>


      <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-wrap justify-between items-center gap-2 mb-8">
          <h4 class="text-lg font-bold text-slate-800">Profile Overview</h4>
          <div class="flex items-center gap-x-4 text-xs font-medium text-gray-500">
            <div class="flex items-center gap-x-1"><span class="w-3 h-3 rounded-full bg-yellow-400"></span> Reach</div>
            <div class="flex items-center gap-x-1"><span class="w-3 h-3 rounded-full bg-cyan-400"></span> Engagement</div>
            <div class="flex items-center gap-x-1"><span class="w-3 h-3 rounded-full bg-purple-400"></span> Impression</div>
          </div>
        </div>
        <div id="sociotix-main-chart" class="min-h-[350px]"></div>
      </div>

    </main>
  </div>

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