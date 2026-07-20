@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-xl font-bold text-xs hover:bg-slate-300 dark:hover:bg-slate-700 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>
    </div>
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/5 rounded-[2.5rem] p-10 shadow-2xl">
        
        <div class="flex justify-between items-start">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-3xl bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-4xl font-black text-white shadow-lg shadow-indigo-500/20">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 dark:text-white">{{ $user->name }}</h1>
                    <p class="text-indigo-500 font-bold">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-100 dark:border-white/5">
                <span class="block text-[10px] uppercase font-black text-slate-400">Account Type</span>
                <span class="text-slate-800 dark:text-white font-bold">
                    @if(isset($user->role) && $user->role == 'admin')
                        Admin
                    @elseif(isset($user->is_admin) && $user->is_admin)
                        Admin
                    @else
                        Registered User
                    @endif
                </span>
            </div>
            
            <div class="p-6 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-100 dark:border-white/5">
                <span class="block text-[10px] uppercase font-black text-slate-400">Member Since</span>
                <span class="text-slate-800 dark:text-white font-bold">{{ $user->created_at->format('M d, Y') }}</span>
            </div>

            <div class="p-6 bg-slate-50 dark:bg-slate-950 rounded-2xl border border-slate-100 dark:border-white/5">
                <span class="block text-[10px] uppercase font-black text-slate-400">Status</span>
                <span class="text-emerald-500 font-bold flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Active
                </span>
            </div>
        </div>

     <!-- Recent Activities Section -->
<div class="mt-10">
    <h3 class="text-lg font-black text-slate-800 dark:text-white mb-4">Recent Activity</h3>
    <div class="border border-slate-100 dark:border-white/5 rounded-2xl p-6 space-y-4">
        @forelse($user->activities as $activity)
            <div class="flex justify-between items-center text-sm border-b border-slate-100 dark:border-white/5 pb-3 last:border-0 last:pb-0">
                <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $activity->action }}</span>
                <span class="text-xs text-slate-400">
                    @if(is_string($activity->created_at))
                        {{ $activity->created_at }}
                    @else
                        {{ $activity->created_at->diffForHumans() }}
                    @endif
                </span>
            </div>
        @empty
            <p class="text-slate-500 text-sm italic">User has not performed any recent activities.</p>
        @endforelse
    </div>
</div>
    </div>
</div>
@endsection