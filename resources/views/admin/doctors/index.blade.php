@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500 font-medium">{{ $doctors->total() }} {{ $totalLabel }}</p>
        </div>
        <a href="{{ route('admin.doctors.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-primary/10 transition-all hover:bg-primary-dark hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
            <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span>{{ $createLabel }}</span>
        </a>
    </div>
    
    <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50/70 text-right border-b border-slate-100 text-slate-700">
                <tr>
                    @foreach($tableHeaders as $header)
                        <th class="px-6 py-4 font-semibold">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($doctors as $doctor)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            @if($doctor->photo)
                                <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->name }}" class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-slate-100">
                            @else
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $doctor->name }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $doctor->specialty }}</td>
                        <td class="px-6 py-4 text-slate-500 font-medium">{{ $doctor->sort_order }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold transition-all {{ $doctor->is_active ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $doctor->is_active ? 'bg-green-500' : 'bg-slate-400' }}"></span>
                                <span>{{ $doctor->is_active ? $activeLabel : $inactiveLabel }}</span>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-primary hover:border-slate-300">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>{{ $editLabel }}</span>
                                </a>
                                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="inline" onsubmit="return confirm('{{ $deleteConfirm }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-red-100 bg-red-50 px-3 py-2 text-xs font-bold text-red-600 shadow-sm transition hover:bg-red-100 hover:text-red-700">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
    <div class="mt-6">{{ $doctors->links() }}</div>
@endsection
