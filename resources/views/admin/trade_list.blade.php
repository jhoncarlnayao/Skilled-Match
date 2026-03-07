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
@include('notifications.notifications')
@include('admin.navigation-bar-admin.navbar-admin')



<div class="w-full lg:ps-64">
    
    <header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white/80 backdrop-blur-md border-b py-3 px-4 sm:px-6 md:px-8">
    <div class="w-full flex items-center justify-between gap-x-5">
        <div class="relative w-full max-w-md">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>
        {{-- ✅ Search input with id and onkeyup handler --}}
        <input
            type="text"
            id="tradeSearch"
            class="py-2 px-3 ps-10 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Search trades..."
            onkeyup="filterTrades()"
        >
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
            {{-- ✅ Badge now has id so JS can update the count --}}
            <span id="tradeCount" class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full">
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

          {{-- ✅ tbody needs an id for JS to target rows --}}
     <tbody id="tradesTableBody" class="bg-white divide-y divide-gray-200">
    @forelse($trades as $trade)
        <tr data-row
            x-data="{
                isEditOpen: false,
                isDeleteOpen: false,
                name: '{{ $trade->name }}',
                description: '{{ $trade->description }}'
            }">

            <td data-name class="px-4 py-4 text-sm font-medium text-gray-800">{{ $trade->name }}</td>
            <td data-desc class="px-4 py-4 text-sm text-gray-700">{{ $trade->description }}</td>
            <td class="px-4 py-4 text-sm text-gray-500">{{ $trade->created_at->format('M d, Y') }}</td>

            {{-- Actions --}}
            <td class="px-4 py-4 text-center text-sm">

                {{-- 3-dot dropdown --}}
                <div class="hs-dropdown relative inline-flex">

                    <button type="button"
                            class="hs-dropdown-toggle w-8 h-8 inline-flex items-center justify-center
                                   rounded-lg border border-gray-200 bg-white text-gray-500
                                   hover:bg-gray-50 hover:border-gray-300
                                   focus:outline-none focus:ring-2 focus:ring-gray-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                        </svg>
                    </button>

                    <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 hidden z-10
                                min-w-[140px] bg-white border border-gray-200 rounded-xl shadow-lg p-1 mt-1">

                        {{-- Edit --}}
                        <button type="button"
                                @click="isEditOpen = true"
                                class="w-full flex items-center gap-3 px-3 py-2 text-sm text-gray-700
                                       rounded-lg hover:bg-gray-50 transition text-left">
                            <iconify-icon icon="solar:pen-linear" width="15" class="text-gray-400"></iconify-icon>
                            Edit
                        </button>

                        <div class="my-1 border-t border-gray-100"></div>

                        {{-- Delete --}}
                        <button type="button"
                                @click="isDeleteOpen = true"
                                class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600
                                       rounded-lg hover:bg-red-50 transition text-left">
                            <iconify-icon icon="solar:trash-bin-minimalistic-linear" width="15" class="text-red-400"></iconify-icon>
                            Delete
                        </button>

                    </div>
                </div>

                {{-- ════════════════════════════
                     EDIT MODAL
                ════════════════════════════ --}}
                <div x-show="isEditOpen"
                     class="fixed inset-0 z-[80] overflow-y-auto"
                     role="dialog" aria-modal="true">

                    {{-- Backdrop --}}
                    <div x-show="isEditOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-black/50"
                         @click="isEditOpen = false"></div>

                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>

                        <div x-show="isEditOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom
                                    transform bg-white rounded-lg shadow-xl
                                    sm:my-8 sm:w-full sm:max-w-md sm:p-6 sm:align-middle">

                            <h3 class="text-lg font-medium leading-6 text-gray-800">Update Trade</h3>
                            <p class="mt-1 text-sm text-gray-500">Modify the trade name and description below.</p>

                            <form class="mt-4 space-y-3" method="POST" action="{{ route('admin.trades.update', $trade->id) }}">
                                @csrf

                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Trade Name</label>
                                    <input type="text" name="name" x-model="name" required
                                           class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-700 mb-1">Description</label>
                                    <textarea name="description" rows="3" x-model="description"
                                              class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>

                                <div class="mt-4 flex justify-end gap-2">
                                    <button type="button" @click="isEditOpen = false"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-md hover:bg-slate-800">
                                        Update Trade
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- ════════════════════════════
                     DELETE MODAL
                ════════════════════════════ --}}
                <div x-show="isDeleteOpen"
                     class="fixed inset-0 z-[80] overflow-y-auto"
                     role="dialog" aria-modal="true">

                    {{-- Backdrop --}}
                    <div x-show="isDeleteOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 bg-black/50"
                         @click="isDeleteOpen = false"></div>

                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>

                        <div x-show="isDeleteOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom
                                    transform bg-white rounded-lg shadow-xl
                                    sm:my-8 sm:w-full sm:max-w-sm sm:p-6 sm:align-middle">

                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                    <iconify-icon icon="solar:trash-bin-minimalistic-linear" width="18" class="text-red-600"></iconify-icon>
                                </div>
                                <h3 class="text-base font-semibold text-gray-800">Confirm Delete</h3>
                            </div>

                            <p class="text-sm text-gray-600 mb-5">
                                Are you sure you want to delete <strong>{{ $trade->name }}</strong>? This action cannot be undone.
                            </p>

                            <div class="flex justify-end gap-2">
                                <button type="button" @click="isDeleteOpen = false"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                                    Cancel
                                </button>
                                <form method="POST" action="{{ route('admin.trades.delete', $trade->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                                        Yes, Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </td>
        </tr>
    @empty
        <tr id="emptyRow">
            <td colspan="4" class="px-4 py-4 text-center text-gray-500">No trades found.</td>
        </tr>
    @endforelse

    <tr id="noResultsRow" style="display: none;">
        <td colspan="4" class="px-4 py-8 text-center text-gray-400">
            <svg class="mx-auto mb-2 w-8 h-8 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
            </svg>
            No trades match your search.
        </td>
    </tr>
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


<script>
function filterTrades() {
    const query = document.getElementById('tradeSearch').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#tradesTableBody tr[data-row]');
    const noResultsRow = document.getElementById('noResultsRow');
    let visibleCount = 0;

    rows.forEach(row => {
        const name = row.querySelector('[data-name]')?.textContent.toLowerCase() || '';
        const desc = row.querySelector('[data-desc]')?.textContent.toLowerCase() || '';
        const match = name.includes(query) || desc.includes(query);
        row.style.display = match ? '' : 'none';
        if (match) visibleCount++;
    });

    // Show "no results" row if nothing matched
    if (noResultsRow) {
        noResultsRow.style.display = visibleCount === 0 ? '' : 'none';
    }

    // Update the badge count
    const badge = document.getElementById('tradeCount');
    if (badge) {
        badge.textContent = visibleCount + (visibleCount === 1 ? ' trade' : ' trades');
    }
}
</script>

</body>
</html>