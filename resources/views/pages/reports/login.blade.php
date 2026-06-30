@extends('layouts.app')

@section('title', 'بوابة المرضى - تسجيل الدخول')

@section('content')
<div class="min-h-[70vh] bg-slate-50 py-20 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-slate-100 border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary to-primary-dark p-8 text-center text-white">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/10 backdrop-blur-sm mb-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h2 class="text-2xl font-bold">بوابة تقارير المرضى</h2>
            <p class="text-primary-100 text-sm mt-2 opacity-90">أدخل بريدك الإلكتروني للوصول إلى تقاريرك الطبية</p>
        </div>

        <div class="p-8">
            @if(session('error'))
                <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-100 text-sm font-bold text-red-600">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-100 text-sm font-bold text-red-600">
                    <ul class="list-disc pr-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reports.send-otp') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-bold text-slate-700">البريد الإلكتروني المسجل لدينا</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required dir="ltr" placeholder="example@domain.com"
                        class="h-12 w-full rounded-xl border border-slate-200 bg-slate-50/50 px-4 text-sm outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-300 text-left">
                </div>
                
                <button type="submit" class="flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-primary text-sm font-bold text-white shadow-md shadow-primary/20 transition-all hover:bg-primary-dark hover:scale-102 active:scale-95">
                    إرسال رمز التحقق
                    <svg class="h-4 w-4 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
