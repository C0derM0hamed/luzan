@extends('layouts.admin')

@section('page-title', $pageTitle)

@section('content')
    <div class="max-w-2xl">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6 rounded-2xl border border-slate-100 bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-base font-bold text-slate-800">تحديث بيانات الحساب</h2>
                <p class="mt-1 text-xs text-slate-400">تحديث الاسم، البريد الإلكتروني، أو كلمة مرور لوحة التحكم الخاصة بك.</p>
            </div>

            @if ($errors->any())
                <div class="rounded-xl border border-red-100 bg-red-50 p-4 text-xs font-bold text-red-600">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-5">
                <div>
                    <label for="name" class="mb-2 block text-xs font-bold text-slate-700">الاسم</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                        placeholder="مدير النظام"
                        class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
                </div>

                <div>
                    <label for="email" class="mb-2 block text-xs font-bold text-slate-700">البريد الإلكتروني</label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                        placeholder="info@luzanmedical.com"
                        class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350" dir="ltr">
                </div>

                <div class="border-t border-slate-100 my-6 pt-5">
                    <h3 class="text-sm font-bold text-slate-700 mb-1">تغيير كلمة المرور (اختياري)</h3>
                    <p class="text-xs text-slate-400 mb-4">اترك حقول كلمة المرور الجديدة فارغة إذا كنت لا ترغب في تغييرها.</p>
                </div>

                <div>
                    <label for="password" class="mb-2 block text-xs font-bold text-slate-700">كلمة المرور الجديدة</label>
                    <input type="password" name="password" id="password"
                        placeholder="••••••••"
                        class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-xs font-bold text-slate-700">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="••••••••"
                        class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
                </div>

                <div class="border-t border-slate-100 my-6 pt-5">
                    <h3 class="text-sm font-bold text-slate-700 mb-1">تأكيد الأمان</h3>
                    <p class="text-xs text-slate-400 mb-4">لتحديث بريدك الإلكتروني أو كلمة المرور، يجب إدخال كلمة مرورك الحالية.</p>
                </div>

                <div>
                    <label for="current_password" class="mb-2 block text-xs font-bold text-slate-700">كلمة المرور الحالية</label>
                    <input type="password" name="current_password" id="current_password"
                        placeholder="••••••••"
                        class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
                </div>
            </div>

            <div class="flex justify-start border-t border-slate-100 pt-5">
                <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary px-6 text-sm font-bold text-white shadow-md shadow-primary/10 transition-all hover:bg-primary-dark hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>حفظ التعديلات</span>
                </button>
            </div>
        </form>
    </div>
@endsection
