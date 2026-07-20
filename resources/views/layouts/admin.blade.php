<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" 
      dir="{{ app()->getLocale() == 'ur' ? 'rtl' : 'ltr' }}"
      x-data="{ darkMode: localStorage.theme === 'dark', sidebarOpen: false }" 
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => { 
          document.documentElement.classList.toggle('dark', val);
          localStorage.theme = val ? 'dark' : 'light';
      })">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Theme init logic
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Tailwind Config
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: { premium: { 500: '#6366f1' } }
                }
            }
        }
    </script>
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>

<body class="h-screen bg-[#f8fafc] dark:bg-[#0f172a] text-slate-900 dark:text-slate-100">

    <div class="lg:hidden flex items-center justify-between p-4 bg-white/50 dark:bg-slate-900/50 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <h1 class="font-bold text-lg bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-transparent">@trans('ECOSPHERE')</h1>
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-500 dark:text-slate-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </div>

    <div class="flex h-full overflow-hidden">
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed lg:static inset-y-0 left-0 w-72 z-50 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 lg:translate-x-0 transition-transform duration-300 flex flex-col">
            
            <div class="p-8 flex justify-between items-center">
                <h1 class="text-2xl font-bold tracking-tighter bg-gradient-to-br from-indigo-500 to-purple-500 bg-clip-text text-transparent">@trans('ECOSPHERE')</h1>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-500">X</button>
            </div>
            
            <nav class="flex-1 px-4 space-y-2">
                <a href="/admin/dashboard" class="flex items-center px-4 py-3 text-sm font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-500/10 rounded-2xl">@trans('Dashboard')</a>
                <a href="/admin/products" class="flex items-center px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">@trans('Products')</a>
   
            </nav>

            <div class="p-6 border-t border-slate-200 dark:border-slate-800">
                <button @click="darkMode = !darkMode" class="w-full py-3 rounded-2xl bg-slate-100 dark:bg-slate-800 hover:shadow-lg transition-all text-xs font-bold uppercase tracking-widest">
                    @trans('Toggle Theme')
                </button>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto bg-gradient-to-br from-slate-50/50 to-white dark:from-[#0f172a] dark:to-[#1e293b]">
            <div class="max-w-6xl mx-auto p-6 lg:p-12">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>