<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - @trans('EcoSphere')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Theme toggler check
        if (localStorage.theme === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>

    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300">

    <nav class="border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-[10px] font-black text-slate-400 hover:text-indigo-600 uppercase tracking-widest flex items-center gap-2">
                @trans('BACK TO MARKET')
            </a>
            <span class="text-[9px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-full">
                @trans('Live Simulation')
            </span>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto py-12 px-6">
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">
            
            <div class="bg-slate-100 dark:bg-slate-800 relative min-h-[400px]">
                <img src="{{ $product->image }}" class="w-full h-full object-cover">
            </div>

            <div class="p-10 flex flex-col justify-center">
                <div class="mb-6">
                    <h1 class="text-4xl font-black mb-2">{{ $product->name }}</h1>
                    <span class="inline-block px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $product->is_elastic ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' }}">
                        {{ $product->is_elastic ? 'Elastic Demand' : 'Inelastic Demand' }}
                    </span>
                </div>

                <div class="mb-8">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">(@trans('Current Valuation'))</p>
                    <p class="text-5xl font-black text-indigo-600 dark:text-indigo-400">${{ number_format($product->price, 2) }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-2xl">
                        <p class="text-[9px] font-black text-slate-400 uppercase">(@trans('Available'))</p>
                        <p class="text-lg font-bold">{{ $product->stock }} units</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-2xl">
                        <p class="text-[9px] font-black text-slate-400 uppercase">(@trans('Daily Views'))</p>
                        <p class="text-lg font-bold">{{ $product->views_today }}</p>
                    </div>
                </div>

                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-8">{{ $product->description }}</p>

                <div class="flex flex-col gap-3">
                    <form action="{{ route('products.purchase', $product->id) }}" method="POST">
                        @csrf
                        <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-500/20 transition-all">
                            @trans('SIMULATE PURCHASE')
                        </button>
                    </form>
                    
                    <form action="{{ route('products.simulate', $product->id) }}" method="POST">
                        @csrf
                        <button class="w-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 font-bold py-4 rounded-2xl transition-all">
                            @trans('Refresh Market Logic')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>