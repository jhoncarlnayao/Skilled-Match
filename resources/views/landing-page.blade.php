<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkilledTrade | It's a Match!</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/preline.js"></script>

    
</head>

<style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
            :root {
            --primary: #FD5068;
            --secondary: #FF7854;
            --dark: #24292e;
            --light: #f8f8f8;
            --gradient: linear-gradient(135deg, #FD5068 0%, #FF7854 100%);
              --brand-primary: #883E9A;
  --brand-gradient: linear-gradient(135deg, #883E9A 0%, #FF7854 100%);
        }

  .brand-text {
  font-family: 'Inter', sans-serif;
  font-weight: 800;
  font-size: 24px;
  color: var(--primary); /* visible on white */
  text-decoration: none;
  line-height: 1;
}

  .brand-text-footer{
  font-family: 'Inter', sans-serif;
  font-weight: 800;
  font-size: 24px;
  /* color: var(--primary);  */
  color:white;
  text-decoration: none;
  line-height: 1;
}


      .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 24px;
            color: white;
            text-decoration: none;
        }

        .logo-box {
            width: 35px;
            height: 35px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
        }

            .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            margin-left: 20px;
            padding: 10px 20px;
            border-radius: 50px;
            transition: 0.3s;
        }

        /* ─── HERO SECTION ─── */
        .hero {
            height: 100vh;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 0 20px;
            position: relative;
        }

        .hero-content h1 {
            font-size: clamp(40px, 8vw, 80px);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            color: white;
            font-family: "Inter", sans-serif;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
            color: white;
            font-family: "Inter", sans-serif;
        }

        .cta-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 18px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-white {
            background: white;
            color: var(--primary);
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

</style>
<body>

<!-- 1ST SECTION -->

<section class="bg-white pb-20 lg:pb-20" id="home">
<nav x-data="{ isOpen: false }" class="w-full relative" style="background: linear-gradient(135deg, #FD5068 0%, #FF7854 100%);">
  <div class="flex items-center justify-between px-4 py-2 max-w-7xl mx-auto">
    
    <!-- Logo -->
    <a href="#" class="flex items-center text-white font-bold text-lg">
      <div class="logo-box bg-white text-[#FD5068] font-bold rounded-full w-7 h-7 flex items-center justify-center mr-2 text-sm">S</div>
      SkilledTrade
    </a>

    <!-- Nav Links -->
    <div class="hidden lg:flex items-center space-x-6 text-sm">
      <a href="#home" class="text-white hover:text-purple-200 transition">Home</a>
      <a href="#about" class="text-white hover:text-purple-200 transition">About</a>
      <a href="#community" class="text-white hover:text-purple-200 transition">Community</a>
      <a href="#server" class="text-white hover:text-purple-200 transition">Server</a>
    </div>

    <!-- Buttons -->
    <div class="hidden lg:flex items-center space-x-3 text-sm">
      <a href="create_account_worker.php" class="text-white font-medium hover:text-purple-200 transition">
        Register Worker
      </a>
      <a href="create_account_user.php" class="px-2 py-1 border border-white text-white font-medium rounded-md hover:bg-white hover:text-[#FD5068] transition">
        Register Customer
      </a>
    </div>

    <!-- Mobile Hamburger -->
    <button @click="isOpen = !isOpen" class="lg:hidden text-white focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path :class="{ 'hidden': isOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        <path :class="{ 'inline-flex': isOpen, 'hidden': !isOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

  </div>

  <!-- Mobile Menu -->
  <div x-show="isOpen" x-transition class="lg:hidden bg-gradient-to-r from-[#FD5068] to-[#FF7854]">
    <div class="flex flex-col items-center py-3 space-y-3 text-sm">
      <a href="#home" class="text-white hover:text-purple-200 transition" @click="isOpen = false">Home</a>
      <a href="#about" class="text-white hover:text-purple-200 transition" @click="isOpen = false">About</a>
      <a href="#community" class="text-white hover:text-purple-200 transition" @click="isOpen = false">Community</a>
      <a href="#server" class="text-white hover:text-purple-200 transition" @click="isOpen = false">Server</a>
      <div class="flex flex-col space-y-1 mt-2">
        <button class="btn btn-sm btn-white w-36 mx-auto">Register Worker</button>
        <button class="btn btn-sm btn-outline text-white border-white hover:bg-white hover:text-[#FD5068] w-36 mx-auto">Register Customer</button>
      </div>
    </div>
  </div>
</nav>


  <!-- Hero Section -->
  <div class="relative grid w-full h-126 lg:h-[42rem] place-items-center"
       style="background: linear-gradient(135deg, #FD5068 0%, #FF7854 100%);">
    <div class="flex flex-col items-center mx-auto text-center">
      <div class="hero-content">
        <h1 class="text-white text-4xl lg:text-6xl font-bold mb-4">Swipe Right on<br>Quality Work.</h1>
        <p class="text-white text-lg lg:text-xl mb-6">The first "Dating App" for skilled trades. Find the plumber,<br>electrician, or carpenter of your dreams.</p>
      </div>

      <a href="{{ url('login') }}"
         class="mt-8 flex items-center gap-3 cursor-pointer animate-bounce">
        <span class="text-white text-lg md:text-base font-semibold tracking-wide">Sign In Now</span>
        <svg width="60" height="60" viewBox="0 0 53 53" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="27" cy="26" r="18" stroke="white" stroke-width="2"></circle>
          <path d="M22.41 23.2875L27 27.8675L31.59 23.2875L33 24.6975L27 30.6975L21 24.6975L22.41 23.2875Z" fill="white"></path>
        </svg>
      </a>
    </div>
  </div>

  <!-- Wave SVG -->
  <svg viewBox="0 0 1440 57" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <linearGradient id="heroGradient" x1="0" y1="0" x2="1" y2="0">
        <stop offset="0%" stop-color="#FD5068" />
        <stop offset="100%" stop-color="#FF7854" />
      </linearGradient>
    </defs>
    <path d="M1440 0H0V57C720 0 1440 57 1440 57V0Z" fill="url(#heroGradient)"></path>
  </svg>

</section>




<section class="container px-6 py-12 mx-auto lg:py-20" id="about1">
  <div class="lg:flex lg:items-center lg:gap-12">
    
    <!-- Text content -->
    <div class="lg:w-1/2">
      <h3 class="text-2xl font-bold text-gray-800 md:text-3xl lg:text-4xl">
        Find the Right Match for Your Project
      </h3>
      <p class="mt-6 text-gray-500 text-lg">
        Connecting homeowners and businesses with skilled tradespeople has never been easier. Whether you need a plumber, electrician, or carpenter, we make finding the perfect professional as simple as swiping right.
      </p>
    </div>

    <!-- Image content -->
    <div class="mt-8 lg:w-1/2 lg:mt-0">
      <img 
        class="object-cover w-full rounded-xl h-96 border border-gray-200"
        src="assets/image1.png" 
        alt="Project Illustration">
    </div>

  </div>
</section>
<section class="bg-white py-20 lg:py-40" id="about">
  <div class="container mx-auto px-4 text-center">

    <!-- FEATURES -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 max-w-5xl mx-auto text-center">
      
      <!-- Feature 1: Perfect Matches -->
      <div class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4" fill="#FD5068" viewBox="0 0 24 24" stroke="none">
          <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.77 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/>
        </svg>
        <h4 class="text-xl md:text-2xl font-semibold mb-2" style="color: #FD5068;">Perfect Matches Every Time</h4>
        <p class="text-slate-500">
          Swipe through qualified tradespeople and find someone who fits your project perfectly.
        </p>
      </div>

      <!-- Feature 2: Safe & Reliable -->
      <div class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4" fill="#FD5068" viewBox="0 0 24 24" stroke="none">
          <path d="M12 2l8 4v6c0 5-4 9-8 10-4-1-8-5-8-10V6l8-4z"/>
        </svg>
        <h4 class="text-xl md:text-2xl font-semibold mb-2" style="color: #FD5068;">Safe & Reliable</h4>
        <p class="text-slate-500">
          All professionals are verified, reviewed, and rated—no surprises, just quality work.
        </p>
      </div>

      <!-- Feature 3: Save Time & Effort -->
      <div class="flex flex-col items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4" fill="#FD5068" viewBox="0 0 24 24" stroke="none">
          <path d="M2 22l8-8 3 3 12-12-3-3-12 12-3-3-8 8v3h3z"/>
        </svg>
        <h4 class="text-xl md:text-2xl font-semibold mb-2" style="color: #FD5068;">Save Time & Effort</h4>
        <p class="text-slate-500">
          Forget endless searching; our app helps you connect instantly with skilled workers nearby.
        </p>
      </div>

    </div>

    <!-- STATS -->
    <div class="container grid grid-cols-2 gap-6 px-4 mx-auto mt-16 text-center lg:grid-cols-4 pt-12 border-t border-slate-200">
      <div>
        <p class="text-3xl md:text-4xl font-bold" style="color: #FF7854;">100+</p>
        <p class="mt-1 text-sm md:text-base text-slate-500">Skilled Pros – Available and ready for your project</p>
      </div>

      <div>
        <p class="text-3xl md:text-4xl font-bold" style="color: #FF7854;">Thousands</p>
        <p class="mt-1 text-sm md:text-base text-slate-500">Jobs Matched – Successfully connected workers and clients</p>
      </div>

      <div>
        <p class="text-3xl md:text-4xl font-bold" style="color: #FF7854;">5★</p>
        <p class="mt-1 text-sm md:text-base text-slate-500">Average Rating – Verified quality work every time</p>
      </div>

      <div>
        <p class="text-3xl md:text-4xl font-bold" style="color: #FF7854;">24/7</p>
        <p class="mt-1 text-sm md:text-base text-slate-500">Support – We’re here to help you anytime</p>
      </div>
    </div>

  </div>
</section>

<section class="container px-6 py-8 mx-auto lg:py-16" id="community">
  
  <!-- Section Heading -->
  <div class="text-center">
    <h3 class="text-xl font-medium md:text-2xl lg:text-3xl">
      Meet the Community
    </h3>
    <p class="mt-2 text-slate-500 md:text-lg">
      See how our users are connecting with skilled tradespeople and completing amazing projects every day.<br>Swipe through the moments that bring professionals and clients together.
    </p>
  </div>

  <!-- Image Grid -->
  <div class="grid grid-cols-1 gap-10 mt-10 md:grid-cols-2 lg:grid-cols-3">
      
      <a href="#" class="transition-all duration-500 lg:col-span-2 hover:scale-105">
          <img class="object-cover object-top w-full rounded-lg shadow-md shadow-gray-200 h-80 xl:h-96" 
               src="https://i.pinimg.com/736x/be/69/06/be69065d5d8e3aa3df8315275a3b7a6a.jpg" alt="Project Image 1">
      </a>
      
      <a href="#" class="transition-all duration-500 hover:scale-105">
          <img class="object-cover object-top w-full rounded-lg shadow-md shadow-gray-200 h-80 xl:h-96" 
               src="https://i.pinimg.com/1200x/d3/58/6b/d3586b7883add5cc5cb6c5c135dcc876.jpg" alt="Project Image 2">
      </a>
      
      <a href="#" class="transition-all duration-500 hover:scale-105">
          <img class="object-cover object-top w-full rounded-lg shadow-md shadow-gray-200 h-80 xl:h-96" 
               src="https://i.pinimg.com/736x/e7/3f/78/e73f78379a8ca1290d45f6edeba2a5c2.jpg" alt="Project Image 3">
      </a>
      
      <a href="#" class="transition-all duration-500 lg:col-span-2 hover:scale-105">
          <img class="object-cover object-top w-full rounded-lg shadow-md shadow-gray-200 h-80 xl:h-96" 
               src="https://i.pinimg.com/736x/c4/44/28/c4442835e56b1ce7d9c067952e934f23.jpg" alt="Project Image 4">
      </a>
      
  </div>
</section>


<section class="bg-white pt-20 pb-20 lg:pb-40" id="server">
  <div class="container flex flex-col items-center px-4 py-12 mx-auto text-center">

    <!-- LOGO + BRAND -->
    <div class="mb-6 flex items-center ">
      <img
        src="assets/logo.png"
        alt="Platform Logo"
        class="w-auto max-w-[100px]"
      />

      <a href="#" class="brand-text" >
        SkilledTrade
      </a>
    </div>

    <h2 class="text-2xl font-bold tracking-tight text-slate-900 xl:text-3xl">
      Start Swiping Today
    </h2>

    <p class="max-w-3xl mt-4 text-slate-600">
      Sign up, browse skilled tradespeople near you, and connect instantly. Quality work is just a swipe away!
    </p>

    <!-- TAGS -->
    <div class="flex flex-wrap justify-center gap-2 mt-6">
      <span class="px-3 py-1 text-xs font-medium text-slate-700 bg-slate-100 rounded-full">
        Verified Pros
      </span>
      <span class="px-3 py-1 text-xs font-medium text-slate-700 bg-slate-100 rounded-full">
        Instant Matches
      </span>
      <span class="px-3 py-1 text-xs font-medium text-slate-700 bg-slate-100 rounded-full">
        Local Services
      </span>
      <span class="px-3 py-1 text-xs font-medium text-slate-700 bg-slate-100 rounded-full">
        5-Star Reviews
      </span>
      <span class="px-3 py-1 text-xs font-medium text-slate-700 bg-slate-100 rounded-full">
        24/7 Support
      </span>
    </div>

    <!-- CTA -->
    <div class="mt-8">
      <a
        href="{{ url('login') }}"
        class="inline-flex items-center justify-center px-8 py-3 text-sm font-semibold text-white
               bg-[#FD5068] rounded-lg shadow-sm
               transition-colors duration-300 hover:bg-indigo-500
               focus:ring focus:ring-indigo-300 focus:ring-opacity-80"
      >
        Join Now!
      </a>
    </div>

  </div>
</section>
<footer class="relative overflow-hidden bg-white">
  <!-- SVG Waves -->
  <svg class="absolute -bottom-20 start-1/2 w-[1900px] transform -translate-x-1/2" width="2745" height="488" viewBox="0 0 2745 488" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M0.5 330.864C232.505 403.801 853.749 527.683 1482.69 439.719C2111.63 351.756 2585.54 434.588 2743.87 487" stroke="rgba(0,0,0,0.2)" stroke-width="2"></path>
    <path d="M0.5 308.873C232.505 381.81 853.749 505.692 1482.69 417.728C2111.63 329.765 2585.54 412.597 2743.87 465.009" stroke="rgba(0,0,0,0.15)" stroke-width="2"></path>
    <path d="M0.5 286.882C232.505 359.819 853.749 483.701 1482.69 395.738C2111.63 307.774 2585.54 390.606 2743.87 443.018" stroke="rgba(0,0,0,0.1)" stroke-width="2"></path>
    <path d="M0.5 264.891C232.505 337.828 853.749 461.71 1482.69 373.747C2111.63 285.783 2585.54 368.615 2743.87 421.027" stroke="rgba(0,0,0,0.08)" stroke-width="2"></path>
    <path d="M0.5 242.9C232.505 315.837 853.749 439.719 1482.69 351.756C2111.63 263.792 2585.54 346.624 2743.87 399.036" stroke="rgba(0,0,0,0.06)" stroke-width="2"></path>
  </svg>

  <!-- Footer content -->
  <div class="relative z-10">
    <div class="w-full max-w-5xl px-4 xl:px-0 py-10 lg:pt-16 mx-auto flex items-center justify-between">
      <!-- Logo + Brand -->
      <div class="flex items-center gap-3">
        <img src="{{ asset('assets/logo-nobg.png') }}" alt="Platform Logo" class="w-auto max-w-[100px]" />
        <span class="font-bold text-lg text-gray-900 brand-text">SkilledTrade</span>
      </div>

      <!-- Copyright -->
      <p class="text-sm text-gray-500">© 2026 SkilledTrade.</p>
    </div>
  </div>
</footer>


</body>
</html>

<script>

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      e.preventDefault();

      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        window.scrollTo({
          top: target.offsetTop - 80,
          behavior: 'smooth'
        });
      }

     
      if (typeof Alpine !== 'undefined') {
        Alpine.store?.menu?.close?.();
      }
    });
  });
</script>