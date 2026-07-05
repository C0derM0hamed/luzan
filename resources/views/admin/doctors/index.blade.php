@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
        <div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-wider">{{ $doctors->total() }} {{ $totalLabel }}</p>
        </div>
        <a href="{{ route('admin.doctors.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-6 py-3 text-xs font-black text-white shadow-xl shadow-slate-950/10 transition-all hover:bg-primary hover:shadow-primary/20 hover:scale-101 active:scale-99">
            <svg class="h-4.5 w-4.5 text-primary-light" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $createLabel }}</span>
        </a>
    </div>
    
    <div class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm">
        <div class="overflow-x-auto scrollbar-hide">
            <table class="min-w-full text-xs text-right">
                <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-500">
                    <tr>
                        @foreach($tableHeaders as $header)
                            <th class="px-6 py-4.5 font-black uppercase tracking-wider">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($doctors as $doctor)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <!-- Photo -->
                            <td class="px-6 py-4">
                                @if($doctor->photo)
                                    <div class="h-11 w-11 rounded-full border-2 border-white shadow-md overflow-hidden ring-1 ring-slate-200/50">
                                        <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->name }}" class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-slate-50 text-slate-400 border border-slate-150">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            
                            <!-- Name -->
                            <td class="px-6 py-4 font-black text-slate-900">{{ $doctor->name }}</td>
                            
                            <!-- Specialty -->
                            <td class="px-6 py-4 text-slate-650 font-bold">
                                <span class="inline-flex items-center gap-1.5 rounded-xl px-2.5 py-1 text-[10px] font-black text-primary bg-primary/10">
                                    {{ $doctor->specialty }}
                                </span>
                            </td>
                            
                            <!-- Sort Order -->
                            <td class="px-6 py-4 text-slate-500 font-extrabold">{{ $doctor->sort_order }}</td>
                            
                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-xl px-3 py-1.5 text-[10px] font-black transition-all border {{ 
                                    $doctor->is_active ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-500' 
                                }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $doctor->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    <span>{{ $doctor->is_active ? $activeLabel : $inactiveLabel }}</span>
                                </span>
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-[10px] font-black text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-primary hover:border-slate-350 active:scale-95">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ $editLabel }}</span>
                                    </a>
                                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="inline" onsubmit="return confirm('{{ $deleteConfirm }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-[10px] font-black text-rose-600 shadow-sm transition hover:bg-rose-100 hover:border-rose-350 active:scale-95">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>{{ $deleteLabel }}</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6 flex justify-center">{{ $doctors->links() }}</div>
@endsection
