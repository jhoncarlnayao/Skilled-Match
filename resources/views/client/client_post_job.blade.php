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
    /* Custom font to match the clean UI look */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-[#f8fafc]">
@include('notifications.notifications')
@include('client.navigation-bar-client.navbar-client')

<div class="w-full lg:ps-64"
     x-data="{
        openModal: false,
        search: '',
        statusFilter: 'all',
        editOpen: false,
        selectedJob: {},
        deleteOpen: false,
        deleteId: null
     }">
    
<header class="sticky top-0 inset-x-0 flex flex-wrap sm:flex-nowrap z-[48] w-full bg-white/80 backdrop-blur-md border-b py-3 px-4 sm:px-6 md:px-8">
  
  <div class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-4">

    <!-- Left Side: Search -->
    <div class="relative w-full sm:max-w-md">
      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
        <svg class="h-4 w-4 text-gray-400"
             xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.3-4.3"/>
        </svg>
      </div>

      <input type="text"
             x-model="search"
             placeholder="Search job title..."
             class="py-2 px-3 ps-10 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:border-slate-900 focus:ring-slate-900">
    </div>

    <!-- Right Side: Status Filter -->
    <div class="w-full sm:w-48">
      <select x-model="statusFilter"
              class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-slate-900 focus:border-slate-900">
        <option value="all">All Status</option>
        <option value="open">Open</option>
        <option value="assigned">Assigned</option>
        <option value="completed">Completed</option>
      </select>
    </div>

  </div>
</header>
{{-- <main class="flex-1 p-6 lg:p-8 bg-slate-50"
      x-data="{
        openModal: false,
        search: '',
        statusFilter: 'all',   // 👈 add this
        editOpen: false,
        selectedJob: {},
        deleteOpen: false,
        deleteId: null
      }"> --}}
<main class="flex-1 p-6 lg:p-8 bg-slate-50"
   >
  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
      <h1 class="text-xl font-semibold text-slate-900 tracking-tight">
        My Jobs
      </h1>
      <p class="text-sm text-slate-500 mt-1">
        Manage {{ $jobs->count() }} posted jobs.
      </p>
    </div>

    <button @click="openModal = true"
      class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition shadow-sm">
      <iconify-icon icon="solar:add-circle-linear" width="18"></iconify-icon>
      Post New Job
    </button>
  </div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 relative">

            <!-- Table Head -->
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Trade
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Location
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Budget
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Worker
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($jobs as $job)
            <tr class="hover:bg-gray-50 transition"
    x-show="
        (statusFilter === 'all' || statusFilter === '{{ $job->status }}') &&
        ('{{ strtolower($job->title) }}'.includes(search.toLowerCase()))
    "
>

                    <!-- Title -->
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-gray-800">
                            {{ $job->title }}
                        </div>
                        <div class="text-xs text-gray-500 line-clamp-1">
                            {{ $job->description }}
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            {{ $job->created_at->format('M d, Y') }}
                        </div>
                    </td>

                    <!-- Trade -->
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $job->trade->name ?? 'N/A' }}
                    </td>

                    <!-- Location -->
                    <td class="px-6 py-4 text-sm text-gray-700">
                        {{ $job->location }}
                    </td>

                    <!-- Budget -->
                    <td class="px-6 py-4 text-sm font-semibold text-yellow-700">
                        ₱{{ number_format($job->budget, 2) }}
                    </td>

                    <!-- Worker -->
                    <td class="px-6 py-4 text-sm">
                        @if($job->worker)
                            <div class="font-medium text-emerald-700">
                                {{ $job->worker->user->first_name }}
                                {{ $job->worker->user->last_name }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $job->worker->user->email }}
                            </div>
                        @else
                            <span class="text-gray-400 text-sm">
                                Not assigned
                            </span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-medium rounded-full
                            {{ $job->status === 'open' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $job->status === 'assigned' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $job->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : '' }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </td>

                    <!-- Actions -->
              <td class="px-6 py-4 text-sm">
    <div class="flex items-center gap-2">

        {{-- Complete Button --}}
        @if($job->status === 'assigned')
        <form action="{{ route('client.jobs.complete', $job->id) }}"
              method="POST">
            @csrf
            <button type="submit"
                class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
                       text-emerald-600 bg-white border border-gray-300 rounded-lg
                       hover:bg-emerald-50 hover:border-emerald-300
                       focus:outline-none focus:ring-2 focus:ring-emerald-200 transition">

                <!-- Check Icon -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>

                Complete
            </button>
        </form>
        @endif


        {{-- Edit Button --}}
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
                      d="M15.232 5.232l3.536 3.536M9 11l6-6m2 2L11 13l-4 1 1-4 6-6z"/>
            </svg>

            Edit
        </button>


        {{-- Delete Button --}}
      {{-- Delete Button --}}
@if($job->status !== 'assigned')
<button type="button"
    @click="
        deleteId = {{ $job->id }};
        deleteOpen = true;
    "
    class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
           text-red-600 bg-white border border-gray-300 rounded-lg
           hover:bg-red-50 hover:border-red-300
           focus:outline-none focus:ring-2 focus:ring-red-200 transition">

    <!-- Trash Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-4 h-4"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M6 7h12M9 7V5h6v2m-7 0v12m4-12v12m4-12v12"/>
    </svg>

    Delete
</button>
@else
<span class="text-xs text-gray-400">
    Cannot delete (Assigned)
</span>
@endif

    </div>
</td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                        No jobs posted yet.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>


<!-- Edit Job Modal -->
<div x-show="editOpen" 
     x-transition.opacity
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
     style="display:none;">

    <div x-show="editOpen"
         x-transition
         class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">

        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Edit Job
        </h3>

        <form 
            :action="'/client/jobs/' + selectedJob.id"
            method="POST"
            class="space-y-4"
        >
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="text-sm text-gray-600">Title</label>
                <input type="text" name="title"
                       x-model="selectedJob.title"
                       class="w-full mt-1 px-4 py-2 border rounded-lg">
            </div>

            <!-- Description -->
            <div>
                <label class="text-sm text-gray-600">Description</label>
                <textarea name="description"
                          x-model="selectedJob.description"
                          rows="3"
                          class="w-full mt-1 px-4 py-2 border rounded-lg"></textarea>
            </div>

            <!-- Trade -->
            <div>
                <label class="text-sm text-gray-600">Trade</label>
                <select name="trade_id"
                        x-model="selectedJob.trade_id"
                        class="w-full mt-1 px-4 py-2 border rounded-lg">
                    @foreach($trades as $trade)
                        <option value="{{ $trade->id }}">
                            {{ $trade->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Budget -->
            <div>
                <label class="text-sm text-gray-600">Budget</label>
                <input type="number" name="budget"
                       x-model="selectedJob.budget"
                       class="w-full mt-1 px-4 py-2 border rounded-lg">
            </div>

            <!-- Location -->
            <div>
                <label class="text-sm text-gray-600">Location</label>
                <input type="text" name="location"
                       x-model="selectedJob.location"
                       class="w-full mt-1 px-4 py-2 border rounded-lg">
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 pt-4">
                <button type="button"
                        @click="editOpen = false"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                    Cancel
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Job
                </button>
            </div>

        </form>
    </div>
</div>


  <!-- Modal -->
  <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-transition>
    <div @click.away="openModal = false" class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6">
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

        <div class="flex justify-end gap-3 pt-4">
          <button type="button" @click="openModal = false"
            class="px-4 py-2 text-sm border border-slate-200 rounded-lg hover:bg-slate-50">
            Cancel
          </button>

          <button type="submit"
            class="px-4 py-2 text-sm bg-slate-900 text-white rounded-lg hover:bg-slate-800">
            Post Job
          </button>
        </div>
      </form>
    </div>
  </div>
<!-- Delete Confirmation Modal -->
<div x-show="deleteOpen"
     x-transition.opacity
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
     style="display:none;">

    <div x-show="deleteOpen"
         x-transition
         class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">

        <h3 class="text-lg font-semibold text-gray-800 mb-2">
            Confirm Deletion
        </h3>

        <p class="text-sm text-gray-500 mb-6">
            Are you sure you want to delete this job?
            This action cannot be undone.
        </p>

        <div class="flex justify-end gap-3">

            <button type="button"
                    @click="deleteOpen = false"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                Cancel
            </button>

            <form :action="'/client/jobs/' + deleteId"
                  method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Yes, Delete
                </button>
            </form>

        </div>

    </div>
</div>
</main>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">
 <meta name="gemini-api-key" content="{{ env('GEMINI_API_KEY') }}">
<!-- Floating AI Chat Widget -->
<div 
    x-data="{ open: false }" 
    class="fixed bottom-6 right-6 z-50 flex flex-col items-end"
>

    <!-- Chat Panel -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="mb-4 w-80 bg-white border border-slate-200 rounded-2xl shadow-2xl overflow-hidden"
        style="display: none;"
    >

        <!-- Header -->
        <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                    <iconify-icon icon="solar:chat-round-dots-linear" width="18"></iconify-icon>
                </div>
                <div>
                    <p class="text-sm font-semibold">AI Assistant</p>
                    <p class="text-[10px] text-slate-300">Online</p>
                </div>
            </div>

            <button @click="open = false" class="text-slate-300 hover:text-white">
                <iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="h-64 overflow-y-auto p-4 space-y-3 bg-slate-50">
            <!-- Initial AI message -->
            <div class="flex items-start gap-2">
                <div class="w-7 h-7 rounded-full bg-slate-900 text-white flex items-center justify-center text-xs">
                    AI
                </div>
                <div class="bg-slate-100 text-slate-900 text-xs px-3 py-2 rounded-2xl shadow-sm max-w-[75%] break-words">
                    Hello 👋 How can I assist you today?
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-slate-200 p-3 bg-white">
            <div class="flex items-center gap-2">
                <input 
                    id="chatInput"
                    type="text" 
                    placeholder="Type a message..."
                    class="flex-1 text-xs border border-slate-200 rounded-lg px-3 py-2 bg-slate-50 focus:outline-none focus:ring-1 focus:ring-slate-900"
                >
                <button 
                    onclick="sendMessage()"
                    class="bg-slate-900 text-white p-2 rounded-lg hover:bg-slate-800"
                >
                    <iconify-icon icon="solar:arrow-up-linear" width="16"></iconify-icon>
                </button>
            </div>
        </div>
    </div>

    <!-- Floating Button -->
    <button 
        @click="open = !open"
        class="w-14 h-14 rounded-full bg-slate-900 hover:bg-slate-800 text-white shadow-xl flex items-center justify-center transition-all duration-300"
    >
        <iconify-icon icon="solar:chat-round-dots-bold" width="22"></iconify-icon>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatInput = document.getElementById('chatInput');
            const chatMessages = document.getElementById('chat-messages');
            const GEMINI_API_KEY = document.querySelector('meta[name="gemini-api-key"]').content;
            const GEMINI_MODEL = "gemini-2.5-flash";

            function appendMessage(message, sender) {
                const msgDivWrapper = document.createElement('div');
                msgDivWrapper.classList.add('flex', 'gap-2');

                const avatarDiv = document.createElement('div');
                avatarDiv.classList.add('w-7','h-7','rounded-full','flex','items-center','justify-center','text-xs');

                const bubbleDiv = document.createElement('div');
                bubbleDiv.classList.add('text-xs','px-3','py-2','rounded-2xl','shadow-sm','max-w-[75%]','break-words');

                if(sender === 'user'){
                    msgDivWrapper.classList.add('justify-end','items-end');
                    // avatarDiv.classList.add('bg-blue-600','text-white');
                    // avatarDiv.textContent = 'You';
                    // bubbleDiv.classList.add('bg-blue-600','text-white');
                } else {
                    msgDivWrapper.classList.add('items-start');
                    avatarDiv.classList.add('bg-slate-900','text-white');
                    avatarDiv.textContent = 'AI';
                    bubbleDiv.classList.add('bg-slate-100','text-slate-900');
                }

                bubbleDiv.textContent = message;
                msgDivWrapper.appendChild(avatarDiv);
                msgDivWrapper.appendChild(bubbleDiv);
                chatMessages.appendChild(msgDivWrapper);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            async function askGemini(prompt) {
                try {
                    const res = await fetch(`https://generativelanguage.googleapis.com/v1/models/${GEMINI_MODEL}:generateContent?key=${GEMINI_API_KEY}`, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            contents: [
                                { role: "user", parts: [{ text: prompt }] }
                            ]
                        }),
                    });

                    const data = await res.json();
                    return data?.candidates?.[0]?.content?.parts?.[0]?.text || "Gemini could not generate a response.";
                } catch (err) {
                    console.error("Gemini API error:", err);
                    return "Error connecting to Gemini AI.";
                }
            }

            window.sendMessage = async function () {
                const message = chatInput.value.trim();
                if(!message) return;

                appendMessage(message, 'user');
                chatInput.value = '';

                appendMessage("Thinking...", 'bot'); 
                const lastBot = chatMessages.lastChild;

                const reply = await askGemini(message);
                lastBot.querySelector('div:last-child').textContent = reply;
            }
        });
    </script>
</div>
  <script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
      <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>