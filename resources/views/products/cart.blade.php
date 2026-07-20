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
    <title>Shopping Cart - EcoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script> tailwind.config = { darkMode: 'class' } </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style> [x-cloak] { display: none !important; } </style>
<script>
    tailwind.config = {
        darkMode: 'class', // Iska hona zaroori hai
        theme: { extend: {} }
    }
</script>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 transition-colors duration-300" x-data="{ activeProductId: null }">

    <nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-black text-indigo-600 dark:text-indigo-400 flex items-center gap-2">
                <i class="fa-solid fa-chart-line"></i> @trans('ECOSPHERE')
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-indigo-600 transition-colors">@trans('Back to Market')</a>
                <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 bg-slate-100 dark:bg-slate-800 rounded-full">
                    <i class="fa-solid fa-moon text-indigo-400"></i>
                </button>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-black text-slate-900 dark:text-white mb-10 flex items-center gap-3">
            <i class="fa-solid fa-basket-shopping text-indigo-600"></i> @trans('Shopping Cart')
        </h1>

        @php $cart = session('cart', []); @endphp
        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        
                        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 flex items-center gap-6 shadow-sm hover:border-indigo-500/30 transition-all cursor-pointer"
                             @click="activeProductId = {{ $id }}">
                            
                            <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-2xl overflow-hidden">
                                <img src="{{ $details['image'] }}" class="w-full h-full object-cover">
                            </div>

                            <div class="flex-grow">
                                <h3 class="font-bold text-lg">{{ $details['name'] }}</h3>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Qty: {{ $details['quantity'] }}</p>
                            </div>

                            <div class="text-right">
                                <span class="text-xl font-black text-indigo-600 dark:text-indigo-400">${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </div>

                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-300 hover:text-rose-500 transition-colors">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="bg-indigo-600 text-white rounded-3xl p-8 shadow-2xl shadow-indigo-500/20 h-fit sticky top-24">
                    <h2 class="text-lg font-black uppercase tracking-widest mb-6">@trans('Order Summary')</h2>
                    
                    <div class="flex justify-between items-center mb-8 border-b border-indigo-500 pb-6">
                        <span class="text-indigo-100">@trans('Total Price')</span>
                        <span class="text-4xl font-black">${{ number_format($total, 2) }}</span>
                    </div>

                   <form action="{{ route('checkout') }}" method="POST">
    @csrf
    <button type="submit" class="w-full bg-white text-indigo-600 font-black py-4 rounded-xl shadow-lg hover:bg-slate-50 transition-all mb-4 uppercase text-xs tracking-widest">
        @trans('Proceed to Checkout')
    </button>
</form>
                    
                    <p class="text-[10px] text-indigo-200 text-center leading-relaxed">
                        *Dynamic pricing enabled for market equilibrium.
                    </p>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-20 text-center">
                <i class="fa-solid fa-basket-shopping text-5xl text-slate-200 dark:text-slate-700 mb-6"></i>
                <h3 class="text-xl font-black mb-2">@trans('Cart is empty')</h3>
                <a href="{{ route('home') }}" class="text-indigo-600 font-bold underline">@trans('Explore Marketplace')</a>
            </div>
        @endif
    </main>
</body>
</html>