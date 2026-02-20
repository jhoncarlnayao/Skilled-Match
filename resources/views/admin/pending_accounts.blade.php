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
        <h2 class="text-lg font-medium text-gray-800">Workers Account List</h2>
        <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full">240 vendors</span>
      </div>
      <p class="mt-1 text-sm text-gray-500">These companies have purchased in the last 12 months.</p>
    </div>

<div class="flex items-center mt-4 gap-x-3">
     
    <a href="{{ route('admin.pending.accounts', ['status' => 'pending']) }}"
       class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 rounded-lg shadow-sm 
              text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-gray-900
              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-300 transition-all
              {{ $status === 'pending' ? 'bg-yellow-500 text-white hover:bg-yellow-600' : '' }}">
        <iconify-icon icon="solar:clock-linear" stroke-width="1.5" class="mr-2 text-lg"></iconify-icon>
        Pending Accounts
    </a>


    <a href="{{ route('admin.pending.accounts', ['status' => 'approved']) }}"
       class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 rounded-lg shadow-sm 
              text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:text-gray-900
              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-300 transition-all
              {{ $status === 'approved' ? 'bg-green-600 text-white hover:bg-green-700' : '' }}">
        <iconify-icon icon="solar:check-circle-linear" stroke-width="1.5" class="mr-2 text-lg"></iconify-icon>
        Approved Accounts
    </a>
</div>



  </div>


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

<td class="px-12 py-4">
    @if(strtolower($user->status) === 'approved')
        <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium
                     text-green-700 bg-green-50 border border-green-200 rounded-full">
            
         
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-3.5 h-3.5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>

            {{ ucfirst($user->status) }}
        </span>
    @elseif(strtolower($user->status) === 'pending')
        <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium
                     text-yellow-700 bg-yellow-100 rounded-full">
            
          
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-3.5 h-3.5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6v6l4 2M12 3a9 9 0 110 18 9 9 0 010-18z"/>
            </svg>

            {{ ucfirst($user->status) }}
        </span>
    @else
      
        <span class="inline-block px-3 py-1 text-sm font-normal text-gray-700 bg-gray-100 rounded-full">
            {{ ucfirst($user->status) }}
        </span>
    @endif
</td>

             
              <td class="px-4 py-4 text-sm">
                  <p class="text-gray-700">{{ $user->role }}</p>
                  <p class="text-gray-500 text-sm">
                      Joined: {{ $user->created_at->format('M d, Y') }}
                  </p>
              </td>

              
<td class="px-4 py-4 text-sm">

   @if($status === 'pending')
<div class="flex gap-2">
<a href="{{ route('admin.pending.approve', $user->id) }}"
   class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
          text-gray-700 bg-white border border-gray-300 rounded-lg
          hover:bg-gray-50 hover:border-gray-400
          focus:outline-none focus:ring-2 focus:ring-gray-200 transition">


    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-4 h-4 text-gray-500"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
    Approve
</a>
<a href="{{ route('admin.pending.reject', $user->id) }}"
   class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
          text-red-700 bg-red-50 border border-red-200 rounded-lg
          hover:bg-red-100
          focus:outline-none focus:ring-2 focus:ring-red-200 transition">


    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-4 h-4 text-red-700"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
    Reject
</a>
</div>
@endif
</td>
          </tr>
          @empty
          <tr>
              <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                  No pending users found.
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
    </main>
  </div>

  <script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>
</html>