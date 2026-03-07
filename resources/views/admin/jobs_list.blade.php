<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sociotix Light Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <link rel="stylesheet" href="https://preline.co/assets/css/main.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#f8fafc]">
@include('notifications.notifications')
    @include('admin.navigation-bar-admin.navbar-admin')

    <div class="w-full lg:ps-64">

        <header
            class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white/80 backdrop-blur-md border-b py-3 px-4 sm:px-6 md:px-8">
            <div class="w-full flex items-center justify-between gap-x-5">
                <div class="relative w-full max-w-md">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </div>
                    {{-- ✅ Search input --}}
                    <input type="text"
                        id="jobSearch"
                        onkeyup="filterJobs()"
                        class="py-2 px-3 ps-10 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Search by title, client, trade, status...">
                </div>

                <div class="flex flex-row items-center justify-end gap-2">
                    <button
                        class="w-[2.375rem] h-[2.375rem] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                            <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                        </svg>
                    </button>
                    <img class="inline-block h-[2.375rem] w-[2.375rem] rounded-full ring-2 ring-white"
                        src="https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?auto=format&fit=facearea&facepad=2&w=300&h=300&q=80"
                        alt="Avatar">
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-6 space-y-6">
            <section class="container px-4 mx-auto">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <div>
                        <div class="flex items-center gap-x-3">
                            <h2 class="text-lg font-medium text-gray-800">Posted Jobs</h2>
                            {{-- ✅ Badge with id for live count update --}}
                            <span id="jobCount" class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full">
                                {{ $jobs->count() }} Jobs
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            List of all jobs posted by clients in the system.
                        </p>
                    </div>
                </div>

                <!-- Jobs Table -->
                <div class="flex flex-col mt-6">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden border border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">

                                    <!-- Table Head -->
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trade</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Budget</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Worker</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                        </tr>
                                    </thead>

                                    <!-- Table Body -->
                                    {{-- ✅ tbody with id --}}
                                    <tbody id="jobsTableBody" class="bg-white divide-y divide-gray-200">
                                       @forelse($jobs as $job)
                                        {{-- ✅ data-row on each tr; searchable data attributes --}}
                                        <tr data-row
                                            x-data="{ 
                                                isEditOpen: false, 
                                                isDeleteOpen: false,
                                                title: '{{ $job->title }}', 
                                                description: '{{ $job->description }}', 
                                                budget: '{{ $job->budget }}', 
                                                trade: '{{ $job->trade->id ?? '' }}', 
                                                status: '{{ $job->status }}',
                                                workerName: '{{ $job->worker ? $job->worker->user->first_name.' '.$job->worker->user->last_name : '' }}',
                                                removeWorker: false
                                            }" 
                                            class="hover:bg-gray-50 transition">

                                            <!-- Title -->
                                            <td data-title class="px-4 py-4 text-sm font-medium text-blue-800 bg-blue-50">
                                                {{ $job->title }}
                                                <p class="text-xs text-blue-600 line-clamp-1">
                                                    {{ $job->description }}
                                                </p>
                                            </td>

                                            <!-- Client -->
                                            <td data-client class="px-4 py-4 text-sm text-gray-700">
                                                {{ optional($job->client)->first_name }} {{ optional($job->client)->last_name }}
                                            </td>

                                            <!-- Trade -->
                                            <td data-trade class="px-4 py-4 text-sm text-gray-700">
                                                {{ $job->trade->name ?? 'N/A' }}
                                            </td>

                                            <!-- Budget -->
                                            <td class="px-4 py-4 text-sm font-semibold text-yellow-800 bg-yellow-50">
                                                ₱{{ number_format($job->budget, 2) }}
                                            </td>

                                            <!-- Status -->
                                            <td class="px-4 py-4 text-sm">
                                                <span data-status class="px-3 py-1 text-xs font-medium rounded-full
                                                    {{ $job->status === 'open' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $job->status === 'assigned' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                    {{ $job->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}">
                                                    {{ ucfirst($job->status) }}
                                                </span>
                                            </td>

                                            <!-- Assigned Worker -->
                                            <td class="px-4 py-4 text-sm text-gray-700">
                                                @if($job->worker)
                                                    <div data-worker class="text-sm font-medium text-green-700">
                                                        {{ $job->worker->user->first_name }}
                                                        {{ $job->worker->user->last_name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $job->worker->user->email }}
                                                    </div>
                                                @else
                                                    <span data-worker class="text-gray-400 text-sm">Not assigned</span>
                                                @endif
                                            </td>

                                            <!-- Created -->
                                            <td class="px-4 py-4 text-sm text-gray-500">
                                                {{ $job->created_at->format('M d, Y') }}
                                            </td>

                                           {{-- Actions --}}
<td class="px-4 py-4 text-sm">
    <div class="hs-dropdown relative inline-flex">

        {{-- 3-dot trigger --}}
        <button type="button"
                class="hs-dropdown-toggle w-8 h-8 inline-flex items-center justify-center
                       rounded-lg border border-gray-200 bg-white text-gray-500
                       hover:bg-gray-50 hover:border-gray-300
                       focus:outline-none focus:ring-2 focus:ring-gray-200 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
            </svg>
        </button>

        {{-- Dropdown --}}
        <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 hidden z-10
                    min-w-[150px] bg-white border border-gray-200 rounded-xl shadow-lg p-1 mt-1">

            {{-- View & Edit --}}
            <button type="button"
                    @click="isEditOpen = true"
                    class="w-full flex items-center gap-3 px-3 py-2 text-sm text-gray-700
                           rounded-lg hover:bg-gray-50 transition text-left">
                <iconify-icon icon="solar:pen-linear" width="15" class="text-gray-400"></iconify-icon>
                View & Edit
            </button>

            <div class="my-1 border-t border-gray-100"></div>

            {{-- Delete — disabled if assigned or completed --}}
            @if(in_array($job->status, ['assigned', 'completed']))
                <div class="w-full flex items-center gap-3 px-3 py-2 text-sm text-gray-300 rounded-lg cursor-not-allowed">
                    <iconify-icon icon="solar:trash-bin-minimalistic-linear" width="15" class="text-gray-300"></iconify-icon>
                    Delete
                </div>
            @else
                <button type="button"
                        @click="isDeleteOpen = true"
                        class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600
                               rounded-lg hover:bg-red-50 transition text-left">
                    <iconify-icon icon="solar:trash-bin-minimalistic-linear" width="15" class="text-red-400"></iconify-icon>
                    Delete
                </button>
            @endif

        </div>
    </div>

    {{-- ════════════════════════════
         EDIT MODAL
    ════════════════════════════ --}}
    <div x-show="isEditOpen"
         class="fixed inset-0 z-[80] overflow-y-auto"
         role="dialog" aria-modal="true">

        <div x-show="isEditOpen" x-transition.opacity
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
                        sm:my-8 sm:w-full sm:max-w-lg sm:p-6 sm:align-middle">

                <h3 class="text-lg font-medium leading-6 text-gray-800">Edit Job</h3>
                <p class="mt-1 text-sm text-gray-500">Update job details below.</p>

                <form class="mt-4 space-y-3" method="POST" action="{{ route('admin.jobs.update', $job->id) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Client</label>
                        <input type="text"
                               value="{{ optional($job->client)->first_name }} {{ optional($job->client)->last_name }}"
                               disabled
                               class="block w-full px-4 py-3 text-sm text-gray-500 bg-gray-100 border border-gray-200 rounded-md cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" x-model="title" required
                               class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" x-model="description"
                                  class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Budget</label>
                        <input type="number" name="budget" x-model="budget" step="0.01" required
                               class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Trade</label>
                        <select name="trade_id" x-model="trade"
                                class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($trades as $t)
                                <option value="{{ $t->id }}" @if($job->trade_id == $t->id) selected @endif>{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Worker</label>
                        <div class="flex items-center gap-2">
                            <input type="text" x-model="workerName" disabled
                                   class="flex-1 px-4 py-3 text-sm text-gray-500 bg-gray-100 border border-gray-200 rounded-md cursor-not-allowed">
                            @if($job->status !== 'completed')
                                <button type="button"
                                        x-show="workerName"
                                        @click="workerName = ''; removeWorker = true; status = 'open';"
                                        class="px-3 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-md hover:bg-red-100">
                                    Remove
                                </button>
                            @endif
                        </div>
                        <input type="hidden" name="remove_worker" :value="removeWorker ? 1 : 0">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Status</label>
                        <select name="status" x-model="status"
                                class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="open"      @if($job->status=='open')      selected @endif>Open</option>
                            <option value="assigned"  @if($job->status=='assigned')  selected @endif>Assigned</option>
                            <option value="completed" @if($job->status=='completed') selected @endif>Completed</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="isEditOpen = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-md hover:bg-slate-800">
                            Update Job
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

        <div x-show="isDeleteOpen" x-transition.opacity
             class="fixed inset-0 bg-black/50"
             @click="isDeleteOpen = false"></div>

        <div class="flex items-center justify-center min-h-screen px-4">
            <div x-show="isDeleteOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative bg-white rounded-lg shadow-xl w-full max-w-sm p-6">

                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <iconify-icon icon="solar:trash-bin-minimalistic-linear" width="18" class="text-red-600"></iconify-icon>
                    </div>
                    <h3 class="text-base font-semibold text-gray-800">Delete Job</h3>
                </div>

                <p class="text-sm text-gray-600 mb-5">
                    Are you sure you want to delete
                    <strong class="text-gray-800">{{ $job->title }}</strong>?
                    This action cannot be undone.
                </p>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="isDeleteOpen = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                        Cancel
                    </button>
                    <form method="POST" action="{{ route('admin.jobs.delete', $job->id) }}">
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
                                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                                No jobs found.
                                            </td>
                                        </tr>
                                        @endforelse

                                        {{-- ✅ "No results" row shown by JS when search yields nothing --}}
                                        <tr id="noResultsRow" style="display: none;">
                                            <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                                                <svg class="mx-auto mb-2 w-8 h-8 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                                                </svg>
                                                No jobs match your search.
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

    {{-- ✅ Search filter script --}}
    <script>
    function filterJobs() {
        const query = document.getElementById('jobSearch').value.toLowerCase().trim();
        const rows = document.querySelectorAll('#jobsTableBody tr[data-row]');
        const noResultsRow = document.getElementById('noResultsRow');
        let visibleCount = 0;

        rows.forEach(row => {
            const title  = row.querySelector('[data-title]')?.textContent.toLowerCase()  || '';
            const client = row.querySelector('[data-client]')?.textContent.toLowerCase() || '';
            const trade  = row.querySelector('[data-trade]')?.textContent.toLowerCase()  || '';
            const status = row.querySelector('[data-status]')?.textContent.toLowerCase() || '';
            const worker = row.querySelector('[data-worker]')?.textContent.toLowerCase() || '';

            const match = title.includes(query)
                       || client.includes(query)
                       || trade.includes(query)
                       || status.includes(query)
                       || worker.includes(query);

            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });

        // Show "no results" row if nothing matched
        if (noResultsRow) {
            noResultsRow.style.display = visibleCount === 0 ? '' : 'none';
        }

        // Update badge count
        const badge = document.getElementById('jobCount');
        if (badge) {
            badge.textContent = visibleCount + (visibleCount === 1 ? ' Job' : ' Jobs');
        }
    }
    </script>

</body>

</html>