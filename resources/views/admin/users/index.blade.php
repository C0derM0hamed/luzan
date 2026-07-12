@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">إدارة المدراء والمستخدمين</h2>
                <p class="mt-1 text-sm text-slate-500">إضافة وتعديل وحذف مدراء ومستخدمي لوحة التحكم.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-primary-dark active:scale-95">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                إضافة مستخدم جديد
            </a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">
                        <tr>
                            <th class="px-6 py-4 font-bold">الاسم</th>
                            <th class="px-6 py-4 font-bold">البريد الإلكتروني</th>
                            <th class="px-6 py-4 font-bold text-center">الصلاحية</th>
                            <th class="px-6 py-4 font-bold text-center">تاريخ الإضافة</th>
                            <th class="px-6 py-4 font-bold text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="transition-colors hover:bg-slate-50/50">
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span
                                            class="mr-2 inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">أنت</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600" dir="ltr">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($user->is_admin)
                                        <span
                                            class="inline-flex items-center rounded-md bg-primary/10 px-2.5 py-1 text-xs font-bold text-primary">مدير
                                            عام</span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-md bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600">مستخدم
                                            عادي</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-slate-500 text-xs">
                                    {{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="text-slate-400 hover:text-primary transition-colors" title="تعديل">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا الحساب؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors"
                                                    title="حذف">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" class="text-slate-300 cursor-not-allowed"
                                                title="لا يمكن حذف حسابك">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">لا يوجد مستخدمون حتى الآن.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="border-t border-slate-100 p-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection