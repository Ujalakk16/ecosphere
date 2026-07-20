<!DOCTYPE html>
<!-- <html lang="en" class="scroll-smooth"> -->
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}">
<head>
    <script>
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
</script>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoSphere | Market Simulator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
    [x-cloak] { display: none !important; }
</style>
<style>
    [dir="rtl"] {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Ya jo bhi aapko Urdu ke liye pasand ho */
    }
</style>



<style>
    /* Pagination buttons ko customize karne ke liye */
    .pagination-wrapper nav {
        display: flex;
        gap: 0.5rem;
    }
    .pagination-wrapper span, .pagination-wrapper a {
        background: #1e293b !important; /* Slate 800 */
        color: #94a3b8 !important;      /* Slate 400 */
        border: 1px solid #334155 !important;
        border-radius: 0.75rem !important;
        padding: 0.5rem 1rem !important;
    }
    .pagination-wrapper a:hover {
        background: #4f46e5 !important; /* Indigo 600 */
        color: white !important;
    }
    .pagination-wrapper .bg-white {
        background: #4f46e5 !important; /* Current Page Active */
        color: white !important;
    }
</style>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
</style>


</head>

<body class="bg-[#eef2f6] dark:bg-slate-900 text-slate-800 dark:text-slate-200 transition-colors duration-300" 
      x-data="{ darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }">


<nav x-data="{ open: false, userMenu: false, langMenu: false, darkMode: false }" 
     class="bg-slate-950/90 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
     
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between gap-6">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-chart-line text-white text-sm"></i>
            </div>
            <span class="text-sm font-bold text-white tracking-[0.2em] uppercase hidden sm:block">@trans('Ecosphere')</span>
        </div>

        <div class="hidden md:flex flex-1 justify-center max-w-md">
            <form action="{{ route('home') }}" method="GET" class="w-full">
                <input type="text" name="search" placeholder="Search..." class="w-full bg-white/5 border border-white/10 text-white rounded-full py-1.5 px-4 text-[10px] outline-none focus:border-indigo-500 transition">
            </form>
        </div>

        <div class="hidden md:flex items-center gap-6">
            <a href="{{ route('analytics') }}" class="text-[10px] font-semibold text-slate-400 hover:text-indigo-400 uppercase transition">@trans('Analytics')</a>
            
            <div class="relative">
                <button type="button" @click="langMenu = !langMenu" class="text-[10px] text-slate-400 uppercase hover:text-white transition flex items-center gap-1">
                    {{ strtoupper(app()->getLocale()) }} <i class="fa-solid fa-chevron-down text-[8px]"></i>
                </button>
                <div x-show="langMenu" x-cloak @click.away="langMenu = false" class="absolute right-0 top-full mt-2 w-24 bg-slate-900 border border-white/10 rounded-lg shadow-xl py-2 z-50">
                    <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-1 text-[10px] text-white hover:bg-white/10">@trans('English')</a>
                    <a href="{{ route('lang.switch', 'ur') }}" class="block px-4 py-1 text-[10px] text-white hover:bg-white/10">@trans('Urdu')</a>
                    <a href="{{ route('lang.switch', 'zh') }}" class="block px-4 py-1 text-[10px] text-white hover:bg-white/10">@trans('Chinese')</a>
                </div>
            </div>
<button type="button" 
    @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark', darkMode); localStorage.theme = darkMode ? 'dark' : 'light'" 
    class="text-slate-400 hover:text-white">
    
    <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
</button>
            <a href="{{ route('cart.products') }}" class="relative text-slate-400 hover:text-white">
                <i class="fa-solid fa-basket-shopping"></i>
                @php $cartCount = session()->has('cart') ? count(session()->get('cart')) : 0; @endphp
                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-indigo-600 text-white text-[8px] font-bold w-4 h-4 flex items-center justify-center rounded-full">{{ $cartCount }}</span>
                @endif
            </a>

          @auth
    <!-- Profile Button (Jo aapke paas pehle se hai) -->
    <div class="relative">
        <button type="button" @click="userMenu = !userMenu" class="text-[10px] text-white">
            {{ auth()->user()->name }}
        </button>

        <!-- Profile Dropdown (Yeh naya code hai) -->
        <div x-show="userMenu" 
             x-cloak 
             @click.away="userMenu = false" 
             class="absolute right-0 mt-2 w-48 bg-slate-900 border border-white/10 rounded-lg shadow-xl py-2 z-50">
            
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-xs text-white hover:bg-white/10">@trans('Profile')</a>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-xs text-rose-400 hover:bg-white/10">
                    @trans('Logout')
                </button>
            </form>
        </div>
    </div>

    @else
    <a href="{{ route('login') }}" class="text-[10px] text-white uppercase hover:text-indigo-400 transition">@trans('Login')</a>
    <a href="{{ route('register') }}" class="text-[10px] text-white uppercase bg-indigo-600 px-3 py-1 rounded-full hover:bg-indigo-700 transition">@trans('Register')</a>
@endauth

</div>

        <button type="button" @click="open = !open" class="md:hidden text-white p-2">
            <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
        </button>
    </div>

   <div x-show="open" x-cloak @click.away="open = false" 
     class="md:hidden bg-slate-900 border-t border-white/10 p-6 space-y-8">
    
    <div class="border-b border-white/10 pb-6">
        <div class="mb-6">
    <form action="{{ route('home') }}" method="GET" class="relative">
        <input type="text" 
               name="search" 
               placeholder="Search products..." 
               value="{{ request('search') }}"
               class="w-full bg-slate-800 border border-white/10 text-white rounded-xl py-3 pl-10 pr-4 text-sm focus:outline-none focus:border-indigo-500 transition">
        
        <i class="fa-solid fa-search absolute left-3 top-3.5 text-slate-500 text-sm"></i>
    </form>
</div>
        @auth
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-white font-bold">{{ auth()->user()->name }}</p>
                    <a href="{{ route('profile.edit') }}" class="text-[10px] text-indigo-400">@trans('View Profile')</a>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="text-rose-400 text-xs font-bold">@trans('Sign Out')</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block w-full text-center bg-indigo-600 text-white py-2 rounded-lg text-xs font-bold">@trans('Login')</a>
            <a href="{{ route('register') }}" class="block w-full text-center bg-slate-800 text-white py-2 rounded-lg text-xs font-bold mt-2">@trans('Register')</a>
        @endauth
    </div>

    <div class="space-y-4">
        <a href="{{ route('analytics') }}" class="flex items-center gap-3 text-slate-300 text-sm hover:text-white">
            <i class="fa-solid fa-chart-line"></i> @trans('Analytics')
        </a>
        <a href="{{ route('cart.products') }}" class="flex items-center gap-3 text-slate-300 text-sm hover:text-white">
            <i class="fa-solid fa-basket-shopping"></i> @trans('Cart') ({{ $cartCount ?? 0 }})
        </a>
    </div>

    <div class="pt-4 border-t border-white/10 flex justify-between items-center">
       <button type="button" 
    @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark', darkMode); localStorage.theme = darkMode ? 'dark' : 'light'" 
    class="text-slate-400 hover:text-white">
    
    <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
</button>
        
        <div class="flex gap-2">
            <a href="{{ route('lang.switch', 'en') }}" class="text-[10px] text-white px-2 py-1 bg-white/10 rounded">@trans('EN')</a>
            <a href="{{ route('lang.switch', 'ur') }}" class="text-[10px] text-white px-2 py-1 bg-white/10 rounded">@trans('UR')</a>
            <a href="{{ route('lang.switch', 'zh') }}" class="text-[10px] text-white px-2 py-1 bg-white/10 rounded">@trans('ZH')</a> 
        </div>
    </div>
</div>
</nav>

<div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-12 gap-8">
<aside class="col-span-12 lg:col-span-3">
    <div class="bg-white/40 dark:bg-slate-800/40 backdrop-blur-2xl rounded-3xl border border-white/20 dark:border-white/5 p-6 shadow-xl shadow-indigo-500/5 sticky top-24">
        
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">@trans('Market Filters')</h3>
            @if(request()->has('filter'))
                <a href="{{ route('home') }}" class="text-[9px] font-bold text-rose-500 hover:text-rose-600 uppercase transition-colors">(@trans('Clear'))</a>
            @endif
        </div>
        
        <div class="space-y-2">
            <a href="{{ route('home') }}" 
               class="group flex items-center justify-between p-3 rounded-2xl transition-all duration-300 {{ !request()->has('filter') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-white/60 dark:hover:bg-slate-700/50' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-border-all text-xs {{ !request()->has('filter') ? 'text-white' : 'text-indigo-400 group-hover:text-indigo-600' }}"></i>
                    <span class="text-sm font-bold">@trans('Show All')</span>
                </div>
            </a>

            <a href="{{ route('home', ['filter' => 'inelastic']) }}" 
               class="group flex items-center justify-between p-3 rounded-2xl transition-all duration-300 {{ request('filter') == 'inelastic' ? 'bg-indigo-50 dark:bg-indigo-900/30' : 'hover:bg-white/60 dark:hover:bg-slate-700/50' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-leaf text-xs {{ request('filter') == 'inelastic' ? 'text-indigo-500' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
                    <span class="text-sm font-bold {{ request('filter') == 'inelastic' ? 'text-indigo-700 dark:text-indigo-300' : 'text-slate-600 dark:text-slate-400' }}">@trans('Necessities')</span>
                </div>
                <span class="text-[10px] font-black px-2.5 py-0.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300">{{ $inelasticCount }}</span>
            </a>

            <a href="{{ route('home', ['filter' => 'elastic']) }}" 
               class="group flex items-center justify-between p-3 rounded-2xl transition-all duration-300 {{ request('filter') == 'elastic' ? 'bg-indigo-50 dark:bg-indigo-900/30' : 'hover:bg-white/60 dark:hover:bg-slate-700/50' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-gem text-xs {{ request('filter') == 'elastic' ? 'text-indigo-500' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
                    <span class="text-sm font-bold {{ request('filter') == 'elastic' ? 'text-indigo-700 dark:text-indigo-300' : 'text-slate-600 dark:text-slate-400' }}">@trans('Luxuries')</span>
                </div>
                <span class="text-[10px] font-black px-2.5 py-0.5 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300">{{ $elasticCount }}</span>
            </a>
        </div>
        <div class="mt-8">
    <div class="p-4 bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl mb-4 transition-colors">
        <h4 class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3">
            @trans('Market Sentiment')
        </h4>
        <div class="flex items-center gap-3">
            <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></div>
            <span class="text-slate-900 dark:text-white font-bold text-sm">@trans('Bullish Trend')</span>
        </div>
        <p class="text-[10px] text-slate-600 dark:text-slate-500 mt-2 leading-relaxed">
            @trans('Prices trending upwards by 2.4% in last 24h.')
        </p>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div class="bg-white dark:bg-slate-800/50 p-3 rounded-xl border border-slate-200 dark:border-slate-700/50 transition-colors">
            <p class="text-[9px] text-slate-500 dark:text-slate-400">@trans('Total Products')</p>
            <p class="text-slate-900 dark:text-white font-bold text-sm">{{ $totalCount }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800/50 p-3 rounded-xl border border-slate-200 dark:border-slate-700/50 transition-colors">
            <p class="text-[9px] text-slate-500 dark:text-slate-400">@trans('Users')</p>
            <p class="text-slate-900 dark:text-white font-bold text-sm">{{ $userCount }}</p>
        </div>
    </div>
    @auth
    @if(auth()->user()->isAdmin()) <div class="mt-6 border-t border-slate-200 dark:border-slate-700 pt-6">
            <a href="{{ route('admin.products') }}" 
               class="flex items-center justify-center gap-2 w-full p-3 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-amber-500/20">
               <i class="fa-solid fa-lock text-xs"></i>
               @trans('Admin Dashboard')
            </a>
        </div>
    @endif
@endauth
</div>
    </div>
</aside>
<main class="col-span-12 lg:col-span-9">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        @foreach($products as $product)
        <div class="group relative bg-white dark:bg-slate-800/60 rounded-3xl border border-slate-200 dark:border-slate-700 p-3 transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-500/10 hover:border-indigo-500/30">
            
            <div class="relative h-60 w-full overflow-hidden rounded-2xl cursor-pointer" >
               <a href="{{ route('products.show', $product->id) }}" class="block">
    <div class="group relative bg-white dark:bg-slate-800/60 rounded-3xl border ...">
        <div class="relative h-60 w-full overflow-hidden rounded-2xl">
            <img src="{{ $product->image }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </div>
        </div>
</a>
                
                <div class="absolute top-4 left-4 z-10">
                    <span class="flex items-center gap-1.5 px-3 py-1 bg-white/90 dark:bg-slate-900/90 backdrop-blur text-[9px] font-black tracking-widest uppercase rounded-lg shadow-sm border border-slate-100 dark:border-slate-700 text-slate-900 dark:text-white">
                        <span class="w-1.5 h-1.5 rounded-full {{ $product->is_elastic ? 'bg-indigo-500' : 'bg-amber-500' }}"></span>
                        @if($product->is_elastic)
    {{ __('Elastic') }}
@else
    {{ __('Inelastic') }}
@endif
                    </span>
                </div>
            </div>

            <div class="p-4 pt-6">
                <div class="mb-4">
                    <div class="flex items-center gap-2 mb-3">
    <span class="px-2 py-1 rounded-md text-[10px] font-black uppercase tracking-widest 
        {{ $product->is_elastic ? 'bg-indigo-50 text-indigo-600' : 'bg-amber-50 text-amber-600' }}">
        
        <i class="{{ $product->is_elastic ? 'fa-solid fa-gem' : 'fa-solid fa-leaf' }} mr-1"></i>
        {{ $product->is_elastic ? __('Luxury') : __('Essential') }}
    </span>
</div>
                    <h3 class="text-lg font-extrabold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $product->name }}
                    </h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 line-clamp-2">
                        {{ $product->description ?? 'Premium quality resource available for market simulation.' }}
                    </p>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase font-bold text-slate-400">@trans('Current Rate')</span>
                        <span class="text-xl font-black text-slate-900 dark:text-white">
                            ${{ number_format($product->price, 2) }}
                        </span>
                    </div>
                    
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="h-10 w-10 flex items-center justify-center bg-slate-900 dark:bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-900/20 hover:scale-105 active:scale-95 transition-all">
                            <i class="fa-solid fa-plus text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @endforeach
 
    </div>
                  <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
</div>
</main>
<div x-show="detailOpen" class="fixed inset-0 bg-slate-900/50 z-50 flex items-center justify-center p-4" x-cloak>
    <div @click.away="detailOpen = false" class="bg-white dark:bg-slate-800 p-8 rounded-3xl max-w-sm w-full">
        <h2 class="text-2xl font-black text-slate-900 dark:text-white" x-text="activeProduct.name"></h2>
        <p class="text-slate-500 mt-2" x-text="activeProduct.description"></p>
        <span class="text-3xl font-black text-emerald-600" x-text="activeProduct.price"></span>
        <button @click="detailOpen = false" class="mt-6 w-full py-3 bg-slate-900 text-white rounded-xl font-bold">@trans('Close')</button>
    </div>
</div>
    </div>
 
</body>
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
</html>