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
                <h1 class="mt-4 text-lg font-bold text-slate-800">{{ $loginTitle }}</h1>
                <p class="mt-1.5 text-xs text-slate-400">سجل دخولك لإدارة محتوى ومواعيد المجمع الطبي</p>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-xl border border-green-100 bg-green-50 p-4 text-xs font-bold text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-100 bg-red-50 p-4 text-xs font-bold text-red-600">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-xs font-bold text-slate-700">{{ $emailLabel }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus 
                        placeholder="example@luzanmedical.com"
                        class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350" dir="ltr">
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-700">{{ $passwordLabel }}</label>
                        <a href="{{ route('admin.password.request') }}" class="text-xs font-bold text-primary hover:underline">نسيت كلمة المرور؟</a>
                    </div>
                    <input type="password" name="password" id="password" required 
                        placeholder="••••••••"
                        class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
                </div>
                
                <div class="flex items-center gap-2 py-1">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 rounded border-slate-300 text-primary focus:ring-primary transition-all">
                    <label for="remember" class="text-xs font-bold text-slate-650 cursor-pointer select-none">{{ $rememberLabel }}</label>
                </div>
                
                <button type="submit" class="inline-flex h-11 w-full items-center justify-center rounded-xl bg-primary font-bold text-white shadow-md shadow-primary/10 transition-all hover:bg-primary-dark hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
                    {{ $submitLabel }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>
