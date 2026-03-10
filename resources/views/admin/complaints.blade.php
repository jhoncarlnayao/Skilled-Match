<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Complaints — Sociotix Admin</title>
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

    <!-- Top Header -->
    <header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white/80 backdrop-blur-md border-b py-3 px-4 sm:px-6 md:px-8">
        <div class="w-full flex items-center justify-between gap-x-5">
            <div>
                <h1 class="text-base font-semibold text-slate-900">Worker Complaints</h1>
                <p class="text-xs text-slate-500">Review and manage complaints submitted by clients</p>
            </div>
            <div class="flex items-center gap-2">
                @if($pendingCount > 0)
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium bg-red-50 text-red-600 border border-red-100 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        {{ $pendingCount }} Pending
                    </span>
                @endif
            </div>
        </div>
    </header>

    <main class="p-4 sm:p-6 space-y-5">

        @if(session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="fixed top-5 right-5 z-50">
                <div class="flex items-start gap-3 bg-white border border-emerald-200 shadow-lg rounded-xl p-4 min-w-[280px]">
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                        <iconify-icon icon="solar:check-circle-linear" width="20"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">Success</p>
                        <p class="text-xs text-slate-500 mt-1">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                        <iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="fixed top-5 right-5 z-50">
                <div class="flex items-start gap-3 bg-white border border-red-200 shadow-lg rounded-xl p-4 min-w-[280px]">
                    <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                        <iconify-icon icon="solar:close-circle-linear" width="20"></iconify-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">Error</p>
                        <p class="text-xs text-slate-500 mt-1">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                        <iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon>
                    </button>
                </div>
            </div>
        @endif

        <!-- Stats Row -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @php
                $statuses = [
                    ['label' => 'Pending',   'key' => 'pending',   'color' => 'amber',   'icon' => 'solar:hourglass-line-linear'],
                    ['label' => 'Reviewed',  'key' => 'reviewed',  'color' => 'blue',    'icon' => 'solar:eye-linear'],
                    ['label' => 'Resolved',  'key' => 'resolved',  'color' => 'emerald', 'icon' => 'solar:check-circle-linear'],
                    ['label' => 'Dismissed', 'key' => 'dismissed', 'color' => 'slate',   'icon' => 'solar:close-circle-linear'],
                ];
                $colorMap = [
                    'amber'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600'],
                    'blue'    => ['bg' => 'bg-blue-50',    'text' => 'text-blue-600'],
                    'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                    'slate'   => ['bg' => 'bg-slate-100',  'text' => 'text-slate-500'],
                ];
            @endphp
            @foreach($statuses as $stat)
                @php $c = $colorMap[$stat['color']]; @endphp
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm flex items-center gap-3">
                    <div class="p-2 {{ $c['bg'] }} {{ $c['text'] }} rounded-lg flex-shrink-0">
                        <iconify-icon icon="{{ $stat['icon'] }}" width="20"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-xl font-semibold text-slate-900">
                            {{ \App\Models\Complaint::where('status', $stat['key'])->count() }}
                        </p>
                        <p class="text-xs text-slate-500">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Filter Tabs + Table Card -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

            <!-- Filter Tabs -->
            <div class="flex items-center gap-1 px-4 pt-4 pb-0 border-b border-slate-100 overflow-x-auto no-scrollbar">
                @foreach([['all','All'], ['pending','Pending'], ['reviewed','Reviewed'], ['resolved','Resolved'], ['dismissed','Dismissed']] as [$key, $label])
                    <a href="{{ route('admin.complaints', ['status' => $key]) }}"
                        class="flex-shrink-0 px-4 py-2 text-xs font-medium rounded-t-lg border-b-2 transition-colors
                            {{ $status === $key
                                ? 'border-slate-900 text-slate-900 bg-slate-50'
                                : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                        {{ $label }}
                        @if($key !== 'all')
                            <span class="ml-1 text-[10px] {{ $status === $key ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-500' }} px-1.5 py-0.5 rounded-full">
                                {{ \App\Models\Complaint::where('status', $key)->count() }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                            <th class="px-5 py-3 font-medium">Complaint</th>
                            <th class="px-5 py-3 font-medium">Filed By</th>
                            <th class="px-5 py-3 font-medium">Worker Reported</th>
                            <th class="px-5 py-3 font-medium">Reason</th>
                            <th class="px-5 py-3 font-medium">Status</th>
                            <th class="px-5 py-3 font-medium">Date</th>
                            <th class="px-5 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($complaints as $complaint)
                            <tr class="hover:bg-slate-50/50 transition-colors group">

                                <!-- Subject + description preview -->
                                <td class="px-5 py-4 max-w-[220px]">
                                    <p class="text-sm font-medium text-slate-900 truncate">{{ $complaint->subject }}</p>
                                    <p class="text-xs text-slate-400 truncate mt-0.5">{{ Str::limit($complaint->description, 60) }}</p>
                                </td>

                                <!-- Client -->
                                <td class="px-5 py-4">
                                    @if($complaint->client)
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-semibold flex-shrink-0">
                                                {{ strtoupper(substr($complaint->client->first_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-xs font-medium text-slate-700">{{ $complaint->client->first_name }} {{ $complaint->client->last_name }}</p>
                                                <p class="text-[11px] text-slate-400">{{ $complaint->client->email }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Unknown</span>
                                    @endif
                                </td>

                                <!-- Worker name -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                                            <iconify-icon icon="solar:user-id-linear" width="14"></iconify-icon>
                                        </div>
                                        <span class="text-xs font-medium text-slate-700">{{ $complaint->worker_name ?? '—' }}</span>
                                    </div>
                                </td>

                                <!-- Reason -->
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                        {{ $complaint->reason_label }}
                                    </span>
                                </td>

                                <!-- Status badge -->
                                <td class="px-5 py-4">
                                    @php
                                        $badgeClass = match($complaint->status) {
                                            'pending'   => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'reviewed'  => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'resolved'  => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'dismissed' => 'bg-slate-100 text-slate-500 border-slate-200',
                                            default     => 'bg-slate-100 text-slate-500 border-slate-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium border {{ $badgeClass }} capitalize">
                                        {{ $complaint->status }}
                                    </span>
                                </td>

                                <!-- Date -->
                                <td class="px-5 py-4 text-xs text-slate-400 whitespace-nowrap">
                                    {{ $complaint->created_at->format('M d, Y') }}
                                    <br>
                                    <span class="text-[11px]">{{ $complaint->created_at->diffForHumans() }}</span>
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- View / Edit button -->
                                        <button type="button"
                                            onclick="openComplaintModal({{ $complaint->id }},
                                                '{{ addslashes($complaint->subject) }}',
                                                '{{ addslashes($complaint->description) }}',
                                                '{{ $complaint->reason_label }}',
                                                '{{ $complaint->worker_name ?? '' }}',
                                                '{{ $complaint->client->first_name ?? '' }} {{ $complaint->client->last_name ?? '' }}',
                                                '{{ $complaint->status }}',
                                                '{{ addslashes($complaint->admin_notes ?? '') }}',
                                                '{{ $complaint->screenshot_url ?? '' }}')"
                                            class="inline-flex items-center gap-1 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 px-2.5 py-1.5 rounded-lg transition-colors">
                                            <iconify-icon icon="solar:eye-linear" width="14"></iconify-icon>
                                            Review
                                        </button>

                                        <!-- Delete button -->
                                        <form action="{{ route('admin.complaints.delete', $complaint->id) }}" method="POST"
                                            onsubmit="return confirm('Delete this complaint? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 text-xs font-medium text-red-500 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded-lg transition-colors">
                                                <iconify-icon icon="solar:trash-bin-minimalistic-linear" width="14"></iconify-icon>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                            <iconify-icon icon="solar:shield-check-linear" width="24"></iconify-icon>
                                        </div>
                                        <p class="text-sm font-medium text-slate-500">No complaints found</p>
                                        <p class="text-xs text-slate-400">
                                            {{ $status === 'all' ? 'No complaints have been submitted yet.' : "No {$status} complaints." }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($complaints->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $complaints->appends(['status' => $status])->links() }}
                </div>
            @endif
        </div>

    </main>
</div>

<!-- ══════════════════════════════════════════════════════════ -->
<!-- COMPLAINT REVIEW MODAL                                     -->
<!-- ══════════════════════════════════════════════════════════ -->
<div id="complaintModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 px-4 py-6">
  <div class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden max-h-[92vh] flex flex-col">

    <!-- Modal Header -->
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 flex-shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500">
          <iconify-icon icon="solar:shield-warning-linear" width="18"></iconify-icon>
        </div>
        <div>
          <h3 class="text-sm font-semibold text-slate-900" id="modalSubject">—</h3>
          <p class="text-xs text-slate-400">Complaint Review</p>
        </div>
      </div>
      <button type="button" onclick="closeComplaintModal()"
        class="text-slate-400 hover:text-slate-600 transition-colors">
        <iconify-icon icon="solar:close-circle-linear" width="20"></iconify-icon>
      </button>
    </div>

    <!-- Scrollable Body -->
    <div class="overflow-y-auto flex-1 px-6 py-5 space-y-4">

      <!-- Info Grid -->
      <div class="grid grid-cols-2 gap-3">
        <div class="bg-slate-50 rounded-lg px-3 py-2.5">
          <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Filed By</p>
          <p class="text-xs font-medium text-slate-700" id="modalClient">—</p>
        </div>
        <div class="bg-slate-50 rounded-lg px-3 py-2.5">
          <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Worker Reported</p>
          <p class="text-xs font-medium text-slate-700" id="modalWorker">—</p>
        </div>
        <div class="bg-slate-50 rounded-lg px-3 py-2.5 col-span-2">
          <p class="text-[10px] text-slate-400 uppercase tracking-wider mb-0.5">Reason</p>
          <p class="text-xs font-medium text-slate-700" id="modalReason">—</p>
        </div>
      </div>

      <!-- Description -->
      <div>
        <p class="text-xs font-medium text-slate-700 mb-1.5">Description</p>
        <div class="bg-slate-50 border border-slate-100 rounded-lg px-3 py-3 text-xs text-slate-600 leading-relaxed" id="modalDescription">—</div>
      </div>

      <!-- Screenshot -->
      <div id="screenshotSection" class="hidden">
        <p class="text-xs font-medium text-slate-700 mb-1.5">Attached Screenshot</p>
        <div class="border border-slate-200 rounded-lg overflow-hidden">
          <img id="modalScreenshot" src="" alt="Screenshot"
            class="w-full max-h-56 object-contain bg-slate-50 cursor-pointer"
            onclick="window.open(this.src, '_blank')">
          <div class="px-3 py-2 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
            <p class="text-[11px] text-slate-400">Click image to open full size</p>
            <a id="screenshotLink" href="#" target="_blank"
              class="text-[11px] text-blue-500 hover:text-blue-700 flex items-center gap-1">
              <iconify-icon icon="solar:arrow-right-up-linear" width="12"></iconify-icon>
              Open
            </a>
          </div>
        </div>
      </div>

      <!-- Update Form -->
      <form id="complaintUpdateForm" action="" method="POST" class="space-y-4 pt-2 border-t border-slate-100">
        @csrf
        @method('PATCH')

        <!-- Status -->
        <div>
          <label class="block text-xs font-medium text-slate-700 mb-1.5">Update Status</label>
          <div class="relative">
            <select name="status" id="modalStatus" required
              class="block w-full appearance-none rounded-lg border border-slate-200 bg-slate-50 text-sm py-2.5 px-3 focus:border-slate-900 focus:ring-slate-900 shadow-sm text-slate-600">
              <option value="pending">Pending</option>
              <option value="reviewed">Reviewed</option>
              <option value="resolved">Resolved</option>
              <option value="dismissed">Dismissed</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-400">
              <iconify-icon icon="solar:alt-arrow-down-linear" width="12"></iconify-icon>
            </div>
          </div>
        </div>

        <!-- Admin Notes -->
        <div>
          <label class="block text-xs font-medium text-slate-700 mb-1.5">
            Admin Notes
            <span class="text-slate-400 font-normal ml-1">(optional)</span>
          </label>
          <textarea name="admin_notes" id="modalAdminNotes" rows="3" maxlength="1000"
            class="block w-full rounded-lg border border-slate-200 bg-slate-50 text-sm py-2.5 px-3 focus:border-slate-900 focus:ring-slate-900 shadow-sm resize-none"
            placeholder="Add internal notes about this complaint…"></textarea>
          <p class="text-[11px] text-slate-400 mt-1">Visible to admins only. Not shown to the client.</p>
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-3 pt-1">
          <button type="button" onclick="closeComplaintModal()"
            class="flex-1 text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 py-2.5 rounded-lg transition-colors">
            Cancel
          </button>
          <button type="submit"
            class="flex-1 inline-flex items-center justify-center gap-2 text-sm font-medium text-white bg-slate-900 hover:bg-slate-800 py-2.5 rounded-lg transition-colors shadow-sm">
            <iconify-icon icon="solar:check-circle-linear" width="15"></iconify-icon>
            Save Changes
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
<!-- ════ END COMPLAINT MODAL ════ -->

<script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>

<script>
    function openComplaintModal(id, subject, description, reason, worker, client, status, adminNotes, screenshotUrl) {
        document.getElementById('modalSubject').textContent      = subject;
        document.getElementById('modalDescription').textContent  = description;
        document.getElementById('modalReason').textContent       = reason;
        document.getElementById('modalWorker').textContent       = worker || '—';
        document.getElementById('modalClient').textContent       = client.trim() || '—';
        document.getElementById('modalAdminNotes').value         = adminNotes;

        // Set status dropdown
        const statusEl = document.getElementById('modalStatus');
        for (let i = 0; i < statusEl.options.length; i++) {
            if (statusEl.options[i].value === status) {
                statusEl.selectedIndex = i;
                break;
            }
        }

        // Screenshot
        if (screenshotUrl) {
            document.getElementById('modalScreenshot').src  = screenshotUrl;
            document.getElementById('screenshotLink').href  = screenshotUrl;
            document.getElementById('screenshotSection').classList.remove('hidden');
        } else {
            document.getElementById('screenshotSection').classList.add('hidden');
        }

        // Set form action to PATCH route
        document.getElementById('complaintUpdateForm').action = `/admin/complaints/${id}`;

        // Show modal
        const modal = document.getElementById('complaintModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeComplaintModal() {
        const modal = document.getElementById('complaintModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close on backdrop click
    document.getElementById('complaintModal').addEventListener('click', function (e) {
        if (e.target === this) closeComplaintModal();
    });
</script>

</body>
</html>