<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>

</head>
<body>
  <nav x-data="{ isOpen: false }" class="w-full relative bg-white border-b border-gray-100">
  <div class="flex items-center justify-between px-4 py-3 max-w-7xl mx-auto">
    
    <!-- Logo -->
    <a href="{{ url('/') }}" class="flex items-center font-bold text-lg text-gray-900">
      <div class="bg-gradient-to-br from-[#FD5068] to-[#FF7854] 
                  text-white font-bold rounded-full w-7 h-7 
                  flex items-center justify-center mr-2 text-sm">
        S
      </div>
      SkilledTrade
    </a>

    <!-- Nav Links -->
    <div class="hidden lg:flex items-center space-x-6 text-sm">
      <a href="#home" class="text-gray-700 hover:text-[#FD5068] transition">Home</a>
      <a href="#about" class="text-gray-700 hover:text-[#FD5068] transition">About</a>
      <a href="#community" class="text-gray-700 hover:text-[#FD5068] transition">Community</a>
      <a href="#server" class="text-gray-700 hover:text-[#FD5068] transition">Server</a>
    </div>

    <!-- Buttons -->
    <div class="hidden lg:flex items-center space-x-3 text-sm">
      <a href="{{ url('/create-account-worker') }}"
         class="font-medium text-gray-700 hover:text-[#FD5068] transition">
        Register Worker
      </a>

      <a href="{{ url('/create-account-user') }}"
         class="px-3 py-1.5 rounded-md font-medium text-white
                bg-gradient-to-r from-[#FD5068] to-[#FF7854]
                hover:opacity-90 transition shadow-sm">
        Register Customer
      </a>
    </div>

    <!-- Mobile Hamburger -->
    <button @click="isOpen = !isOpen" class="lg:hidden text-gray-800">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path :class="{ 'hidden': isOpen }"
              stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        <path :class="{ 'hidden': !isOpen }"
              stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div x-show="isOpen" x-transition class="lg:hidden bg-white border-t border-gray-100">
    <div class="flex flex-col items-center py-4 space-y-3 text-sm">
      <a href="#home" class="text-gray-700 hover:text-[#FD5068]" @click="isOpen=false">Home</a>
      <a href="#about" class="text-gray-700 hover:text-[#FD5068]" @click="isOpen=false">About</a>
      <a href="#community" class="text-gray-700 hover:text-[#FD5068]" @click="isOpen=false">Community</a>
      <a href="#server" class="text-gray-700 hover:text-[#FD5068]" @click="isOpen=false">Server</a>

      <a href="worker_join.php"
         class="w-36 text-center py-1.5 rounded-md border border-gray-200
                text-gray-700 hover:border-[#FD5068] hover:text-[#FD5068] transition">
        Register Worker
      </a>

      <a href="customer_join.php"
         class="w-36 text-center py-1.5 rounded-md text-white
                bg-gradient-to-r from-[#FD5068] to-[#FF7854]
                hover:opacity-90 transition">
        Register Customer
      </a>
    </div>
  </div>
</nav>


</body>
</html>