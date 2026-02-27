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
                          {{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}
                      </h2>
                      <p class="text-gray-500 text-sm">
                          {{ $user->email }}
                      </p>
                  </div>
              </td>

              <!-- Status -->
    <!-- Status -->
<td class="px-12 py-4">
  @if($user->status === 'active')

    <!-- Active -->
    <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium
                 text-green-700 bg-green-50 border border-green-200 rounded-full">
        
        <!-- Check Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-3.5 h-3.5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M5 13l4 4L19 7"/>
        </svg>

        Active
    </span>

  @else

    <!-- Deactivated (Red Style Same Tone as Button) -->
    <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium
                 text-red-700 bg-red-50 border border-red-200 rounded-full">
        
        <!-- X Icon -->
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-3.5 h-3.5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12"/>
        </svg>

        Deactivated
    </span>

  @endif
</td>


              <!-- About -->
              <td class="px-4 py-4 text-sm">
                  <p class="text-gray-700">{{ $user->role }}</p>
                  <p class="text-gray-500 text-sm">
                      Joined: {{ $user->created_at->format('M d, Y') }}
                  </p>
              </td>


            <!-- Action -->
<td class="px-4 py-4 text-sm">
  <div class="flex items-center gap-2">
 <button type="button"
        data-hs-overlay="#view-user-modal-{{ $user->id }}"
        class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
               text-gray-700 bg-white border border-gray-300 rounded-lg
               hover:bg-gray-50 hover:border-gray-400
               focus:outline-none focus:ring-2 focus:ring-gray-200 transition">
    View Details
</button>

    <!-- Edit -->
<button type="button"
        data-hs-overlay="#edit-user-modal-{{ $user->id }}"
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
              d="M11 5h2M12 7v10m-7 4h14a2 2 0 002-2V7l-6-4H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>

    Edit
</button>



  <div class="flex gap-2">

        @if($user->status === 'active')

            <!-- Deactivate Button -->
           <a href="{{ route('admin.client.toggle', $user->id) }}"
   class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
          text-red-700 bg-red-50 border border-red-200 rounded-lg
          hover:bg-red-100
          focus:outline-none focus:ring-2 focus:ring-red-200 transition">

    <!-- X Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-4 h-4"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor"
         stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12"/>
    </svg>

    Deactivate
</a>


        @else

            <!-- Activate Button -->
        <a href="{{ route('admin.client.toggle', $user->id) }}"
   class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium
          text-green-700 bg-green-50 border border-green-200 rounded-lg
          hover:bg-green-100
          focus:outline-none focus:ring-2 focus:ring-green-200 transition">

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
  
  <div>
    <h3 class="text-lg font-semibold text-gray-800">
      Edit Client Account
    </h3>
    <p class="text-sm text-gray-500 mt-1">
      Update client information and manage account details.
    </p>
  </div>

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

  <!-- First Name -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      First Name
    </label>
    <input type="text"
           name="first_name"
           value="{{ $user->first_name }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
           required>
  </div>

  <!-- Middle Name -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Middle Name
    </label>
    <input type="text"
           name="middle_name"
           value="{{ $user->middle_name }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
  </div>

  <!-- Last Name -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Last Name
    </label>
    <input type="text"
           name="last_name"
           value="{{ $user->last_name }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
           required>
  </div>

  <!-- Username -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Username
    </label>
    <input type="text"
           name="username"
           value="{{ $user->username }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
           required>
  </div>

  <!-- Email -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Email Address
    </label>
    <input type="email"
           name="email"
           value="{{ $user->email }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
           required>
  </div>

  <!-- Phone -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Phone
    </label>
    <input type="text"
           name="phone"
           value="{{ $user->phone }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
  </div>

  <!-- Birthdate -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Birthdate
    </label>
    <input type="date"
           name="birthdate"
           value="{{ $user->birthdate }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
  </div>

  <!-- Address -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Address
    </label>
    <input type="text"
           name="address"
           value="{{ $user->address }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
  </div>

  <!-- City -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      City
    </label>
    <input type="text"
           name="city"
           value="{{ $user->city }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
  </div>

  <!-- Postal Code -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Postal Code
    </label>
    <input type="text"
           name="postal_code"
           value="{{ $user->postal_code }}"
           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl 
                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
  </div>

  <!-- Role -->
<div>
  <label class="block text-sm font-medium text-gray-600 mb-2">
    Role
  </label>

  <input type="text"
         value="{{ ucfirst($user->role) }}"
         readonly
         class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl 
                bg-gray-100 text-gray-500 cursor-not-allowed">
</div>

  <!-- Status -->
  <div>
    <label class="block text-sm font-medium text-gray-600 mb-2">
      Account Status
    </label>
    <select name="status"
            class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-xl
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
      <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
      <option value="deactivate" {{ $user->status == 'deactivate' ? 'selected' : '' }}>Deactivated</option>
    </select>
  </div>

  <!-- Footer -->
  <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
    <button type="button"
            data-hs-overlay="#edit-user-modal-{{ $user->id }}"
            class="px-5 py-2.5 text-sm font-medium border border-gray-300 rounded-xl hover:bg-gray-100 transition">
      Cancel
    </button>

    <button type="submit"
            class="px-5 py-2.5 text-sm font-medium text-white bg-slate-900 hover:bg-slate-800 rounded-xl transition shadow-sm">
      Save Changes
    </button>
  </div>

</form>
      </div>
    </div>
  </div>
</div>
@endforeach

@foreach($users as $user)
<div id="view-user-modal-{{ $user->id }}"
     class="hs-overlay hidden fixed inset-0 z-[80] overflow-y-auto">

  <div class="flex items-center justify-center min-h-screen px-4">
    
    <div class="relative w-full max-w-lg bg-white rounded-lg shadow-xl sm:p-6 p-5">

      <!-- Close Button -->
      <div class="absolute top-4 right-4">
        <button type="button"
                data-hs-overlay="#view-user-modal-{{ $user->id }}"
                class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
          ✕
        </button>
      </div>

      <!-- Header -->
      <div class="flex flex-col items-center gap-3">
        
        <!-- Profile Picture -->
        <img
          src="{{ $user->profile_picture 
                  ? asset('storage/' . $user->profile_picture) 
                  : 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) }}"
          class="w-24 h-24 rounded-full ring-2 ring-gray-200 object-cover"
          alt="Profile Picture">

        <h3 class="text-lg font-medium text-gray-800">
          Client Details
        </h3>

        <p class="text-sm text-gray-500 text-center">
          Review the information of this user.
        </p>
      </div>

      <!-- Form Body -->
      <form class="mt-4 space-y-3">

        <!-- Full Name -->
        <div>
          <label class="block text-sm text-gray-700">Full Name</label>
          <input type="text"
                 value="{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}"
                 readonly
                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md">
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm text-gray-700">Email</label>
          <input type="email"
                 value="{{ $user->email }}"
                 readonly
                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md">
        </div>

        <!-- Status -->
        <div>
          <label class="block text-sm text-gray-700">Status</label>
          <input type="text"
                 value="{{ ucfirst($user->status) }}"
                 readonly
                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md">
        </div>

        <!-- Address -->
        <div>
          <label class="block text-sm text-gray-700">Address</label>
          <input type="text"
                 value="{{ $user->address }}"
                 readonly
                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md">
        </div>

        <!-- City -->
        <div>
          <label class="block text-sm text-gray-700">City</label>
          <input type="text"
                 value="{{ $user->city }}"
                 readonly
                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md">
        </div>

        <!-- Postal Code -->
        <div>
          <label class="block text-sm text-gray-700">Postal Code</label>
          <input type="text"
                 value="{{ $user->postal_code }}"
                 readonly
                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md">
        </div>

        <!-- Role -->
        <div>
          <label class="block text-sm text-gray-700">Role</label>
          <input type="text"
                 value="{{ ucfirst($user->role) }}"
                 readonly
                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md">
        </div>

        <!-- Joined Date -->
        <div>
          <label class="block text-sm text-gray-700">Joined Date</label>
          <input type="text"
                 value="{{ $user->created_at->format('M d, Y') }}"
                 readonly
                 class="block w-full px-4 py-3 text-sm text-gray-700 bg-white border border-gray-200 rounded-md">
        </div>

        <!-- Footer -->
        <div class="mt-4 flex justify-end">
          <button type="button"
                  data-hs-overlay="#view-user-modal-{{ $user->id }}"
                  class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-md hover:bg-gray-100">
            Close
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
@endforeach
    </main>
  </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/preline@latest/dist/preline.js"></script>
  <script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</body>
</html>