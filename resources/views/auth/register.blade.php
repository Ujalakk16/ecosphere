<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | EcoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
</head>
<body class="bg-[#0f172a] min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md">
        <form action="{{ route('register') }}" method="POST" 
              class="bg-white/5 dark:bg-slate-800/50 backdrop-blur-3xl p-8 rounded-[2rem] border border-white/10 shadow-2xl space-y-5"
              x-data="{ loading: false }" @submit="loading = true">
            @csrf
            
            <div class="text-center mb-6">
                <h2 class="text-white text-2xl font-black uppercase tracking-widest">Register</h2>
                <p class="text-slate-400 text-xs mt-1">Join the EcoSphere ecosystem</p>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       class="w-full bg-slate-900/50 border {{ $errors->has('name') ? 'border-rose-500' : 'border-white/5' }} rounded-2xl py-4 px-5 text-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                @error('name') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="w-full bg-slate-900/50 border {{ $errors->has('email') ? 'border-rose-500' : 'border-white/5' }} rounded-2xl py-4 px-5 text-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                @error('email') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Password</label>
                <input type="password" name="password" required 
                       class="w-full bg-slate-900/50 border border-white/5 rounded-2xl py-4 px-5 text-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" required 
                       class="w-full bg-slate-900/50 border border-white/5 rounded-2xl py-4 px-5 text-white focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
            </div>

            <button type="submit" 
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2 mt-6"
                    :disabled="loading">
                <span x-show="!loading">Create Account</span>
                <span x-show="loading" class="animate-pulse">Processing...</span>
            </button>

            <!-- Divider -->
            <div class="flex items-center my-4">
                <div class="flex-grow border-t border-white/10"></div>
                <span class="px-3 text-[10px] uppercase font-bold tracking-widest text-slate-500">Or continue with</span>
                <div class="flex-grow border-t border-white/10"></div>
            </div>

            <!-- Social Login Buttons -->
            <div class="grid grid-cols-2 gap-3">
                <!-- Google Button -->
                <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-2 py-3 px-4 bg-slate-900/50 hover:bg-slate-900 border border-white/10 rounded-2xl text-white text-xs font-bold transition-all">
                    <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/><path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.13 0-5.78-2.11-6.73-4.96H1.19v3.15C3.21 21.39 7.28 24 12 24z"/><path fill="#FBBC05" d="M5.27 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.61H1.19C.43 8.14 0 9.99 0 12s.43 3.86 1.19 5.39l4.08-3.15z"/><path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.28 0 3.21 2.61 1.19 6.61l4.08 3.15c.95-2.85 3.6-4.96 6.73-4.96z"/></svg>
                    Google
                </a>

                <!-- Facebook Button -->
                <a href="{{ route('auth.facebook') }}" class="flex items-center justify-center gap-2 py-3 px-4 bg-[#1877F2]/10 hover:bg-[#1877F2]/20 border border-[#1877F2]/30 rounded-2xl text-white text-xs font-bold transition-all">
                    <svg class="w-4 h-4 fill-[#1877F2]" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </a>
            </div>
        </form>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>