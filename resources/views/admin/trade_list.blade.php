    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sociotix Light Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                <h2 class="text-lg font-medium text-gray-800">Trades</h2>
                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full">
                    {{ $trades->count() }} trades
                </span>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    List of available skilled trades in the system.
                </p>
            </div>

            <!-- Add Trade Button inline -->
            <div x-data="{ isOpen: false }" class="mt-4 sm:mt-0">
         <button @click="isOpen = true"
        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium
               text-blue-700 bg-blue-50 border border-blue-200 rounded-lg
               hover:bg-blue-100
               focus:outline-none focus:ring-2 focus:ring-blue-200 transition">

        <!-- Plus Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 4v16m8-8H4"/>
        </svg>

        Add Trade
    </button>

                <!-- Modal -->
                <div x-show="isOpen"
                    x-transition:enter="transition duration-300 ease-out"
                    x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                    x-transition:leave="transition duration-150 ease-in"
                    x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                    x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                    class="fixed inset-0 z-10 overflow-y-auto"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true"
                    style="display: none;">
                <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>

                    <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-md sm:p-6 sm:align-middle">
                    <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize" id="modal-title">
                        Add New Trade
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Enter the trade name and description below.
                    </p>

               <form class="mt-4" method="POST" action="{{ route('admin.trades.store') }}">
    @csrf

    <label class="block mt-3 text-sm text-gray-700" for="name">Trade Name</label>
    <input type="text" name="name" id="name" placeholder="e.g. Plumbing"
           class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" required>

    <label class="block mt-3 text-sm text-gray-700" for="description">Description</label>
    <textarea name="description" id="description" rows="3" placeholder="Description of this trade"
              class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"></textarea>

    <div class="mt-4 sm:flex sm:items-center sm:-mx-2">
        <button type="button" @click="isOpen = false"
                class="w-full px-4 py-2 text-sm font-medium tracking-wide text-gray-700 transition-colors duration-300 transform border border-gray-200 rounded-md sm:w-1/2 sm:mx-2 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
            Cancel
        </button>

        <button type="submit"
                class="w-full px-4 py-2 mt-3 text-sm font-medium tracking-wide text-white transition-colors duration-300 transform bg-blue-600 rounded-md sm:mt-0 sm:w-1/2 sm:mx-2 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
            Add Trade
        </button>
    </div>
</form>


                    </div>
                </div>
                </div>
            </div>
            </div>

<!-- Trades Table -->
<div class="flex flex-col mt-6">
  <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
      <div class="overflow-hidden border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Trade Name</th>
              <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
              <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
              <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
          </thead>

          <tbody class="bg-white divide-y divide-gray-200">
            @forelse($trades as $trade)
              <tr x-data="{ isEditOpen: false, name: '{{ $trade->name }}', description: '{{ $trade->description }}' }">
                <td class="px-4 py-4 text-sm font-medium text-gray-800">{{ $trade->name }}</td>
                <td class="px-4 py-4 text-sm text-gray-700">{{ $trade->description }}</td>
                <td class="px-4 py-4 text-sm text-gray-500">{{ $trade->created_at->format('M d, Y') }}</td>
                <td class="px-4 py-4 text-center text-sm">
              <button @click="isEditOpen = true"
        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
               text-gray-700 bg-white border border-gray-300 rounded-lg
               hover:bg-gray-50 hover:border-gray-400
               focus:outline-none focus:ring-2 focus:ring-gray-200 transition">

        <!-- Pencil Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-4 h-4 text-gray-500"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15.232 5.232l3.536 3.536M9 11l6-6m-6 6v4h4"/>
        </svg>

        Edit
    </button>

        
                  <div x-show="isEditOpen" class="fixed inset-0 z-20 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
             
                    <div x-show="isEditOpen" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-50"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-50"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-black"
                         style="opacity: 0.5;"></div>

                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                      <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>

                      <div x-show="isEditOpen"
                           x-transition:enter="transition ease-out duration-300"
                           x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                           x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                           x-transition:leave="transition ease-in duration-200"
                           x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                           x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                           class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:w-full sm:max-w-md sm:p-6 sm:align-middle">
                        
                        <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize" id="modal-title">
                            Update Trade
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Modify the trade name and description below.
                        </p>

                        <form class="mt-4" method="POST" action="{{ route('admin.trades.update', $trade->id) }}">
                          @csrf
                      

                          <label class="block mt-3 text-sm text-gray-700" for="edit-name-{{ $trade->id }}">Trade Name</label>
                          <input type="text" name="name" id="edit-name-{{ $trade->id }}" x-model="name"
                                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" required>

                          <label class="block mt-3 text-sm text-gray-700" for="edit-description-{{ $trade->id }}">Description</label>
                          <textarea name="description" id="edit-description-{{ $trade->id }}" rows="3" x-model="description"
                                    class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40"></textarea>

                          <div class="mt-4 sm:flex sm:items-center sm:-mx-2">
                            <button type="button" @click="isEditOpen = false"
                                    class="w-full px-4 py-2 text-sm font-medium tracking-wide text-gray-700 transition-colors duration-300 transform border border-gray-200 rounded-md sm:w-1/2 sm:mx-2 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
                                Cancel
                            </button>

                            <button type="submit"
                                    class="w-full px-4 py-2 mt-3 text-sm font-medium tracking-wide text-white transition-colors duration-300 transform bg-blue-600 rounded-md sm:mt-0 sm:w-1/2 sm:mx-2 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
                                Update Trade
                            </button>
                          </div>
                        </form>

                      </div>
                    </div>
                  </div>
                  
    <form method="POST"
          action="{{ route('admin.trades.delete', $trade->id) }}"
          onsubmit="return confirm('Are you sure you want to delete this trade?');"
          class="inline-block">
        @csrf
        @method('DELETE')

        <button type="submit"
            class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
                   text-red-700 bg-red-50 border border-red-200 rounded-lg
                   hover:bg-red-100
                   focus:outline-none focus:ring-2 focus:ring-red-200 transition">

          
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-4 h-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 7h12M9 7v12m6-12v12M10 7l1-2h2l1 2"/>
            </svg>

            Delete
        </button>
    </form>

                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-4 py-4 text-center text-gray-500">No trades found.</td>
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
