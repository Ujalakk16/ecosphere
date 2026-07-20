@extends('layouts.admin')
@section('content')

<div class="p-8 bg-white dark:bg-slate-900/50 rounded-[2.5rem] border border-slate-200 dark:border-white/5 shadow-xl dark:shadow-2xl transition-colors">
    
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight">@trans('Registered Users')</h1>
        <span class="px-4 py-1.5 bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-full text-xs font-bold border border-indigo-500/20">
            {{ $users->count() }} Total Members
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-500 font-black border-b border-slate-200 dark:border-white/5">
                    <th class="pb-4 pl-4">@trans('User')</th>
                    <th class="pb-4">@trans('Email')</th>
                    <th class="pb-4">@trans('Joined')</th>
                    <th class="pb-4 text-right pr-4">@trans('Action')</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach($users as $user)
                <tr class="group border-b border-slate-100 dark:border-white/5 hover:bg-slate-50 dark:hover:bg-white/5 transition-all">
                    <td class="py-5 pl-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/20">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="font-bold text-slate-700 dark:text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="py-5 text-slate-500 dark:text-slate-400">{{ $user->email }}</td>
                    <td class="py-5 text-slate-500 dark:text-slate-400">{{ $user->created_at->diffForHumans() }}</td>
                    <td class="py-5 text-right pr-4">
                       <button><a href="{{ route('admin.user-profile', $user->id) }}" 
   class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all">
    @trans('View Profile')
</a>
</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection