@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">@trans('Add New Asset')</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">@trans('Deploy a new product to the EcoSphere marketplace.')</p>
        </div>
        <a href="{{ route('admin.products') }}" class="px-5 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold text-sm hover:bg-slate-200 transition-all">
            @trans('Back to List')
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white/40 dark:bg-slate-800/40 backdrop-blur-2xl rounded-[2.5rem] border border-white/20 dark:border-white/5 p-8 shadow-2xl shadow-indigo-500/10">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">@trans('Asset Name')</label>
                    <input type="text" name="name" required placeholder="e.g. Premium Silk" 
                           class="w-full bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl p-4 text-slate-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">@trans('Base Price')</label>
                        <input type="number" step="0.01" name="price" required 
                               class="w-full bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl p-4 text-slate-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">@trans('Initial Stock')</label>
                        <input type="number" name="stock" required 
                               class="w-full bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl p-4 text-slate-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">@trans('Market Elasticity')</label>
                    <div class="grid grid-cols-2 gap-2 p-1.5 bg-slate-100 dark:bg-slate-900/80 rounded-2xl border border-slate-200 dark:border-slate-800">
                        <label class="cursor-pointer">
                            <input type="radio" name="is_elastic" value="0" class="peer hidden" checked>
                            <div class="peer-checked:bg-white dark:peer-checked:bg-slate-700 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400 peer-checked:shadow-sm text-center py-2.5 rounded-xl text-xs font-bold text-slate-500 transition-all">
                               @trans('Necessity (Inelastic)')
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="is_elastic" value="1" class="peer hidden">
                            <div class="peer-checked:bg-white dark:peer-checked:bg-slate-700 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400 peer-checked:shadow-sm text-center py-2.5 rounded-xl text-xs font-bold text-slate-500 transition-all">
                                @trans('Luxury (Elastic)')
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">@trans('Asset Image URL')</label>
                    <input type="url" name="image" placeholder="https://..." 
                           class="w-full bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl p-4 text-slate-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">@trans('Description')</label>
                    <textarea name="description" rows="5" required 
                              class="w-full bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl p-4 text-slate-900 dark:text-white focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all resize-none"></textarea>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t border-slate-200 dark:border-slate-700/50 pt-8 flex justify-end">
            <button type="submit" class="group flex items-center gap-3 bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-indigo-600/20 transition-all active:scale-95">
                @trans('Initialize Asset')
                <i class="fa-solid fa-plus text-[10px] group-hover:rotate-90 transition-transform"></i>
            </button>
        </div>
    </form>
</div>
@endsection