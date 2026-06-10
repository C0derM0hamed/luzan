<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-50 font-sans antialiased">
    <div class="w-full max-w-md p-6">
        <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-lg shadow-slate-100/50">
            <div class="mb-8 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="{{ $clinicName }}" class="mx-auto h-16 w-auto">
                <h1 class="mt-4 text-lg font-bold text-slate-800">{{ $resetTitle }}</h1>
                <p class="mt-1.5 text-xs text-slate-400">أدخل بريدك الإلكتروني أو رقم جوالك لاستلام كلمة مرور جديدة</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-100 bg-red-50 p-4 text-xs font-bold text-red-600">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="identity" class="mb-2 block text-xs font-bold text-slate-700">{{ $identityLabel }}</label>
                    <input type="text" name="identity" id="identity" value="{{ old('identity') }}" required autofocus 
                        placeholder="example@luzanmedical.com أو 0177221892" 
                        class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350" dir="ltr">
                </div>
                
                <button type="submit" class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-primary font-bold text-white shadow-md shadow-primary/10 transition-all hover:bg-primary-dark hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
                    {{ $submitLabel }}
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1 text-xs font-bold text-primary hover:underline">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                    <span>{{ $backToLoginLabel }}</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
