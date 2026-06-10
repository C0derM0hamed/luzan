<div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-100/70">
    <!-- Form Header -->
    <div class="bg-gradient-to-r from-primary to-primary-dark p-8 text-right text-white relative overflow-hidden">
        <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-white/5"></div>
        <div class="absolute right-1/3 bottom-0 h-24 w-24 rounded-full bg-white/5"></div>
        
        <div class="relative z-10 flex items-center gap-4">
            <div class="rounded-2xl bg-white/10 p-3 backdrop-blur-md">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75M9 11h.008v.008H9V11zm.008 2.25H9v.008h.008v-.008zm0 2.25H9v.008h.008v-.008zM12 11h.008v.008H12V11zm.008 2.25H12v.008h.008v-.008zm0 2.25H12v.008h.008v-.008zm3.377-4.5h.008v.008h-.008V11zm.008 2.25h-.008v.008h.008v-.008zm0 2.25h-.008v.008h.008v-.008z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold">{{ $bookingFormTitle }}</h2>
                <p class="mt-1 text-sm text-slate-100 font-medium opacity-90">{{ $bookingFormSubtitle }}</p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl bg-emerald-50 p-4 border border-emerald-100 text-sm text-emerald-800" dir="rtl">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-bold leading-relaxed">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Alert -->
        @if($errors->any())
            <div class="mb-6 flex items-start gap-3 rounded-2xl bg-rose-50 p-4 border border-rose-100 text-sm text-rose-800" dir="rtl">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                <div class="flex-1">
                    <span class="font-bold block mb-1">يرجى تصحيح الأخطاء التالية:</span>
                    <ul class="list-disc pr-4 space-y-1 font-semibold text-rose-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Booking Form -->
        <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6" x-data="{ bookingType: '{{ old('booking_type', 'doctor') }}' }">
            @csrf

            <!-- Name Input -->
            <div class="relative">
                <label for="full_name" class="mb-2 block text-xs font-bold text-slate-700">الاسم الكامل</label>
                <div class="relative">
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" placeholder="أدخل اسمك ثلاثياً" required
                        class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/50 pr-11 pl-4 text-sm outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-300">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Grid: ID & Mobile -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- National ID -->
                <div class="relative">
                    <label for="national_id" class="mb-2 block text-xs font-bold text-slate-700">رقم الهوية أو الإقامة</label>
                    <div class="relative">
                        <input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}" placeholder="1XXXXXXXXX" required
                            class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/50 pr-11 pl-4 text-sm outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-300" dir="ltr">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm-1.2 6.4a2.25 2.25 0 00-1.35 0 2.25 2.25 0 00-1.2 1.35v.075h3.75v-.075a2.25 2.25 0 00-1.2-1.35z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Mobile Phone -->
                <div class="relative">
                    <label for="mobile" class="mb-2 block text-xs font-bold text-slate-700">رقم الجوال</label>
                    <div class="relative">
                        <input type="tel" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="05XXXXXXXX" required
                            class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/50 pr-11 pl-4 text-sm outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-300" dir="ltr">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Booking Type Tabs -->
            <div>
                <label class="mb-3 block text-xs font-bold text-slate-700">نوع الحجز</label>
                <div class="grid grid-cols-2 gap-4 bg-slate-50 p-1.5 rounded-2xl border border-slate-100">
                    <label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl py-3 text-sm font-bold transition-all duration-300 select-none" 
                        :class="bookingType === 'doctor' ? 'bg-white text-primary shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800'">
                        <input type="radio" name="booking_type" value="doctor" x-model="bookingType" class="sr-only">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                        </svg>
                        <span>حسب الطبيب</span>
                    </label>
                    
                    <label class="flex cursor-pointer items-center justify-center gap-2 rounded-xl py-3 text-sm font-bold transition-all duration-300 select-none" 
                        :class="bookingType === 'specialty' ? 'bg-white text-primary shadow-sm border border-slate-100' : 'text-slate-500 hover:text-slate-800'">
                        <input type="radio" name="booking_type" value="specialty" x-model="bookingType" class="sr-only">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        <span>حسب التخصص</span>
                    </label>
                </div>
            </div>

            <!-- Doctor Dropdown -->
            <div class="relative" x-show="bookingType === 'doctor'" x-cloak x-transition>
                <label for="doctor_id" class="mb-2 block text-xs font-bold text-slate-700">اختر الطبيب المعالج</label>
                <div class="relative">
                    <select name="doctor_id" id="doctor_id" :required="bookingType === 'doctor'" :disabled="bookingType !== 'doctor'" 
                        class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50/50 pr-11 pl-10 text-sm outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-300 disabled:bg-slate-100">
                        <option value="" disabled {{ old('doctor_id') ? '' : 'selected' }}>اختر طبيب العيادة...</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>{{ $doctor->name }} ({{ $doctor->specialty }})</option>
                        @endforeach
                    </select>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                    </span>
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-450">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Specialty Dropdown -->
            <div class="relative" x-show="bookingType === 'specialty'" x-cloak x-transition>
                <label for="specialty" class="mb-2 block text-xs font-bold text-slate-700">اختر العيادة / التخصص</label>
                <div class="relative">
                    <select name="specialty" id="specialty" :required="bookingType === 'specialty'" :disabled="bookingType !== 'specialty'" 
                        class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50/50 pr-11 pl-10 text-sm outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-300 disabled:bg-slate-100">
                        <option value="" disabled {{ old('specialty') ? '' : 'selected' }}>اختر العيادة المطلوبة...</option>
                        @foreach($services as $service)
                            <option value="{{ $service->name }}" @selected(old('specialty') === $service->name)>{{ $service->name }}</option>
                        @endforeach
                    </select>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                    </span>
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-450">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Date Input -->
            <div class="relative">
                <label for="appointment_date" class="mb-2 block text-xs font-bold text-slate-700">تاريخ الزيارة المفضل</label>
                <div class="relative">
                    <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}" required
                        class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/50 pr-11 pl-4 text-sm outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-300">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="mt-6 flex h-13 w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-primary to-primary-dark text-base font-bold text-white shadow-lg shadow-primary/20 transition-all hover:scale-102 hover:shadow-xl active:scale-98">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $bookingSubmitLabel }}</span>
            </button>
        </form>
    </div>
</div>
