
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join the Crew | SkilledTrade</title>
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; }
        ::-webkit-scrollbar { display: none; }
        html { scrollbar-width: none; }
    </style>
</head>
<body>
@include('navigation-bar.navbar')
<div class="flex items-center justify-center min-h-screen p-6">
    <div class="bg-white p-8 md:p-10 rounded-md shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-gray-100 w-full max-w-lg">

        <div class="text-center mb-8">
            <img src="assets/logo.png" alt="Logo" class="hidden md:block w-16 h-16 mx-auto mb-4">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 uppercase">
                Worker Registration
            </h1>
            <p class="text-gray-400 text-[14px] mt-2 leading-relaxed">
                Build your reputation and find high-paying jobs.
            </p>
        </div>

      @if(session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="bg-red-100 text-red-800 p-2 rounded">{{ $errors->first() }}</div>
@endif


<form method="POST" action="{{ route('worker.register') }}" class="space-y-5">
    @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">First Name</label>
                    <input type="text" name="first_name" required placeholder="John"
                           class="w-full px-4 py-3 rounded-sm border border-gray-200 text-sm focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Middle Name</label>
                    <input type="text" name="middle_name" placeholder="Quincy"
                           class="w-full px-4 py-3 rounded-sm border border-gray-200 text-sm focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Last Name</label>
                    <input type="text" name="last_name" required placeholder="Doe"
                           class="w-full px-4 py-3 rounded-sm border border-gray-200 text-sm focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Username</label>
                    <input type="text" name="username" required placeholder="cjpogi123"
                           class="w-full px-4 py-3 rounded-sm border border-gray-200 focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition text-sm text-gray-700">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full px-4 py-3 rounded-sm border border-gray-200 focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition text-sm text-gray-700">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Phone Number</label>
                    <input type="tel" name="phone" required placeholder="+63 9..."
                           class="w-full px-4 py-3 rounded-sm border border-gray-200 text-sm focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="worker@email.com"
                           class="w-full px-4 py-3 rounded-sm border border-gray-200 text-sm focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
               <div>
    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Trade Skill</label>
    <select name="trade_id" required
            class="w-full px-4 py-3 rounded-sm border border-gray-200 text-sm focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none appearance-none bg-white">
        <option value="">Select Specialty</option>
        @foreach($trades as $trade)
            <option value="{{ $trade->id }}">{{ $trade->name }}</option>
        @endforeach
    </select>
</div>

                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Experience (Years)</label>
                    <input type="number" name="experience_years" min="0" required placeholder="5"
                           class="w-full px-4 py-3 rounded-sm border border-gray-200 text-sm focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition">
                </div>
            </div>

            <button type="submit"
                    class="w-full py-4 mt-4 text-white font-bold rounded-sm cursor-pointer transition duration-200 shadow-lg shadow-[#FD5068]/20 hover:brightness-110 active:scale-[0.98]"
                    style="background: linear-gradient(135deg, #FD5068 0%, #FF7854 100%);">
                Create My Profile
            </button>
        </form>

        <div class="text-center mt-8">
            <p class="text-[13px] text-gray-400">
                Already have a profile? 
                <a href="{{ route('login') }}" class="text-[#FD5068] font-bold hover:underline ml-1">Log in</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>