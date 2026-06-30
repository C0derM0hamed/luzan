@extends('layouts.app')

@section('title', 'التحقق من الهوية')

@section('content')
<div class="min-h-[70vh] bg-slate-50 py-20 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-slate-100 border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary to-primary-dark p-8 text-center text-white">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/10 backdrop-blur-sm mb-4">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h2 class="text-2xl font-bold">تأكيد الدخول</h2>
            <p class="text-primary-100 text-sm mt-2 opacity-90">تم إرسال رمز التحقق إلى {{ $email }}</p>
        </div>

        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 rounded-xl bg-emerald-50 p-4 border border-emerald-100 text-sm font-bold text-emerald-600 text-center">
                    {{ session('success') }}
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

            <form action="{{ route('reports.verify.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="code" class="mb-2 block text-sm font-bold text-slate-700 text-center">أدخل الرمز المكون من 6 أرقام</label>
                    <input type="text" name="code" id="code" required dir="ltr" maxlength="6" pattern="[0-9]{6}" autocomplete="one-time-code"
                        class="h-14 w-full rounded-2xl border border-slate-200 bg-slate-50/50 px-4 text-center text-2xl tracking-[0.5em] font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-300">
                </div>
                
                <button type="submit" class="flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-primary text-sm font-bold text-white shadow-md shadow-primary/20 transition-all hover:bg-primary-dark hover:scale-102 active:scale-95">
                    التحقق وعرض التقارير
                </button>
            </form>
            
            <div class="mt-6 text-center text-sm">
                <span class="text-slate-500">لم يصلك الرمز؟</span>
                <form action="{{ route('reports.send-otp') }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit" class="font-bold text-primary hover:text-primary-dark hover:underline">إرسال مجدداً</button>
                </form>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('reports.login') }}" class="text-xs text-slate-400 hover:text-slate-600 transition-colors">تغيير البريد الإلكتروني</a>
            </div>
        </div>
    </div>
</div>
@endsection
