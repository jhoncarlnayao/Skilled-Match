<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SkilledTrade</title>
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
    <div class="bg-white p-8 md:p-12 rounded-md shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-gray-100 w-full max-w-md">

        <div class="text-center mb-8">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="hidden md:block w-20 h-20 mx-auto mb-4">
            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 uppercase">
                Welcome Back
            </h1>
            <p class="text-gray-400 text-[14px] mt-2 leading-relaxed">
                Sign in to manage your jobs and profile.
            </p>
        </div>

        {{-- Display error messages --}}
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-xs font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Username</label>
                <input type="text" name="username" required placeholder="Your username"
                       class="w-full px-4 py-3 rounded-sm border border-gray-200 focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition text-sm text-gray-700"
                       value="{{ old('username') }}">
            </div>

            <div>
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="block text-[11px] font-bold text-gray-400 uppercase tracking-wider">Password</label>
                </div>
                <input type="password" name="password" required placeholder="••••••••"
                       class="w-full px-4 py-3 rounded-sm border border-gray-200 focus:ring-4 focus:ring-[#FD5068]/5 focus:border-[#FD5068] outline-none transition text-sm text-gray-700">
            </div>

            <button type="submit"
                    class="group relative w-full py-4 mt-2 text-white font-bold rounded-sm overflow-hidden transition-all duration-300 shadow-lg shadow-[#FD5068]/25 hover:shadow-xl hover:shadow-[#FD5068]/40 hover:-translate-y-0.5 active:scale-[0.98] active:translate-y-0"
                    style="background: linear-gradient(135deg, #FD5068 0%, #FF7854 100%);">
                
                <div class="absolute inset-0 w-full h-full bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <span class="relative flex items-center justify-center gap-2">
                    Sign In to Account
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </span>
            </button>
        </form>

        <div class="text-center mt-10">
            <p class="text-[13px] text-gray-400 mb-4">Don't have an account? Register as:</p>
            <div class="flex justify-center items-center gap-6">
                <a href="{{ url('create-account-worker') }}" class="group flex flex-col items-center gap-1">
                    <span class="text-sm font-bold text-gray-700 group-hover:text-[#FD5068] transition-colors">Worker</span>
                    <div class="h-1 w-0 group-hover:w-full bg-[#FD5068] transition-all duration-300 rounded-full"></div>
                </a>
                <span class="h-4 w-[1px] bg-gray-200"></span>
                <a href="{{ url('create-account-user') }}" class="group flex flex-col items-center gap-1">
                    <span class="text-sm font-bold text-gray-700 group-hover:text-[#FF7854] transition-colors">Client</span>
                    <div class="h-1 w-0 group-hover:w-full bg-[#FF7854] transition-all duration-300 rounded-full"></div>
                </a>
            </div>
            <p class="text-gray-400 text-[11px] mt-8 leading-relaxed">
                By signing in, you agree to our <br>
                <a href="#" class="underline hover:text-gray-600">Terms of Service</a> and <a href="#" class="underline hover:text-gray-600">Privacy Policy</a>.
            </p>
        </div>
    </div>
</div>

</body>
</html>
