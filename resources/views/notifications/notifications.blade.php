<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
        <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
        <script src="https://preline.co/assets/vendor/preline/dist/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://preline.co/assets/css/main.min.css">
</head>
<body>
    @if(session('error'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        x-transition
        class="fixed top-5 right-5 z-[9999]"
    >
        <div class="flex items-start gap-3 bg-white border border-red-200 shadow-lg rounded-xl p-4 min-w-[280px]">
            
            <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                <iconify-icon icon="solar:danger-triangle-linear" width="20"></iconify-icon>
            </div>

            <div class="flex-1">
                <p class="text-sm font-semibold text-slate-900">
                    Error
                </p>
                <p class="text-xs text-slate-500 mt-1">
                    {{ session('error') }}
                </p>
            </div>

            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon>
            </button>
        </div>
    </div>
@endif
  @if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-init="setTimeout(() => show = false, 4000)" 
        x-show="show"
        x-transition
        class="fixed top-5 right-5 z-50"
    >
        <div class="flex items-start gap-3 bg-white border border-emerald-200 shadow-lg rounded-xl p-4 min-w-[280px]">
            
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                <iconify-icon icon="solar:check-circle-linear" width="20"></iconify-icon>
            </div>

            <div class="flex-1">
                <p class="text-sm font-semibold text-slate-900">
                    Success
                </p>
                <p class="text-xs text-slate-500 mt-1">
                    {{ session('success') }}
                </p>
            </div>

            <button @click="show = false" class="text-slate-400 hover:text-slate-600">
                <iconify-icon icon="solar:close-circle-linear" width="18"></iconify-icon>
            </button>
        </div>
    </div>
@endif

</body>
</html>