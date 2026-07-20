<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | EcoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <script>
        // LocalStorage se theme check karein
        if (localStorage.theme === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-[#0f172a] min-h-screen p-6 md:p-12 transition-colors duration-300">

    <div class="max-w-2xl mx-auto space-y-6">
        <a href="/" class="text-[10px] font-black text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 uppercase tracking-[0.2em] transition-all">
            &larr; @trans('Back to Dashboard')
        </a>

        <div class="bg-white/80 dark:bg-slate-800/40 backdrop-blur-3xl p-10 rounded-[2.5rem] border border-slate-200 dark:border-white/10 shadow-2xl space-y-10 transition-all">
            
            @if(session('status'))
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-xs font-bold text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf @method('PUT')
               <h2 class="text-indigo-400 text-xs font-black uppercase tracking-[0.2em]">@trans('Personal Information')</h2>
<div class="space-y-4">
    <div>
        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">@trans('Full Name')</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-100 dark:bg-slate-900/50 border border-slate-200 dark:border-white/5 rounded-2xl py-4 px-5 text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
    <div>
        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">@trans('Email Address')</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-slate-100 dark:bg-slate-900/50 border border-slate-200 dark:border-white/5 rounded-2xl py-4 px-5 text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500">
    </div>
</div>
<button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all">@trans('Update Profile')</button>
            </form>
<form action="{{ route('password.update') }}" method="POST" class="space-y-6">
    @csrf @method('PUT')
    
    <h2 class="text-rose-400 text-xs font-black uppercase tracking-[0.2em]">@trans('Security Settings')</h2>
    
    <div class="space-y-4">
     <div>
    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">@trans('Current Password')</label>
    <input type="password" name="current_password" required 
        class="w-full bg-slate-100 dark:bg-slate-900/50 border {{ $errors->has('current_password') ? 'border-rose-500' : 'border-slate-200 dark:border-white/5' }} rounded-2xl py-4 px-5 text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-rose-500 transition-all">
    
    @error('current_password')
        <p class="text-rose-500 text-xs font-bold mt-2">{{ $message }}</p>
    @enderror
</div>

        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">@trans('New Password')</label>
            <input type="password" name="password" required 
                class="w-full bg-slate-100 dark:bg-slate-900/50 border border-slate-200 dark:border-white/5 rounded-2xl py-4 px-5 text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-rose-500 transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">@trans('Confirm Password')</label>
            <input type="password" name="password_confirmation" required 
                class="w-full bg-slate-100 dark:bg-slate-900/50 border border-slate-200 dark:border-white/5 rounded-2xl py-4 px-5 text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-rose-500 transition-all">
        </div>
    </div>

    <button type="submit" 
        class="w-full py-4 bg-slate-900 dark:bg-slate-700 hover:bg-rose-600 text-white font-black rounded-2xl transition-all shadow-lg shadow-rose-500/10">
        @trans('Update Password')
    </button>
</form>
        </div>
    </div>
</body>
</html>