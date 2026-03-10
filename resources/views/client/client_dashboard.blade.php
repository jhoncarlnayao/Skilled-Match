<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="gemini-api-key" content="{{ env('GEMINI_API_KEY') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sociotix Client Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');
        body { font-family: 'Inter', sans-serif; -webkit-font-smoothing: antialiased; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-slate-50 text-slate-600">
    @include('notifications.notifications')
    @include('client.navigation-bar-client.navbar-client')

    <div class="lg:ml-64 min-h-screen flex flex-col">

        <!-- Top Header -->
        <header class="sticky top-0 z-30 w-full bg-white/80 backdrop-blur-xl border-b border-slate-200">
            <div class="px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center justify-between">
                    <button class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-md">
                        <iconify-icon icon="solar:hamburger-menu-linear" width="24" height="24"></iconify-icon>
                    </button>
                    <div class="hidden sm:flex relative max-w-sm w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <iconify-icon icon="solar:magnifer-linear" width="18" height="18"></iconify-icon>
                        </div>
                        <input type="text"
                            class="block w-full pl-10 pr-3 py-1.5 border border-slate-200 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-1 focus:ring-slate-900 focus:border-slate-900 sm:text-sm transition-shadow"
                            placeholder="Search jobs or workers...">
                    </div>
                    <div class="flex items-center gap-4">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="relative p-2 text-slate-400 hover:text-slate-600 transition-colors">
                                <iconify-icon icon="solar:bell-linear" width="20" height="20"></iconify-icon>
                                @if($announcements->count())
                                    <span class="absolute top-1.5 right-1.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                                @endif
                            </button>
                            <div x-show="open" @click.outside="open = false"
                                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-3 w-96 bg-white border border-slate-200 rounded-xl shadow-xl z-50" style="display: none;">
                                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-slate-900">Admin Announcements</h3>
                                    <span class="text-xs text-slate-400">{{ $announcements->count() }}</span>
                                </div>
                                <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                                    @forelse($announcements as $announcement)
                                        <div class="p-4 hover:bg-slate-50 transition">
                                            <div class="flex items-start gap-3">
                                                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                                                    <iconify-icon icon="solar:notification-unread-linear" width="16"></iconify-icon>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-slate-900">{{ $announcement->title }}</p>
                                                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $announcement->content }}</p>
                                                    <p class="text-[10px] text-slate-400 mt-2">
                                                        {{ $announcement->created_at->diffForHumans() }}
                                                        @if($announcement->admin) • by {{ $announcement->admin->name }} @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-6 text-center text-xs text-slate-500">No announcements available.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="h-8 w-[1px] bg-slate-200 mx-1"></div>
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-medium text-slate-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                                <p class="text-xs text-slate-500">Client Account</p>
                            </div>
                            <a href="{{ route('client.client_profile') }}">
                                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png') }}"
                                    alt="Profile" class="w-8 h-8 rounded-full">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition class="fixed top-5 right-5 z-50">
                <div class="flex items-start gap-3 bg-white border border-emerald-200 shadow-lg rounded-xl p-4 min-w-[280px]">
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg"><iconify-icon icon="solar:check-circle-linear" width="20"></iconify-icon></div>
                    <div class="flex-1"><p class="text-sm font-semibold text-slate-900">Success</p><p class="text-xs text-slate-500 mt-1">{{ session('success') }}</p></div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600"><iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition class="fixed top-5 right-5 z-50">
                <div class="flex items-start gap-3 bg-white border border-red-200 shadow-lg rounded-xl p-4 min-w-[280px]">
                    <div class="p-2 bg-red-50 text-red-600 rounded-lg"><iconify-icon icon="solar:close-circle-linear" width="20"></iconify-icon></div>
                    <div class="flex-1"><p class="text-sm font-semibold text-slate-900">Error</p><p class="text-xs text-slate-500 mt-1">{{ session('error') }}</p></div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600"><iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon></button>
                </div>
            </div>
        @endif

        <!-- Main Dashboard Body -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900 tracking-tight">Overview</h1>
                    <p class="text-sm text-slate-500 mt-1">Manage your posted jobs and track worker progress.</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32">
                    <div class="flex items-start justify-between">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><iconify-icon icon="solar:case-round-linear" width="20" height="20"></iconify-icon></div>
                        <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">+12%</span>
                    </div>
                    <div><p class="text-2xl font-semibold text-slate-900">{{ $totalJobs }}</p><p class="text-xs text-slate-500 font-medium">Active Jobs</p></div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32">
                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg w-fit"><iconify-icon icon="solar:users-group-rounded-linear" width="20" height="20"></iconify-icon></div>
                    <div><p class="text-2xl font-semibold text-slate-900">{{ $activeWorkers }}</p><p class="text-xs text-slate-500 font-medium">Active Workers</p></div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32">
                    <div class="p-2 bg-amber-50 text-amber-600 rounded-lg w-fit"><iconify-icon icon="solar:hourglass-line-linear" width="20" height="20"></iconify-icon></div>
                    <div><p class="text-2xl font-semibold text-slate-900">{{ $completedJobs }}</p><p class="text-xs text-slate-500 font-medium">Completed Jobs</p></div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between h-32">
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg w-fit"><iconify-icon icon="solar:wallet-money-linear" width="20" height="20"></iconify-icon></div>
                    <div><p class="text-2xl font-semibold text-slate-900">$ {{ number_format($totalSpent, 2) }}</p><p class="text-xs text-slate-500 font-medium">Total Spent</p></div>
                </div>
            </div>

            <!-- Content Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Recent Jobs -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-semibold text-slate-900">Recent Jobs</h2>
                        <a href="{{ route('client.client_post_job') }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">View All</a>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                                        <th class="px-6 py-4 font-medium">Job Details</th>
                                        <th class="px-6 py-4 font-medium">Budget</th>
                                        <th class="px-6 py-4 font-medium">Worker Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($jobs as $job)
                                        <tr class="group hover:bg-slate-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                                        <iconify-icon icon="solar:pen-new-square-linear" width="20"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-slate-900">{{ $job->title }}</p>
                                                        <p class="text-xs text-slate-500">Posted {{ $job->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-sm font-medium text-slate-700">{{ $job->budget ? '$' . $job->budget : 'N/A' }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($job->worker)
                                                    <div class="flex items-center gap-2">
                                                        <img src="{{ $job->worker->avatar ?? 'https://via.placeholder.com/24' }}" alt="Worker" class="w-6 h-6 rounded-full ring-2 ring-white">
                                                        <span class="text-xs font-medium text-slate-700">{{ $job->worker->name }}</span>
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-blue-50 text-blue-600 border border-blue-100">In Progress</span>
                                                    </div>
                                                @else
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-6 h-6 rounded-full border border-dashed border-slate-300 flex items-center justify-center text-slate-400">
                                                            <iconify-icon icon="solar:user-linear" width="12"></iconify-icon>
                                                        </div>
                                                        <span class="text-xs font-medium text-slate-400 italic">Unassigned</span>
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200">Open</span>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-slate-500 py-4">No jobs posted today.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-center">
                            <button class="text-xs font-medium text-slate-500 hover:text-slate-900 flex items-center gap-1 transition-colors">
                                Show older jobs <iconify-icon icon="solar:alt-arrow-down-linear"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Quick Post -->
                <div class="space-y-4">
                    <h2 class="text-base font-semibold text-slate-900">Quick Post</h2>
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                        <form action="{{ route('client.jobs.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="title" class="block text-xs font-medium text-slate-700 mb-1.5">Job Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="block w-full rounded-lg border-slate-200 bg-slate-50 text-sm focus:border-slate-900 focus:ring-slate-900 placeholder:text-slate-400 py-2 px-3 shadow-sm transition-all"
                                    placeholder="e.g. Logo Design" required>
                            </div>
                            <div>
                                <label for="trade_id" class="block text-xs font-medium text-slate-700 mb-1.5">Category</label>
                                <div class="relative">
                                    <select name="trade_id" id="trade_id" required
                                        class="block w-full appearance-none rounded-lg border-slate-200 bg-slate-50 text-sm focus:border-slate-900 focus:ring-slate-900 py-2 px-3 shadow-sm transition-all text-slate-600">
                                        <option value="">Select Category</option>
                                        @foreach($trades as $trade)
                                            <option value="{{ $trade->id }}">{{ $trade->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                        <iconify-icon icon="solar:alt-arrow-down-linear" width="12"></iconify-icon>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="budget" class="block text-xs font-medium text-slate-700 mb-1.5">Budget ($)</label>
                                <input type="number" step="0.01" name="budget" id="budget" value="{{ old('budget') }}"
                                    class="block w-full rounded-lg border-slate-200 bg-slate-50 text-sm focus:border-slate-900 focus:ring-slate-900 placeholder:text-slate-400 py-2 px-3 shadow-sm transition-all"
                                    placeholder="0.00">
                            </div>
                            <div>
                                <label for="location" class="block text-xs font-medium text-slate-700 mb-1.5">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location') }}"
                                    class="block w-full rounded-lg border-slate-200 bg-slate-50 text-sm focus:border-slate-900 focus:ring-slate-900 placeholder:text-slate-400 py-2 px-3 shadow-sm transition-all"
                                    placeholder="e.g. Davao City" required>
                            </div>
                            <div>
                                <label for="description" class="block text-xs font-medium text-slate-700 mb-1.5">Description</label>
                                <textarea name="description" id="description" rows="3" required
                                    class="block w-full rounded-lg border-slate-200 bg-slate-50 text-sm focus:border-slate-900 focus:ring-slate-900 placeholder:text-slate-400 py-2 px-3 shadow-sm transition-all resize-none"
                                    placeholder="Briefly describe the task...">{{ old('description') }}</textarea>
                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium py-2.5 px-4 rounded-lg transition-colors shadow-sm">
                                    <iconify-icon icon="solar:add-circle-linear" width="16"></iconify-icon>
                                    Publish Job
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ══════════════════════════════════════════════════════════ -->
            <!-- MY COMPLAINTS SECTION                                          -->
            <!-- ══════════════════════════════════════════════════════════════ -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">My Complaints</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Track the status of your submitted reports</p>
                    </div>
                    @if($myComplaints->where('status', 'pending')->count() > 0)
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium bg-amber-50 text-amber-600 border border-amber-100 px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            {{ $myComplaints->where('status', 'pending')->count() }} Pending
                        </span>
                    @endif
                </div>

                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                                    <th class="px-5 py-3 font-medium">Subject</th>
                                    <th class="px-5 py-3 font-medium">Worker Reported</th>
                                    <th class="px-5 py-3 font-medium">Reason</th>
                                    <th class="px-5 py-3 font-medium">Admin Response</th>
                                    <th class="px-5 py-3 font-medium">Status</th>
                                    <th class="px-5 py-3 font-medium">Date</th>
                                    <th class="px-5 py-3 font-medium text-right">Screenshot</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($myComplaints as $complaint)
                                    @php
                                        $badgeClass = match($complaint->status) {
                                            'pending'   => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'reviewed'  => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'resolved'  => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'dismissed' => 'bg-slate-100 text-slate-500 border-slate-200',
                                            default     => 'bg-slate-100 text-slate-500 border-slate-200',
                                        };
                                        $dotClass = match($complaint->status) {
                                            'pending'   => 'bg-amber-500',
                                            'reviewed'  => 'bg-blue-500',
                                            'resolved'  => 'bg-emerald-500',
                                            default     => 'bg-slate-400',
                                        };
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition-colors">

                                        <!-- Subject + description tooltip -->
                                        <td class="px-5 py-3 max-w-[180px]">
                                            <p class="text-xs font-medium text-slate-900 truncate" title="{{ $complaint->subject }}">
                                                {{ $complaint->subject }}
                                            </p>
                                            <p class="text-[11px] text-slate-400 truncate mt-0.5" title="{{ $complaint->description }}">
                                                {{ Str::limit($complaint->description, 50) }}
                                            </p>
                                        </td>

                                        <!-- Worker name -->
                                        <td class="px-5 py-3">
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-6 h-6 rounded-full bg-red-50 flex items-center justify-center flex-shrink-0">
                                                    <iconify-icon icon="solar:user-id-linear" width="12" class="text-red-400"></iconify-icon>
                                                </div>
                                                <span class="text-xs font-medium text-slate-700">{{ $complaint->worker_name ?? '—' }}</span>
                                            </div>
                                        </td>

                                        <!-- Reason -->
                                        <td class="px-5 py-3">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200 whitespace-nowrap">
                                                {{ $complaint->reason_label }}
                                            </span>
                                        </td>

                                        <!-- Admin notes -->
                                        <td class="px-5 py-3 max-w-[200px]">
                                            @if($complaint->admin_notes)
                                                <p class="text-xs text-slate-600 truncate" title="{{ $complaint->admin_notes }}">
                                                    {{ Str::limit($complaint->admin_notes, 55) }}
                                                </p>
                                            @else
                                                <span class="text-[11px] text-slate-400 italic">Awaiting review…</span>
                                            @endif
                                        </td>

                                        <!-- Status badge -->
                                        <td class="px-5 py-3">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-medium border capitalize {{ $badgeClass }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }} {{ $complaint->status === 'pending' ? 'animate-pulse' : '' }}"></span>
                                                {{ ucfirst($complaint->status) }}
                                            </span>
                                        </td>

                                        <!-- Date -->
                                        <td class="px-5 py-3 text-xs text-slate-400 whitespace-nowrap">
                                            {{ $complaint->created_at->format('M d, Y') }}
                                        </td>

                                        <!-- Screenshot link -->
                                        <td class="px-5 py-3 text-right">
                                            @if($complaint->screenshot)
                                                <a href="{{ $complaint->screenshot_url }}" target="_blank"
                                                    class="inline-flex items-center gap-1 text-[11px] text-blue-500 hover:text-blue-700 font-medium">
                                                    <iconify-icon icon="solar:gallery-linear" width="13"></iconify-icon>
                                                    View
                                                </a>
                                            @else
                                                <span class="text-[11px] text-slate-300">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-12 text-center">
                                            <div class="flex flex-col items-center gap-2">
                                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                                    <iconify-icon icon="solar:shield-check-linear" width="20"></iconify-icon>
                                                </div>
                                                <p class="text-sm font-medium text-slate-500">No complaints submitted yet</p>
                                                <p class="text-xs text-slate-400">Use the red button below to report a worker.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- ════ END MY COMPLAINTS ════ -->

        </main>
    </div>

    <!-- ══════════════════════════════════════════════════════════ -->
    <!-- REPORT WORKER MODAL                                        -->
    <!-- ══════════════════════════════════════════════════════════ -->
    <div id="reportWorkerModal"
         class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 px-4 py-6">
      <div class="bg-white w-full max-w-md rounded-xl shadow-xl overflow-hidden max-h-[90vh] flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 flex-shrink-0">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500">
              <iconify-icon icon="solar:shield-warning-linear" width="18"></iconify-icon>
            </div>
            <div>
              <h3 class="text-sm font-semibold text-slate-900">Report a Worker</h3>
              <p class="text-xs text-slate-400">Select the job and describe your complaint</p>
            </div>
          </div>
          <button type="button" onclick="closeReportModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
            <iconify-icon icon="solar:close-circle-linear" width="20"></iconify-icon>
          </button>
        </div>

        <!-- Scrollable Form Body -->
        <div class="overflow-y-auto flex-1">
          <form id="reportWorkerForm" action="{{ route('client.complaints.store') }}" method="POST"
                enctype="multipart/form-data" class="px-6 py-5 space-y-4">
            @csrf

            <!-- ① Job Selector -->
            <div>
              <label class="block text-xs font-medium text-slate-700 mb-1.5">Select Job</label>
              <div class="relative">
                <select name="job_id" id="reportJobId" required onchange="updateWorkerName(this)"
                  class="block w-full appearance-none rounded-lg border border-slate-200 bg-slate-50 text-sm py-2.5 px-3 focus:border-slate-900 focus:ring-slate-900 shadow-sm text-slate-600">
                  <option value="" disabled selected>Choose a job with an assigned worker…</option>
                  @foreach($jobs as $job)
                    @if($job->worker_id)
                      <option value="{{ $job->id }}"
                        data-worker="{{ $job->worker->user->first_name ?? 'Worker' }} {{ $job->worker->user->last_name ?? '' }}">
                        {{ $job->title }} — {{ $job->worker->user->first_name ?? 'Worker' }} {{ $job->worker->user->last_name ?? '' }}
                      </option>
                    @endif
                  @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                  <iconify-icon icon="solar:alt-arrow-down-linear" width="12"></iconify-icon>
                </div>
              </div>
            </div>

            <!-- ② Worker Name (auto-filled, but editable) -->
            <div>
              <label class="block text-xs font-medium text-slate-700 mb-1.5">Worker Name Being Reported</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                  <iconify-icon icon="solar:user-id-linear" width="15"></iconify-icon>
                </div>
                <input type="text" name="worker_name" id="reportWorkerNameInput" required
                  class="block w-full rounded-lg border border-slate-200 bg-slate-50 text-sm py-2.5 pl-9 pr-3 focus:border-slate-900 focus:ring-slate-900 shadow-sm"
                  placeholder="Full name of the worker">
              </div>
              <p class="text-[11px] text-slate-400 mt-1">Auto-filled when you select a job above. You can also type it manually.</p>
            </div>

            <!-- ③ Reason -->
            <div>
              <label class="block text-xs font-medium text-slate-700 mb-1.5">Reason</label>
              <div class="relative">
                <select name="reason" required
                  class="block w-full appearance-none rounded-lg border border-slate-200 bg-slate-50 text-sm py-2.5 px-3 focus:border-slate-900 focus:ring-slate-900 shadow-sm text-slate-600">
                  <option value="" disabled selected>Select a reason…</option>
                  <option value="no_show">Worker did not show up</option>
                  <option value="incomplete_work">Incomplete or poor quality work</option>
                  <option value="unprofessional">Unprofessional behavior</option>
                  <option value="overcharging">Overcharging / unauthorized fees</option>
                  <option value="damage">Damage to property</option>
                  <option value="other">Other</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
                  <iconify-icon icon="solar:alt-arrow-down-linear" width="12"></iconify-icon>
                </div>
              </div>
            </div>

            <!-- ④ Subject -->
            <div>
              <label class="block text-xs font-medium text-slate-700 mb-1.5">Subject</label>
              <input type="text" name="subject" required maxlength="120"
                class="block w-full rounded-lg border border-slate-200 bg-slate-50 text-sm py-2.5 px-3 focus:border-slate-900 focus:ring-slate-900 shadow-sm"
                placeholder="Brief subject of your complaint">
            </div>

            <!-- ⑤ Description -->
            <div>
              <label class="block text-xs font-medium text-slate-700 mb-1.5">Description</label>
              <textarea name="description" rows="3" required maxlength="1000"
                class="block w-full rounded-lg border border-slate-200 bg-slate-50 text-sm py-2.5 px-3 focus:border-slate-900 focus:ring-slate-900 shadow-sm resize-none"
                placeholder="Describe what happened in detail…"></textarea>
              <p class="text-[11px] text-slate-400 mt-1">Max 1000 characters.</p>
            </div>

            <!-- ⑥ Screenshot Upload -->
            <div>
              <label class="block text-xs font-medium text-slate-700 mb-1.5">
                Attach Screenshot
                <span class="text-slate-400 font-normal ml-1">(optional)</span>
              </label>

              <!-- Drop Zone -->
              <div id="dropZone"
                onclick="document.getElementById('screenshotInput').click()"
                ondragover="handleDragOver(event)"
                ondragleave="handleDragLeave(event)"
                ondrop="handleDrop(event)"
                class="relative border-2 border-dashed border-slate-200 rounded-lg p-5 text-center cursor-pointer hover:border-slate-400 hover:bg-slate-50 transition-all group">
                <input type="file" name="screenshot" id="screenshotInput"
                  accept="image/png,image/jpeg,image/jpg,image/webp"
                  class="hidden" onchange="previewImage(this)">

                <!-- Default state -->
                <div id="dropZoneDefault">
                  <div class="w-10 h-10 rounded-xl bg-slate-100 group-hover:bg-slate-200 flex items-center justify-center mx-auto mb-2 transition-colors">
                    <iconify-icon icon="solar:upload-linear" width="20" class="text-slate-400"></iconify-icon>
                  </div>
                  <p class="text-xs font-medium text-slate-600">Click to upload or drag & drop</p>
                  <p class="text-[11px] text-slate-400 mt-0.5">PNG, JPG, WEBP — max 5MB</p>
                </div>

                <!-- Preview state (hidden until image selected) -->
                <div id="dropZonePreview" class="hidden">
                  <img id="screenshotPreview" src="" alt="Preview"
                    class="max-h-40 mx-auto rounded-lg object-contain shadow-sm">
                  <div class="flex items-center justify-center gap-2 mt-2">
                    <iconify-icon icon="solar:check-circle-linear" width="14" class="text-emerald-500"></iconify-icon>
                    <p id="screenshotFileName" class="text-[11px] text-slate-500 truncate max-w-[200px]"></p>
                    <button type="button" onclick="clearImage(event)"
                      class="text-[11px] text-red-400 hover:text-red-600 underline ml-1">Remove</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- ⑦ Notice -->
            <div class="flex items-start gap-2 bg-amber-50 border border-amber-100 rounded-lg px-3 py-3">
              <iconify-icon icon="solar:info-circle-linear" width="15" class="text-amber-500 mt-0.5 flex-shrink-0"></iconify-icon>
              <p class="text-[11px] text-amber-700 leading-relaxed">
                Your report will be reviewed by our admin team. Please make sure all details are accurate and truthful. False reports may result in account suspension.
              </p>
            </div>

            <!-- ⑧ Actions -->
            <div class="flex items-center gap-3 pt-1 pb-1">
              <button type="button" onclick="closeReportModal()"
                class="flex-1 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 py-2.5 rounded-lg transition-colors">
                Cancel
              </button>
              <button type="submit"
                class="flex-1 inline-flex items-center justify-center gap-2 text-sm font-medium text-white bg-red-500 hover:bg-red-600 py-2.5 rounded-lg transition-colors shadow-sm">
                <iconify-icon icon="solar:shield-warning-linear" width="15"></iconify-icon>
                Submit Report
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
    <!-- ════ END REPORT MODAL ════ -->

    <!-- ══════════════════════════════════════════════════════════ -->
    <!-- FLOATING BUTTONS: REPORT + CHATBOT                         -->
    <!-- ══════════════════════════════════════════════════════════ -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">

        <!-- AI Chatbot -->
        <div x-data="{open:false}" class="flex flex-col items-end">
            <div x-show="open"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                class="mb-3 w-[92vw] max-w-[460px] bg-white border border-slate-200 rounded-2xl shadow-2xl overflow-hidden" style="display:none">
                <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                            <iconify-icon icon="solar:chat-round-dots-linear" width="18"></iconify-icon>
                        </div>
                        <div><p class="text-sm font-semibold">AI Assistant</p><p class="text-[10px] text-slate-300">Online</p></div>
                    </div>
                    <button @click="open=false" class="text-slate-300 hover:text-white">
                        <iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon>
                    </button>
                </div>
                <div id="chat-messages" class="h-[500px] overflow-y-auto p-4 space-y-3 bg-slate-50">
                    <div class="flex items-start gap-2">
                        <div class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs">AI</div>
                        <div class="bg-slate-100 text-slate-900 text-xs px-3 py-2 rounded-2xl shadow-sm max-w-[75%] break-words">
                            Hello 👋 I'm your TRD Assistant.<br><br>I can help you:<br>• Find skilled workers<br>• Estimate project costs<br>• Post a job<br>• Solve hiring issues<br><br>How can I help today?
                        </div>
                    </div>
                </div>
                <div class="border-t border-slate-200 p-3 bg-white">
                    <div class="flex items-center gap-2">
                        <input id="chatInput" type="text" placeholder="Type a message..."
                            class="flex-1 text-xs border border-slate-200 rounded-lg px-3 py-2 bg-slate-50 focus:outline-none focus:ring-1 focus:ring-slate-900">
                        <button onclick="sendMessage()" class="bg-slate-900 text-white p-2 rounded-lg hover:bg-slate-800">
                            <iconify-icon icon="solar:arrow-up-linear" width="16"></iconify-icon>
                        </button>
                    </div>
                </div>
            </div>
            <button @click="open=!open"
                class="w-14 h-14 rounded-full bg-slate-900 hover:bg-slate-800 text-white shadow-xl flex items-center justify-center transition-all duration-300" title="AI Assistant">
                <iconify-icon icon="solar:chat-round-dots-bold" width="22"></iconify-icon>
            </button>
        </div>

        <!-- Report Worker Floating Button -->
        <button type="button" onclick="openReportModal()"
            class="w-14 h-14 rounded-full bg-red-500 hover:bg-red-600 text-white shadow-xl flex items-center justify-center transition-all duration-300 group relative"
            title="Report a Worker">
            <iconify-icon icon="solar:shield-warning-bold" width="22"></iconify-icon>
            <span class="absolute right-16 bg-slate-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-lg">
                Report a Worker
            </span>
        </button>

    </div>

    <script>
        // ── Chatbot ───────────────────────────────────────────────────
        document.addEventListener("DOMContentLoaded", function () {
            const chatInput = document.getElementById("chatInput")
            const chatMessages = document.getElementById("chat-messages")
            const GEMINI_API_KEY = document.querySelector('meta[name="gemini-api-key"]').content
            const GEMINI_MODEL = "gemini-2.5-flash"
            let conversation = []

            function parseMarkdown(text) { text = text.replace(/\*\*(.*?)\*\*/g, "<b>$1</b>"); text = text.replace(/\n/g, "<br>"); return text }

            function appendMessage(message, sender) {
                const wrapper = document.createElement("div"); wrapper.classList.add("flex", "gap-2")
                const avatar = document.createElement("div"); avatar.classList.add("w-7", "h-7", "rounded-full", "flex", "items-center", "justify-center", "text-xs")
                const bubble = document.createElement("div"); bubble.classList.add("text-xs", "px-3", "py-2", "rounded-2xl", "shadow-sm", "max-w-[75%]", "break-words")
                if (sender === "user") { wrapper.classList.add("justify-end", "items-end"); bubble.classList.add("bg-slate-900", "text-white") }
                else { wrapper.classList.add("items-start"); avatar.classList.add("bg-slate-900", "text-white"); avatar.textContent = "AI"; bubble.classList.add("bg-slate-100", "text-slate-900") }
                bubble.innerHTML = parseMarkdown(message)
                wrapper.appendChild(avatar); wrapper.appendChild(bubble)
                chatMessages.appendChild(wrapper); chatMessages.scrollTop = chatMessages.scrollHeight
                return bubble
            }

            function typingIndicator() {
                const wrapper = document.createElement("div"); wrapper.classList.add("flex", "gap-2")
                const avatar = document.createElement("div"); avatar.classList.add("w-7", "h-7", "rounded-full", "bg-slate-900", "text-white", "flex", "items-center", "justify-center", "text-xs"); avatar.textContent = "AI"
                const bubble = document.createElement("div"); bubble.classList.add("bg-slate-100", "px-3", "py-2", "rounded-2xl", "text-xs")
                bubble.innerHTML = '<span class="animate-pulse">AI is typing...</span>'
                wrapper.appendChild(avatar); wrapper.appendChild(bubble)
                chatMessages.appendChild(wrapper); chatMessages.scrollTop = chatMessages.scrollHeight
                return wrapper
            }

            async function askGemini() {
                try {
                    const res = await fetch(`https://generativelanguage.googleapis.com/v1/models/${GEMINI_MODEL}:generateContent?key=${GEMINI_API_KEY}`, { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify({ contents: conversation }) })
                    const data = await res.json()
                    return data?.candidates?.[0]?.content?.parts?.[0]?.text || "AI could not respond."
                } catch (e) { console.error(e); return "Error connecting to AI." }
            }

            async function streamText(element, text) {
                element.innerHTML = ""; let i = 0; const speed = 15
                function type() { if (i < text.length) { element.innerHTML += text.charAt(i); i++; setTimeout(type, speed) } }
                type()
            }

            window.sendMessage = async function () {
                const message = chatInput.value.trim(); if (!message) return
                appendMessage(message, "user"); conversation.push({ role: "user", parts: [{ text: message }] }); chatInput.value = ""
                const typing = typingIndicator(); const reply = await askGemini(); typing.remove()
                const bubble = appendMessage("", "bot"); streamText(bubble, parseMarkdown(reply))
                conversation.push({ role: "model", parts: [{ text: reply }] })
            }
            chatInput.addEventListener("keypress", function (e) { if (e.key === "Enter") { sendMessage() } })
        })

        // ── Report Modal ──────────────────────────────────────────────
        function openReportModal() {
            document.getElementById('reportWorkerForm').reset();
            clearImage();
            const modal = document.getElementById('reportWorkerModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeReportModal() {
            const modal = document.getElementById('reportWorkerModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function updateWorkerName(select) {
            const selected = select.options[select.selectedIndex];
            const workerName = selected.getAttribute('data-worker');
            if (workerName) {
                document.getElementById('reportWorkerNameInput').value = workerName.trim();
            }
        }

        // ── Screenshot upload ─────────────────────────────────────────
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 5 * 1024 * 1024) {
                    alert('File is too large. Maximum size is 5MB.');
                    input.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('screenshotPreview').src = e.target.result;
                    document.getElementById('screenshotFileName').textContent = file.name;
                    document.getElementById('dropZoneDefault').classList.add('hidden');
                    document.getElementById('dropZonePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function clearImage(e) {
            if (e) e.stopPropagation();
            document.getElementById('screenshotInput').value = '';
            document.getElementById('screenshotPreview').src = '';
            document.getElementById('screenshotFileName').textContent = '';
            document.getElementById('dropZoneDefault').classList.remove('hidden');
            document.getElementById('dropZonePreview').classList.add('hidden');
        }

        function handleDragOver(e) {
            e.preventDefault();
            document.getElementById('dropZone').classList.add('border-slate-400', 'bg-slate-50');
        }

        function handleDragLeave(e) {
            document.getElementById('dropZone').classList.remove('border-slate-400', 'bg-slate-50');
        }

        function handleDrop(e) {
            e.preventDefault();
            handleDragLeave();
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const input = document.getElementById('screenshotInput');
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                previewImage(input);
            }
        }

        document.getElementById('reportWorkerModal').addEventListener('click', function (e) {
            if (e.target === this) closeReportModal();
        });
    </script>

</body>
</html>