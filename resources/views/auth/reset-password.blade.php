<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password | EcoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-[#0f172a] min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <form action="{{ route('password.update') }}" method="POST" 
              class="bg-white/5 dark:bg-slate-800/50 backdrop-blur-3xl p-8 rounded-[2rem] border border-white/10 shadow-2xl space-y-6"
              x-data="{ loading: false }" @submit="loading = true">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">
            
            <div class="text-center space-y-1">
                <h2 class="text-white text-3xl font-black tracking-tight">@trans('Set New Password')</h2>
                <p class="text-slate-400 text-sm">@trans('Enter your new secure password')</p>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">@trans('New Password')</label>
                <input type="password" name="password" required 
                       class="w-full bg-slate-900/50 border border-white/5 rounded-2xl py-4 px-5 text-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">@trans('Confirm Password')</label>
                <input type="password" name="password_confirmation" required 
                       class="w-full bg-slate-900/50 border border-white/5 rounded-2xl py-4 px-5 text-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2"
                    :disabled="loading">
                <span x-show="!loading">@trans('Update Password')</span>
                <span x-show="loading" class="animate-pulse">@trans('Updating...')</span>
            </button>
        </form>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>