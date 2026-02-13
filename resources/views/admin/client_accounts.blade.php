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
<section class="container px-4 mx-auto">
  <div class="sm:flex sm:items-center sm:justify-between">
    <div>
      <div class="flex items-center gap-x-3">
        <h2 class="text-lg font-medium text-gray-800">Client's Account List</h2>
        <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full">240 Client's</span>
      </div>
      <p class="mt-1 text-sm text-gray-500">These companies have purchased in the last 12 months.</p>
    </div>

  <div class="flex items-center mt-4 gap-x-3">

    {{-- <a href="{{ route('admin.pending.accounts', ['status' => 'pending']) }}"
       class="px-5 py-2 text-sm font-medium rounded-lg transition
       {{ $status === 'pending' 
            ? 'bg-yellow-500 text-white shadow-sm' 
            : 'bg-white border text-gray-700 hover:bg-gray-100' }}">
        Pending Accounts
    </a>

    <a href="{{ route('admin.pending.accounts', ['status' => 'approved']) }}"
       class="px-5 py-2 text-sm font-medium rounded-lg transition
       {{ $status === 'approved' 
            ? 'bg-green-600 text-white shadow-sm' 
            : 'bg-white border text-gray-700 hover:bg-gray-100' }}">
        Approved Accounts
    </a> --}}

</div>


  </div>

  <!-- Table -->
<div class="flex flex-col mt-6">
  <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
      <div class="overflow-hidden border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Full Name</th>
              <th class="py-3 px-12 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">About</th>
              <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
            </tr>
          </thead>

          <tbody class="bg-white divide-y divide-gray-200">
  @forelse($users as $user)

          <tr>
              <!-- Full Name + Email -->
              <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                  <div>
                      <h2 class="font-semibold text-gray-800">
                          {{ $user->name }}
                      </h2>
                      <p class="text-gray-500 text-sm">
                          {{ $user->email }}
                      </p>
                  </div>
              </td>

              <!-- Status -->
              <td class="px-12 py-4">
                <span class="inline-block px-3 py-1 text-sm font-normal rounded-full
    {{ $user->status === 'approved' 
        ? 'text-green-700 bg-green-100' 
        : 'text-yellow-700 bg-yellow-100' }}">
    {{ ucfirst($user->status) }}
</span>

              </td>

              <!-- About -->
              <td class="px-4 py-4 text-sm">
                  <p class="text-gray-700">{{ $user->role }}</p>
                  <p class="text-gray-500 text-sm">
                      Joined: {{ $user->created_at->format('M d, Y') }}
                  </p>
              </td>

              <!-- Action -->
            <!-- Action -->
<td class="px-4 py-4 text-sm">
  <div class="flex items-center gap-2">
    <!-- Edit -->
<button type="button"
        data-hs-overlay="#edit-user-modal-{{ $user->id }}"
        class="flex items-center gap-2 px-4 py-2 text-sm font-medium 
               text-white bg-blue-600 rounded-lg shadow-sm
               hover:bg-blue-700 focus:outline-none focus:ring-2 
               focus:ring-blue-500 focus:ring-offset-1 transition">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-4 h-4"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M11 5h2M12 7v10m-7 4h14a2 2 0 002-2V7l-6-4H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    Edit
</button>


  <div class="flex gap-2">

        @if($user->status === 'active')

            <!-- Deactivate Button -->
            <a href="{{ route('admin.client.toggle', $user->id) }}"
               class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white 
                      bg-red-600 rounded-lg shadow-sm 
                      hover:bg-red-700 focus:outline-none focus:ring-2 
                      focus:ring-red-500 focus:ring-offset-1 transition">
                Deactivate
            </a>

        @else

            <!-- Activate Button -->
            <a href="{{ route('admin.client.toggle', $user->id) }}"
               class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white 
                      bg-green-600 rounded-lg shadow-sm 
                      hover:bg-green-700 focus:outline-none focus:ring-2 
                      focus:ring-green-500 focus:ring-offset-1 transition">
                Activate
            </a>

        @endif

    </div>

  </div>
</td>

          </tr>
          @empty
          <tr>
              <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                  No client accounts found.
              </td>
          </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</section>

@foreach($users as $user)
<div id="edit-user-modal-{{ $user->id }}"
     class="hs-overlay hidden fixed inset-0 z-[80] overflow-y-auto">
     
  <div class="flex items-center justify-center min-h-screen px-4">
    
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl border border-gray-200">

      {{-- Header --}}
      <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">
          Edit Client Account
        </h3>
        <button type="button"
                data-hs-overlay="#edit-user-modal-{{ $user->id }}"
                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
          ✕
        </button>
      </div>

      {{-- Body --}}
      <div class="p-6">
        <form action="{{ route('admin.client.update', $user->id) }}"
              method="POST"
              class="space-y-5">
          @csrf
     

          {{-- Full Name --}}
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">
              Full Name
            </label>
            <input type="text"
                   name="name"
                   value="{{ $user->name }}"
                   class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                          outline-none transition"
                   required>
          </div>

          {{-- Email --}}
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">
              Email Address
            </label>
            <input type="email"
                   name="email"
                   value="{{ $user->email }}"
                   class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                          focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
                          outline-none transition"
                   required>
          </div>

          {{-- Status --}}
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">
              Account Status
            </label>
        <select name="status"
        class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl
               focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
               outline-none transition">

  <option value="active"
          {{ $user->status == 'active' ? 'selected' : '' }}>
      Active
  </option>

  <option value="deactivate"
          {{ $user->status == 'deactivate' ? 'selected' : '' }}>
      Deactivated
  </option>

</select>

          </div>

          {{-- Footer --}}
          <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
            <button type="button"
                    data-hs-overlay="#edit-user-modal-{{ $user->id }}"
                    class="px-5 py-2.5 text-sm font-medium border border-gray-300 
                           rounded-xl hover:bg-gray-100 transition">
              Cancel
            </button>

            <button type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white 
                           bg-blue-600 rounded-xl 
                           hover:bg-blue-700 transition shadow-sm">
              Save Changes
            </button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>
@endforeach

  

    </main>
  </div>
<script src="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.js"></script>
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