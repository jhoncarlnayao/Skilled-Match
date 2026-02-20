<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sociotix Light Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <link rel="stylesheet" href="https://preline.co/assets/css/main.min.css">
  
  <style>
    /* Custom font to match the clean UI look */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-[#f8fafc]">

@include('client.navigation-bar-client.navbar-client')

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

    
  <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
<div id="profile-card" class="bg-white border border-gray-200 rounded-xl shadow-[0px_2px_4px_rgba(0,0,0,0.02),0px_1px_0px_rgba(0,0,0,0.06)] overflow-hidden">
        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="max-w-5xl mx-auto space-y-6">
                
                <!-- Page Title Area -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900 tracking-tight">Client Profile</h1>
                        <p class="text-sm text-gray-500 mt-1">Manage personal details and contact information.</p>
                    </div>
                    <div class="flex items-center gap-3">
                      <button id="export-btn" class="inline-flex items-center justify-center px-4 py-2 border border-gray-200 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all">
    <iconify-icon icon="solar:export-linear" stroke-width="1.5" class="mr-2 text-lg"></iconify-icon>
    Export
</button>
                    <button id="edit-profile-btn" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm bg-gray-900 text-sm font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all">
    <iconify-icon icon="solar:pen-new-square-linear" stroke-width="1.5" class="mr-2 text-lg"></iconify-icon>
    Edit Profile
</button>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-[0px_2px_4px_rgba(0,0,0,0.02),0px_1px_0px_rgba(0,0,0,0.06)] overflow-hidden">
                    
                    <!-- Profile Header Section -->
                    <div class="p-6 sm:p-8 border-b border-gray-100 flex flex-col md:flex-row items-start md:items-center gap-6">
                        <div class="relative group">
                            <img src="{{ $user->profile_picture ? asset('storage/'.$user->profile_picture) : asset('images/default-profile.png') }}" alt="Profile" class="w-24 h-24 rounded-full">
                            <div class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 border-2 border-white rounded-full" title="Active"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-1">
                                <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">
    {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}
</h2>
                             @php
    $status = $user->status;
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
    {{ $status === 'active' ? 'bg-green-50 text-green-700 border border-green-100' : '' }}
    {{ $status === 'pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-100' : '' }}
    {{ $status === 'deactivate' ? 'bg-red-50 text-red-700 border border-red-100' : '' }}">
    
    {{ ucfirst($status) }} Account
</span>

                            </div>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                <div class="flex items-center gap-1.5">
                                    <iconify-icon icon="solar:hashtag-linear" stroke-width="1.5" class="text-gray-400"></iconify-icon>
                                    ID: CLI-{{ $user->id }}

                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                <div class="flex items-center gap-1.5">
                                    <iconify-icon icon="solar:map-point-linear" stroke-width="1.5" class="text-gray-400"></iconify-icon>
                                    {{ $user->city ?? 'Not provided' }}
                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                              <div class="flex items-center gap-1.5">
    <iconify-icon icon="solar:calendar-date-linear" stroke-width="1.5" class="text-gray-400"></iconify-icon>
    Joined {{ $user->created_at->format('M Y') }}
</div>

                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                        
                        <!-- Column 1: Personal -->
                        <div class="p-6 sm:p-8 space-y-6">
                            <div class="flex items-center gap-2 mb-6">
                                <iconify-icon icon="solar:user-id-linear" stroke-width="1.5" class="text-gray-400 text-xl"></iconify-icon>
                                <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wider">Personal Information</h3>
                            </div>
                            
                       <div class="space-y-1">
    <label class="text-xs text-gray-500 font-medium block">First Name</label>
    <p class="text-sm text-gray-900 font-medium">
        {{ $user->first_name ?? 'Not provided' }}
    </p>
</div>

<div class="space-y-1">
    <label class="text-xs text-gray-500 font-medium block">Middle Name</label>
    <p class="text-sm text-gray-900 font-medium">
        {{ $user->middle_name ?? 'Not provided' }}
    </p>
</div>

<div class="space-y-1">
    <label class="text-xs text-gray-500 font-medium block">Last Name</label>
    <p class="text-sm text-gray-900 font-medium">
        {{ $user->last_name ?? 'Not provided' }}
    </p>
</div>

                            <div class="space-y-1">
                                <label class="text-xs text-gray-500 font-medium block">Date of Birth</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->birthdate ?? 'Not provided' }}</p>
                                    {{-- <span class="text-xs text-gray-400 font-normal">(34 years)</span> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: Contact -->
                        <div class="p-6 sm:p-8 space-y-6">
                             <div class="flex items-center gap-2 mb-6">
                                <iconify-icon icon="solar:phone-calling-linear" stroke-width="1.5" class="text-gray-400 text-xl"></iconify-icon>
                                <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wider">Contact Details</h3>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs text-gray-500 font-medium block">Email Address</label>
                                <a href="mailto:isabella.rossi@example.com" class="text-sm text-gray-900 font-medium hover:text-blue-600 hover:underline transition-all flex items-center gap-2 group/link">
                                    {{ $user->email }}
                                    <iconify-icon icon="solar:arrow-right-up-linear" class="opacity-0 group-hover/link:opacity-100 text-xs transition-opacity"></iconify-icon>
                                </a>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs text-gray-500 font-medium block">Phone Number</label>
                                <div class="flex items-center justify-between">
                                    {{ $user->phone }}

                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600">Mobile</span>
                                </div>
                            </div>  
                           
                        </div>

                        <!-- Column 3: Address -->
                        <div class="p-6 sm:p-8 space-y-6">
                            <div class="flex items-center gap-2 mb-6">
                                <iconify-icon icon="solar:mailbox-linear" stroke-width="1.5" class="text-gray-400 text-xl"></iconify-icon>
                                <h3 class="text-sm font-medium text-gray-900 uppercase tracking-wider">Residence</h3>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs text-gray-500 font-medium block">Street Address</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $user->address ?? 'Not provided' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs text-gray-500 font-medium block">City</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $user->city ?? 'Not provided' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs text-gray-500 font-medium block">Postal Code</label>
                                    <p class="text-sm text-gray-900 font-medium">94114</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs text-gray-500 font-medium block">Country</label>
                                    <p class="text-sm text-gray-900 font-medium">Philippines</p>
                                </div>
                            </div>
                            
                            <!-- Static Map Placeholder -->
                            <div class="mt-4 h-24 w-full bg-gray-50 rounded-lg border border-gray-100 flex items-center justify-center relative overflow-hidden group cursor-pointer">
                                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#9ca3af_1px,transparent_1px)] [background-size:8px_8px]"></div>
                                <div class="flex items-center gap-2 text-xs font-medium text-gray-500 group-hover:text-gray-900 transition-colors z-10 bg-white/80 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-sm border border-gray-100">
                                    <iconify-icon icon="solar:map-arrow-right-linear" stroke-width="1.5"></iconify-icon>
                                    View on Map
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Footer Info -->
                    <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <p>Last updated 2 hours ago by <span class="text-gray-700 font-medium">Admin System</span></p>
                        <p>Client UUID: <span class="font-mono">8f92-12-99a</span></p>
                    </div>
                </div>

                <!-- Recent Activity Section (Optional visual filler) -->
                <div class="mt-8">
                    <h3 class="text-sm font-medium text-gray-900 mb-4 px-1">Recent Activity</h3>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-1">
                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition-colors cursor-pointer group">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 group-hover:bg-blue-100 transition-colors">
                                <iconify-icon icon="solar:letter-linear" stroke-width="1.5"></iconify-icon>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Email sent regarding policy renewal</p>
                                <p class="text-xs text-gray-500">Sent by System</p>
                            </div>
                            <span class="text-xs text-gray-400 tabular-nums">Oct 24, 10:23 AM</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>

        {{-- EDIT PROFILE MODAL --}}
<div id="edit-profile-modal" class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-[0px_2px_4px_rgba(0,0,0,0.02),0px_1px_0px_rgba(0,0,0,0.06)] w-full max-w-3xl overflow-hidden">
        
        <!-- Modal Header -->
    <div class="px-6 py-4 border-b border-gray-100">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-900 tracking-tight">Edit Profile</h2>
        <button id="close-modal" class="text-gray-400 hover:text-gray-600 transition-colors">
            <iconify-icon icon="solar:close-linear" stroke-width="1.5" class="text-lg"></iconify-icon>
        </button>
    </div>
    <!-- Description below H2 -->
    <p class="text-sm text-gray-500 mt-1">
        Update your personal information, contact details, and residence.
    </p>
</div>

        <!-- Modal Body -->
        <div class="p-6 sm:p-8">
            <form action="{{ route('client.profile.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 font-medium block">First Name</label>
                        <input type="text" name="first_name" value="{{ $user->first_name }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 font-medium block">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ $user->middle_name }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 font-medium block">Last Name</label>
                        <input type="text" name="last_name" value="{{ $user->last_name }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 font-medium block">Birthdate</label>
                        <input type="date" name="birthdate" value="{{ $user->birthdate }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 font-medium block">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 font-medium block">Phone</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 font-medium block">Address</label>
                        <input type="text" name="address" value="{{ $user->address }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 font-medium block">City</label>
                        <input type="text" name="city" value="{{ $user->city }}" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="space-y-1">
    <label class="text-xs text-gray-500 font-medium block">New Password</label>
    <input type="password" name="password" placeholder="Enter new password" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
</div>

<div class="space-y-1">
    <label class="text-xs text-gray-500 font-medium block">Confirm Password</label>
    <input type="password" name="password_confirmation" placeholder="Confirm new password" class="w-full border border-gray-200 rounded-lg p-2 text-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
</div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" id="close-modal" class="px-4 py-2 rounded-lg bg-gray-50 text-gray-700 hover:bg-gray-100">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800">Save Changes</button>
                </div>

            </form>
        </div>
    </div>
</div>

    </main>




  </div>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

      const editBtn = document.getElementById('edit-profile-btn');
    const modal = document.getElementById('edit-profile-modal');
const closeBtns = modal.querySelectorAll('#close-modal');

    editBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });


    closeBtns.forEach(btn => btn.addEventListener('click', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }));

    // Close modal on click outside
    modal.addEventListener('click', (e) => {
        if(e.target === modal){
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
document.addEventListener("DOMContentLoaded", function() {
    const exportBtn = document.getElementById("export-btn");
    exportBtn.addEventListener("click", function() {
        const { jsPDF } = window.jspdf;
        const profileCard = document.getElementById("profile-card");

        html2canvas(profileCard, { scale: 2 }).then((canvas) => {
            const imgData = canvas.toDataURL("image/png");
            const pdf = new jsPDF('p', 'pt', 'a4');

            // Page width and height in pt
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();

            // Canvas dimensions
            const imgWidth = canvas.width;
            const imgHeight = canvas.height;

            // Scale the image to fit A4 width
            const ratio = Math.min(pdfWidth / imgWidth, pdfHeight / imgHeight);
            const imgX = (pdfWidth - imgWidth * ratio) / 2;
            const imgY = 20;

            pdf.addImage(imgData, 'PNG', imgX, imgY, imgWidth * ratio, imgHeight * ratio);
            pdf.save("client-profile.pdf");
        });
    });
});
</script>
</body>
</html>