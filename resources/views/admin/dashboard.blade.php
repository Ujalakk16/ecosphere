<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" 
      dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}"
      x-data="{ sidebarOpen: false, darkMode: localStorage.theme === 'dark' }" 
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => { localStorage.theme = val ? 'dark' : 'light'; 
      document.documentElement.classList.toggle('dark', val); })">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@trans('Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-300">

<div class="min-h-screen flex">
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-8 transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static shadow-2xl md:shadow-none flex-shrink-0">
        
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">@trans('Ecosphere')</h2>
            <button @click="sidebarOpen = false" class="md:hidden text-2xl text-slate-500"><i class="fa-solid fa-xmark"></i></button>
        </div>
        
        <nav class="space-y-4">
            <a href="admin/dashboard" class="flex items-center gap-3 py-3 px-4 rounded-xl bg-indigo-600 text-white font-bold"><i class="fa-solid fa-gauge"></i> @trans('Dashboard')</a>
            <a href="/" class="flex items-center gap-3 py-3 px-4 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition"><i class="fa-solid fa-store"></i> @trans('Back to Store')</a>
        </nav>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 md:hidden"></div>

    <main class="flex-1 w-full min-w-0 overflow-hidden flex flex-col">
        <header class="p-6 md:p-10 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-2xl text-slate-500"><i class="fa-solid fa-bars"></i></button>
                <h1 class="text-3xl font-extrabold tracking-tight">@trans('Admin Overview')</h1>
            </div>
            <button @click="darkMode = !darkMode" class="px-5 py-2 bg-slate-200 dark:bg-slate-800 rounded-lg font-bold">
                <span x-text="darkMode ? '☀️ @trans('Light')' : '🌙 @trans('Dark')'"></span>
            </button>
        </header>

        <div class="px-6 md:px-10 pb-10">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    
    <a href="{{ route('admin.products') }}" class="block bg-white dark:bg-slate-800 p-6 rounded-2xl border dark:border-slate-700 shadow-sm hover:border-indigo-500 transition-all duration-300">
        <p class="text-xs font-bold text-slate-400 uppercase">@trans('Products')</p>
        <h3 class="text-3xl font-black mt-2">{{ $totalCount ?? 0 }}</h3>
    </a>

    <a href="{{ route('admin.users') }}" class="block bg-white dark:bg-slate-800 p-6 rounded-2xl border dark:border-slate-700 shadow-sm hover:border-indigo-500 transition-all duration-300">
        <p class="text-xs font-bold text-indigo-500 uppercase">@trans('Users')</p>
        <h3 class="text-3xl font-black mt-2">{{ $userCount ?? 0 }}</h3>
    </a>

    <a href="#" class="block bg-white dark:bg-slate-800 p-6 rounded-2xl border dark:border-slate-700 shadow-sm hover:border-rose-500 transition-all duration-300">
        <p class="text-xs font-bold text-rose-500 uppercase">@trans('Elastic')</p>
        <h3 class="text-3xl font-black mt-2">{{ $elasticCount ?? 0 }}</h3>
    </a>

    <a href="#" class="block bg-white dark:bg-slate-800 p-6 rounded-2xl border dark:border-slate-700 shadow-sm hover:border-emerald-500 transition-all duration-300">
        <p class="text-xs font-bold text-emerald-500 uppercase">@trans('Inelastic')</p>
        <h3 class="text-3xl font-black mt-2">{{ $inelasticCount ?? 0 }}</h3>
    </a>

</div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl border dark:border-slate-700 shadow-xl overflow-hidden">
                <div class="p-8 border-b dark:border-slate-700 flex justify-between items-center">
                    <h2 class="text-xl font-bold">@trans('Manage Assets')</h2>
                    <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold text-sm hover:bg-indigo-700 transition">+ @trans('Add Product')</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-[600px]">
                        <thead class="text-slate-400 text-xs uppercase bg-slate-50 dark:bg-slate-900/50">
                            <tr><th class="p-6">@trans('Name')</th><th class="p-6">@trans('Price')</th><th class="p-6">@trans('Stock')</th><th class="p-6 text-center">@trans('Actions')</th></tr>
                        </thead>
                        <tbody class="divide-y dark:divide-slate-700">
                            @foreach($products as $product)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <td class="p-6 font-semibold">{{ $product->name }}</td>
                                <td class="p-6 font-mono">${{ number_format($product->price, 2) }}</td>
                                <td class="p-6">{{ $product->stock }}</td>
                                <td class="p-6 text-center space-x-4">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-500 font-bold">@trans('Edit')</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 font-bold" onclick="return confirm('Are you sure?')">@trans('Delete')</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
      
    </main>
</div>
<footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <div class="col-span-1 lg:col-span-1">
                <h2 class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mb-4 tracking-tighter">@trans('ECOSPHERE')</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                    @trans('The future of sustainable marketplace management. Fast, secure, and intuitive.')
                </p>
            </div>

            <div>
                <h4 class="text-slate-900 dark:text-white font-bold mb-6">@trans('Platform')</h4>
                <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-500 transition-colors">@trans('Dashboard')</a></li>
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-500 transition-colors">@trans('Marketplace')</a></li>
                    <li><a href="{{ route('analytics') }}" class="hover:text-indigo-500 transition-colors">@trans('Analytics')</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-slate-900 dark:text-white font-bold mb-6">@trans('Support')</h4>
                <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="#" class="hover:text-indigo-500 transition-colors">@trans('Documentation')</a></li>
                    <li><a href="#" class="hover:text-indigo-500 transition-colors">@trans('Help Center')</a></li>
                    <li><a href="#" class="hover:text-indigo-500 transition-colors">@trans('Security')</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-slate-900 dark:text-white font-bold mb-6">@trans('Legal')</h4>
                <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="#" class="hover:text-indigo-500 transition-colors">@trans('Privacy Policy')</a></li>
                    <li><a href="#" class="hover:text-indigo-500 transition-colors">@trans('Terms of Service')</a></li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} @trans('EcoSphere Admin. All rights reserved.')</p>
            <div class="flex gap-6 text-slate-400">
                <a href="https://twitter.com/ecosphere" class="hover:text-indigo-500"><i class="fa-brands fa-twitter"></i></a>
                <a href="https://github.com/ecosphere" class="hover:text-indigo-500"><i class="fa-brands fa-github"></i></a>
                <a href="https://linkedin.com/company/ecosphere" class="hover:text-indigo-500"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>