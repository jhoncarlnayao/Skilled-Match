<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Jobs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="https://preline.co/assets/css/main.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc]">

@include('notifications.notifications')
@include('client.navigation-bar-client.navbar-client')

<div class="w-full lg:ps-64" x-data="{
    openModal: false,
    search: '',
    statusFilter: 'all',
    editOpen: false,
    selectedJob: {},
    deleteOpen: false,
    deleteId: null
}">

    {{-- ── HEADER ── --}}
    <header class="sticky top-0 inset-x-0 flex flex-wrap sm:flex-nowrap z-[48] w-full bg-white/80 backdrop-blur-md border-b py-3 px-4 sm:px-6 md:px-8">
        <div class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative w-full sm:max-w-md">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                </div>
                <input type="text" x-model="search" placeholder="Search job title..."
                    class="py-2 px-3 ps-10 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:border-slate-900 focus:ring-slate-900">
            </div>
            <div class="w-full sm:w-48">
                <select x-model="statusFilter"
                    class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
                    <option value="all">All Status</option>
                    <option value="open">Open</option>
                    <option value="assigned">Assigned</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>
    </header>

    {{-- ── MAIN ── --}}
    <main class="flex-1 p-6 lg:p-8 bg-slate-50">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-xl font-semibold text-slate-900 tracking-tight">My Jobs</h1>
                <p class="text-sm text-slate-500 mt-1">Manage {{ $jobs->count() }} posted jobs.</p>
            </div>
            <button @click="openModal = true"
                class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition shadow-sm">
                <iconify-icon icon="solar:add-circle-linear" width="18"></iconify-icon>
                Post New Job
            </button>
        </div>

        {{-- Table --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Budget</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Worker</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($jobs as $job)
                            <tr class="hover:bg-gray-50 transition" x-show="
                                (statusFilter === 'all' || statusFilter === '{{ $job->status }}') &&
                                ('{{ strtolower($job->title) }}'.includes(search.toLowerCase()))
                            ">
                                {{-- Title --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-800">{{ $job->title }}</div>
                                    <div class="text-xs text-gray-500 line-clamp-1">{{ $job->description }}</div>
                                    <div class="text-xs text-gray-400 mt-1">{{ $job->created_at->format('M d, Y') }}</div>
                                </td>

                                {{-- Trade --}}
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $job->trade->name ?? 'N/A' }}</td>

                                {{-- Location --}}
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $job->location }}</td>

                                {{-- Budget --}}
                                <td class="px-6 py-4 text-sm font-semibold text-yellow-700">
                                    ₱{{ number_format($job->budget, 2) }}
                                </td>

                                {{-- Worker --}}
                                <td class="px-6 py-4 text-sm">
                                    @if($job->worker)
                                        <div class="font-medium text-emerald-700">
                                            {{ $job->worker->user->first_name }} {{ $job->worker->user->last_name }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $job->worker->user->email }}</div>
                                    @else
                                        <span class="text-gray-400">Not assigned</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        {{ $job->status === 'open'        ? 'bg-blue-100 text-blue-700'     : '' }}
                                        {{ $job->status === 'assigned'    ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $job->status === 'in_progress' ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $job->status === 'completed'   ? 'bg-emerald-100 text-emerald-700' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                                    </span>
                                </td>

                                {{-- Actions — clean 3-dot dropdown --}}
                                <td class="px-6 py-4 text-sm">
                                    <div class="hs-dropdown relative inline-flex">

                                        {{-- Trigger --}}
                                        <button type="button"
                                                id="job-menu-{{ $job->id }}"
                                                class="hs-dropdown-toggle w-8 h-8 inline-flex items-center justify-center
                                                       rounded-lg border border-gray-200 bg-white text-gray-500
                                                       hover:bg-gray-50 hover:border-gray-300
                                                       focus:outline-none focus:ring-2 focus:ring-gray-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                            </svg>
                                        </button>

                                        {{-- Dropdown Menu --}}
                                        <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 hidden z-10 min-w-[160px]
                                                    bg-white border border-gray-200 rounded-xl shadow-lg p-1 mt-1"
                                             aria-labelledby="job-menu-{{ $job->id }}">

                                            {{-- Edit --}}
                                            <button type="button"
                                                @click="
                                                    selectedJob = {
                                                        id: {{ $job->id }},
                                                        title: '{{ addslashes($job->title) }}',
                                                        description: `{{ addslashes($job->description) }}`,
                                                        trade_id: '{{ $job->trade_id }}',
                                                        budget: '{{ $job->budget }}',
                                                        location: '{{ addslashes($job->location) }}'
                                                    };
                                                    editOpen = true;
                                                "
                                                class="w-full flex items-center gap-3 px-3 py-2 text-sm text-gray-700
                                                       rounded-lg hover:bg-gray-50 transition text-left">
                                                <iconify-icon icon="solar:pen-linear" width="15" class="text-gray-400"></iconify-icon>
                                                Edit Job
                                            </button>

                                            {{-- View Worker --}}
                                            @if($job->worker)
                                                <button type="button"
                                                        onclick="openWorkerModal({{ $job->id }})"
                                                        data-hs-overlay="#view-worker-modal"
                                                        class="w-full flex items-center gap-3 px-3 py-2 text-sm text-gray-700
                                                               rounded-lg hover:bg-blue-50 hover:text-blue-600 transition text-left">
                                                    <iconify-icon icon="solar:user-id-linear" width="15" class="text-gray-400"></iconify-icon>
                                                    View Worker
                                                </button>
                                            @endif

                                            {{-- Mark Complete --}}
                                            @if(in_array($job->status, ['assigned', 'in_progress']))
                                                <form action="{{ route('client.jobs.complete', $job->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full flex items-center gap-3 px-3 py-2 text-sm text-emerald-600
                                                               rounded-lg hover:bg-emerald-50 transition text-left">
                                                        <iconify-icon icon="solar:check-circle-linear" width="15" class="text-emerald-400"></iconify-icon>
                                                        Mark Complete
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Divider --}}
                                            @if(!in_array($job->status, ['assigned','in_progress']))
                                                <div class="my-1 border-t border-gray-100"></div>

                                                {{-- Delete --}}
                                                <button type="button"
                                                    @click="deleteId = {{ $job->id }}; deleteOpen = true;"
                                                    class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600
                                                           rounded-lg hover:bg-red-50 transition text-left">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-linear" width="15" class="text-red-400"></iconify-icon>
                                                    Delete Job
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-center text-gray-500">No jobs posted yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        {{-- ════════════════════════════════════════
             EDIT JOB MODAL (Alpine)
        ═════════════════════════════════════════ --}}
        <div x-show="editOpen" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display:none;">
            <div x-show="editOpen" x-transition
                class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Edit Job</h3>
                <form :action="'/client/jobs/' + selectedJob.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="text-sm text-gray-600">Title</label>
                        <input type="text" name="title" x-model="selectedJob.title"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Description</label>
                        <textarea name="description" x-model="selectedJob.description" rows="3"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-lg text-sm"></textarea>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Trade</label>
                        <select name="trade_id" x-model="selectedJob.trade_id"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-lg text-sm">
                            @foreach($trades as $trade)
                                <option value="{{ $trade->id }}">{{ $trade->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Budget</label>
                        <input type="number" name="budget" x-model="selectedJob.budget"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Location</label>
                        <input type="text" name="location" x-model="selectedJob.location"
                            class="w-full mt-1 px-4 py-2 border border-gray-200 rounded-lg text-sm">
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="editOpen = false"
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

        {{-- ════════════════════════════════════════
             POST NEW JOB MODAL (Alpine)
        ═════════════════════════════════════════ --}}
        <div x-show="openModal" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
            <div @click.away="openModal = false"
                class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
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
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-slate-900 rounded-md hover:bg-slate-800">
                            Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ════════════════════════════════════════
             DELETE CONFIRMATION MODAL (Alpine)
        ═════════════════════════════════════════ --}}
        <div x-show="deleteOpen" x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display:none;">
            <div x-show="deleteOpen" x-transition
                class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Confirm Deletion</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete this job? This action cannot be undone.</p>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="deleteOpen = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                        Cancel
                    </button>
                    <form :action="'/client/jobs/' + deleteId" method="POST">
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

    </main>
</div>


{{-- ════════════════════════════════════════════════════
     VIEW WORKER MODAL — hs-overlay (matches your admin style)
     Sits outside the Alpine div so z-index works cleanly
═════════════════════════════════════════════════════ --}}
<div id="view-worker-modal"
     class="hs-overlay hidden fixed inset-0 z-[80] overflow-y-auto">

    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle">&#8203;</span>

        <div class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom
                    transition-all transform bg-white rounded-lg shadow-xl
                    sm:my-8 sm:w-full sm:max-w-md sm:p-6 sm:align-middle">

            {{-- Header --}}
            <div class="flex flex-col items-center gap-1 mb-5">
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mb-1">
                    <iconify-icon icon="solar:user-id-linear" width="22" class="text-slate-600"></iconify-icon>
                </div>
                <h3 class="text-lg font-medium leading-6 text-gray-800">Assigned Worker</h3>
                <p class="text-sm text-gray-500 text-center">Worker profile & contact information</p>
            </div>

            {{-- Loading --}}
            <div id="worker-loading" class="flex flex-col items-center justify-center py-10 gap-3">
                <div class="w-9 h-9 border-4 border-slate-200 border-t-slate-900 rounded-full animate-spin"></div>
                <p class="text-sm text-slate-500">Loading worker info...</p>
            </div>

            {{-- Error --}}
            <div id="worker-error" class="hidden flex flex-col items-center justify-center py-10 gap-2">
                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center">
                    <iconify-icon icon="solar:user-cross-linear" width="24" class="text-red-400"></iconify-icon>
                </div>
                <p class="text-sm font-medium text-gray-700">Could not load worker</p>
                <p id="worker-error-msg" class="text-xs text-gray-400 text-center"></p>
            </div>

            {{-- Worker Info --}}
            <div id="worker-info" class="hidden space-y-4">

                {{-- Avatar + Name --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="relative group w-24 h-24">
                        <img id="worker-avatar-img" src=""
                             class="w-24 h-24 rounded-full ring-2 ring-gray-200 object-cover hidden" />
                        <div id="worker-avatar-initials"
                             class="w-24 h-24 rounded-full ring-2 ring-gray-200 bg-slate-100
                                    flex items-center justify-center hidden">
                            <span id="worker-initials-text" class="text-2xl font-bold text-slate-600"></span>
                        </div>
                    </div>
                    <div class="text-center">
                        <h4 id="worker-full-name" class="text-base font-semibold text-gray-800"></h4>
                        <p id="worker-trade" class="text-sm text-gray-500 mt-0.5"></p>
                        <span id="worker-experience"
                              class="hidden inline-flex items-center gap-1 mt-1 px-2 py-0.5
                                     bg-amber-50 border border-amber-200 rounded-full
                                     text-xs text-amber-700 font-medium">
                            <iconify-icon icon="solar:star-linear" width="11"></iconify-icon>
                            <span id="worker-experience-text"></span>
                        </span>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Fields --}}
                <div class="space-y-3">

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Email</label>
                        <div class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md flex items-center gap-2">
                            <iconify-icon icon="solar:letter-linear" width="15" class="text-gray-400 flex-shrink-0"></iconify-icon>
                            <span id="worker-email" class="truncate">—</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Phone</label>
                        <div class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md flex items-center gap-2">
                            <iconify-icon icon="solar:phone-linear" width="15" class="text-gray-400 flex-shrink-0"></iconify-icon>
                            <span id="worker-phone">—</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Username</label>
                        <div class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md flex items-center gap-2">
                            <iconify-icon icon="solar:tag-linear" width="15" class="text-gray-400 flex-shrink-0"></iconify-icon>
                            <span id="worker-username">—</span>
                        </div>
                    </div>

                    <div id="worker-address-row" class="hidden">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Address</label>
                        <div class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md flex items-center gap-2">
                            <iconify-icon icon="solar:map-point-linear" width="15" class="text-gray-400 flex-shrink-0"></iconify-icon>
                            <span id="worker-address">—</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-6 flex justify-end gap-2">
                <button type="button"
                        data-hs-overlay="#view-worker-modal"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>


{{-- ── SCRIPTS ── --}}
<script>
function openWorkerModal(jobId) {
    // Reset all states
    document.getElementById('worker-loading').classList.remove('hidden');
    document.getElementById('worker-error').classList.add('hidden');
    document.getElementById('worker-info').classList.add('hidden');

    fetch(`/client/jobs/${jobId}/worker`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => {
        if (!res.ok) return res.json().then(d => { throw new Error(d.message || 'Failed to load worker.') });
        return res.json();
    })
    .then(data => {
        // Avatar
        if (data.profile_picture) {
            document.getElementById('worker-avatar-img').src = data.profile_picture;
            document.getElementById('worker-avatar-img').classList.remove('hidden');
            document.getElementById('worker-avatar-initials').classList.add('hidden');
        } else {
            const initials = (data.first_name?.[0] ?? '') + (data.last_name?.[0] ?? '');
            document.getElementById('worker-initials-text').textContent = initials.toUpperCase();
            document.getElementById('worker-avatar-initials').classList.remove('hidden');
            document.getElementById('worker-avatar-img').classList.add('hidden');
        }

        // Name & trade
        const mid = data.middle_name ? data.middle_name + ' ' : '';
        document.getElementById('worker-full-name').textContent = `${data.first_name} ${mid}${data.last_name}`;
        document.getElementById('worker-trade').textContent = data.trade ?? 'Skilled Worker';

        // Experience badge
        if (data.experience_years) {
            document.getElementById('worker-experience-text').textContent = data.experience_years + ' yrs experience';
            document.getElementById('worker-experience').classList.remove('hidden');
        } else {
            document.getElementById('worker-experience').classList.add('hidden');
        }

        // Fields
        document.getElementById('worker-email').textContent    = data.email    || '—';
        document.getElementById('worker-phone').textContent    = data.phone    || '—';
        document.getElementById('worker-username').textContent = data.username ? '@' + data.username : '—';

        if (data.address) {
            document.getElementById('worker-address').textContent = data.address;
            document.getElementById('worker-address-row').classList.remove('hidden');
        } else {
            document.getElementById('worker-address-row').classList.add('hidden');
        }

        document.getElementById('worker-loading').classList.add('hidden');
        document.getElementById('worker-info').classList.remove('hidden');
    })
    .catch(err => {
        document.getElementById('worker-loading').classList.add('hidden');
        document.getElementById('worker-error-msg').textContent = err.message;
        document.getElementById('worker-error').classList.remove('hidden');
    });
}
</script>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</body>
</html>