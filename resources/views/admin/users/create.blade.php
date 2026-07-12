@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.users.index') }}"
                class="text-sm font-semibold text-slate-500 hover:text-primary transition">← العودة للقائمة</a>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST"
            class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm">
            @csrf
            <div class="space-y-6">
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-bold text-slate-700">الاسم بالكامل <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-primary focus:ring-primary/20"
                            required autofocus>
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-bold text-slate-700">البريد الإلكتروني <span
                                class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" dir="ltr"
                            class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-primary focus:ring-primary/20"
                            required>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="password" class="mb-2 block text-sm font-bold text-slate-700">كلمة المرور <span
                                class="text-rose-500">*</span></label>
                        <input type="password" name="password" id="password" dir="ltr"
                            class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-primary focus:ring-primary/20"
                            required>
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-bold text-slate-700">تأكيد كلمة
                            المرور <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" dir="ltr"
                            class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-primary focus:ring-primary/20"
                            required>
                    </div>
                </div>

                <div class="pt-4 pb-2 border-t border-slate-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_admin" id="is_admin" value="1"
                                class="peer h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary/30"
                                @checked(old('is_admin'))>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-800">صلاحية إدارة (مدير عام)</span>
                            <span class="block text-xs text-slate-500 mt-0.5">منح المستخدم صلاحيات كاملة لإدارة
                                الموقع.</span>
                        </div>
                    </label>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit"
                        class="rounded-xl bg-primary px-8 py-3.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-primary-dark active:scale-95">حفظ
                        وإضافة</button>
                    <a href="{{ route('admin.users.index') }}"
                        class="rounded-xl px-4 py-3.5 text-sm font-bold text-slate-600 hover:bg-slate-100 transition">إلغاء</a>
                </div>
            </div>
        </form>
    </div>
@endsection