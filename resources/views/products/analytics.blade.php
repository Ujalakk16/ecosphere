<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <script>
    const toggleBtn = document.getElementById('theme-toggle');
    const html = document.documentElement;

    // Check local storage for preference
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    // Toggle function
    toggleBtn.addEventListener('click', () => {
        html.classList.toggle('dark');
        localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
    });
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Analytics - EcoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    tailwind.config = {
        darkMode: 'class', // Iska hona zaroori hai
        theme: { extend: {} }
    }
</script>
</head>

<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 transition-colors duration-300 min-h-screen flex flex-col">

    <nav class="bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 p-2 rounded-xl text-white">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <span class="text-xl font-black tracking-widest text-slate-900 dark:text-white">(@trans('ECOSPHERE'))</span>
            </div>
            <div class="flex items-center gap-8 text-xs font-bold text-slate-500">
                <a href="{{ route('home') }}" class="hover:text-indigo-600">(@trans('MARKETPLACE'))</a>
                <a href="{{ route('analytics') }}" class="hover:text-indigo-600">(@trans('ANALYTICS'))</a>
            </div>
        </div>
    </nav>

    <div class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 py-12 px-6 text-center">
        <h1 class="text-3xl font-black text-slate-900 dark:text-white mb-2">
            <i class="fa-solid fa-chart-pie text-indigo-500 mr-2"></i>(@trans('Market Analytics'))
        </h1>
        <p class="text-sm text-slate-400">(@trans('Real-time economic metrics and resource indicators.'))</p>

        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            <div class="bg-slate-50 dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-700">
                <p class="text-[10px] font-black text-slate-400 uppercase">(@trans('Avg Price'))</p>
                <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">${{ number_format($products->avg('price'), 2) }}</p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-700">
                <p class="text-[10px] font-black text-slate-400 uppercase">(@trans('Total Views'))</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $products->sum('views_today') }}</p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-700">
                <p class="text-[10px] font-black text-slate-400 uppercase">(@trans('Total Inventory'))</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $products->sum('stock') }}</p>
            </div>
        </div>
    </div>

    <main class="flex-grow max-w-5xl mx-auto px-4 py-10 w-full">
       <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-x-auto">
        
            <table class="w-full min-w-[600px] text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <th class="py-5 px-6">(@trans('Product'))</th>
                        <th class="py-5 px-6 text-center">(@trans('Elasticity'))</th>
                        <th class="py-5 px-6 text-right">(@trans('Price'))</th>
                        <th class="py-5 px-6 text-center">(@trans('Views'))</th>
                        <th class="py-5 px-6 text-center">(@trans('Stock'))</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 text-sm font-medium">
                    @foreach($products as $product)
                    <tr class="hover:bg-indigo-50/50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-4 px-6 font-bold">{{ $product->name }}</td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400">
                                {{ $product->is_elastic ? 'ELASTIC' : 'INELASTIC' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right font-black">${{ number_format($product->price, 2) }}</td>
                        <td class="py-4 px-6 text-center text-slate-400">{{ $product->views_today }}</td>
                        <td class="py-4 px-6 text-center">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black {{ $product->stock < 20 ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 dark:bg-slate-700 text-slate-600' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-black">
    ${{ number_format($product->price, 2) }}
    
    @if($product->price_trend == 'up')
        <span class="text-emerald-500 text-[10px] ml-1">▲</span>
    @else
        <span class="text-rose-500 text-[10px] ml-1">▼</span>
    @endif
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
<footer class="py-6 text-center text-xs font-medium text-slate-400 dark:text-slate-600 mt-auto">
        &copy; 2026 EcoSphere Simulator Project.
    </footer>
</html>