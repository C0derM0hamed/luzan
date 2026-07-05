<div class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-xl shadow-slate-100/40">
    <!-- Form Header -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-950 p-8 text-right text-white relative overflow-hidden">
        <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-primary/10 blur-xl"></div>
        <div class="absolute left-10 bottom-0 h-20 w-20 rounded-full bg-accent-blue/10 blur-xl"></div>
        
        <div class="relative z-10 flex items-center gap-4.5">
            <div class="rounded-2xl bg-white/5 p-3.5 border border-white/10 backdrop-blur-md">
                <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75M9 11h.008v.008H9V11zm.008 2.25H9v.008h.008v-.008zm0 2.25H9v.008h.008v-.008zM12 11h.008v.008H12V11zm.008 2.25H12v.008h.008v-.008zm0 2.25H12v.008h.008v-.008zm3.377-4.5h.008v.008h-.008V11zm.008 2.25h-.008v.008h.008v-.008zm0 2.25h-.008v.008h.008v-.008z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black tracking-tight">{{ $bookingFormTitle }}</h2>
                <p class="mt-1 text-xs font-bold text-slate-400">{{ $bookingFormSubtitle }}</p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl bg-emerald-50/50 p-4.5 border border-emerald-100 text-sm text-emerald-800" dir="rtl">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600 animate-bounce" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-bold leading-relaxed">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Error Alert -->
        @if($errors->any())
            <div class="mb-6 flex items-start gap-3 rounded-2xl bg-rose-50/50 p-4.5 border border-rose-100 text-sm text-rose-800" dir="rtl">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                <div class="flex-1">
                    <span class="font-bold block mb-1 text-rose-900">يرجى تصحيح الأخطاء التالية:</span>
                    <ul class="list-disc pr-4 space-y-1 font-semibold text-rose-750">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Booking Form -->
        <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6" x-data="bookingForm('{{ old('branch_id') }}', '{{ old('doctor_id') }}', '{{ old('booking_type', 'doctor') }}')">
            @csrf

            <!-- Branch Dropdown -->
            <div class="relative">
                <label for="branch_id" class="mb-2.5 block text-xs font-black text-slate-700">الفرع المفضل</label>
                <div class="relative">
                    <select name="branch_id" id="branch_id" required x-model="branchId" @change="fetchDoctors"
                        class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50/30 pr-11 pl-10 text-sm font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350">
                        <option value="" disabled selected>اختر الفرع...</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </span>
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                    </span>
                </div>
            </div>

            <!-- Name Input -->
            <div class="relative">
                <label for="full_name" class="mb-2.5 block text-xs font-black text-slate-700">الاسم الكامل</label>
                <div class="relative">
                    <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" placeholder="أدخل اسمك ثلاثياً" required
                        class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/30 pr-11 pl-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350">
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
                    <label for="national_id" class="mb-2.5 block text-xs font-black text-slate-700">رقم الهوية أو الإقامة</label>
                    <div class="relative">
                        <input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}" placeholder="1XXXXXXXXX" required
                            class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/30 pr-11 pl-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350" dir="ltr">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm-1.2 6.4a2.25 2.25 0 00-1.35 0 2.25 2.25 0 00-1.2 1.35v.075h3.75v-.075a2.25 2.25 0 00-1.2-1.35z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Mobile Phone -->
                <div class="relative">
                    <label for="mobile" class="mb-2.5 block text-xs font-black text-slate-700">رقم الجوال</label>
                    <div class="relative">
                        <input type="tel" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="05XXXXXXXX" required
                            class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/30 pr-11 pl-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350" dir="ltr">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Booking Type Cards Selection -->
            <div>
                <label class="mb-3 block text-xs font-black text-slate-700">تفضيل طريقة الحجز</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative flex cursor-pointer items-center justify-between rounded-2xl border p-4.5 transition-all select-none"
                        :class="bookingType === 'doctor' ? 'border-primary/30 bg-primary/5 text-primary shadow-sm' : 'border-slate-100 bg-slate-50/50 hover:bg-slate-50 hover:border-slate-200'">
                        <input type="radio" name="booking_type" value="doctor" x-model="bookingType" class="sr-only">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white shadow-sm border border-slate-100 text-slate-500" :class="bookingType === 'doctor' ? 'text-primary' : ''">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-slate-800">حجز حسب الطبيب</span>
                        </div>
                        <div class="h-4.5 w-4.5 rounded-full border flex items-center justify-center transition-all" :class="bookingType === 'doctor' ? 'border-primary bg-primary' : 'border-slate-300 bg-white'">
                            <span class="h-1.5 w-1.5 rounded-full bg-white" x-show="bookingType === 'doctor'"></span>
                        </div>
                    </label>
                    
                    <label class="relative flex cursor-pointer items-center justify-between rounded-2xl border p-4.5 transition-all select-none"
                        :class="bookingType === 'specialty' ? 'border-primary/30 bg-primary/5 text-primary shadow-sm' : 'border-slate-100 bg-slate-50/50 hover:bg-slate-50 hover:border-slate-200'">
                        <input type="radio" name="booking_type" value="specialty" x-model="bookingType" class="sr-only">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white shadow-sm border border-slate-100 text-slate-500" :class="bookingType === 'specialty' ? 'text-primary' : ''">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-bold text-slate-800">حجز حسب التخصص</span>
                        </div>
                        <div class="h-4.5 w-4.5 rounded-full border flex items-center justify-center transition-all" :class="bookingType === 'specialty' ? 'border-primary bg-primary' : 'border-slate-300 bg-white'">
                            <span class="h-1.5 w-1.5 rounded-full bg-white" x-show="bookingType === 'specialty'"></span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Doctor Dropdown -->
            <div class="relative" x-show="bookingType === 'doctor'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <label for="doctor_id" class="mb-2.5 block text-xs font-black text-slate-700">اختر الطبيب المعالج</label>
                <div class="relative">
                    <select name="doctor_id" id="doctor_id" :required="bookingType === 'doctor'" :disabled="bookingType !== 'doctor' || loadingDoctors" x-model="doctorId"
                        class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50/30 pr-11 pl-10 text-sm font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350 disabled:bg-slate-100 disabled:text-slate-400">
                        <option value="" disabled selected x-text="loadingDoctors ? 'جاري تحميل الأطباء...' : (!branchId ? 'يرجى اختيار الفرع أولاً' : (doctors.length === 0 ? 'لا يوجد أطباء في هذا الفرع' : 'اختر طبيب العيادة...'))"></option>
                        <template x-for="doc in doctors" :key="doc.id">
                            <option :value="doc.id" x-text="`${doc.name} (${doc.specialty})`"></option>
                        </template>
                    </select>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400" x-show="!loadingDoctors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                    </span>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-primary" x-show="loadingDoctors" x-cloak>
                        <svg class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Specialty Dropdown -->
            <div class="relative" x-show="bookingType === 'specialty'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <label for="specialty" class="mb-2.5 block text-xs font-black text-slate-700">اختر العيادة / التخصص</label>
                <div class="relative">
                    <select name="specialty" id="specialty" :required="bookingType === 'specialty'" :disabled="bookingType !== 'specialty'" 
                        class="h-12 w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50/30 pr-11 pl-10 text-sm font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350 disabled:bg-slate-100">
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
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Date Input -->
            <div class="relative">
                <label for="appointment_date" class="mb-2.5 block text-xs font-black text-slate-700">تاريخ الزيارة المفضل</label>
                <div class="relative">
                    <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}" required
                        class="h-12 w-full rounded-2xl border border-slate-200 bg-slate-50/30 pr-11 pl-4 text-sm font-bold text-slate-800 outline-none transition-all focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 hover:border-slate-350">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75"/>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="mt-6 flex h-13 w-full items-center justify-center gap-2.5 rounded-2xl bg-slate-900 text-sm font-black text-white shadow-xl shadow-slate-950/10 transition-all hover:bg-primary hover:shadow-primary/20 hover:scale-101 active:scale-99">
                <svg class="h-4.5 w-4.5 text-primary-light" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $bookingSubmitLabel }}</span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function bookingForm(oldBranch, oldDoctor, oldType) {
        return {
            branchId: oldBranch || '',
            doctorId: oldDoctor || '',
            bookingType: oldType || 'doctor',
            doctors: [],
            loadingDoctors: false,
            
            init() {
                if (this.branchId) {
                    this.fetchDoctors();
                }
            },
            
            fetchDoctors() {
                if (!this.branchId) return;
                
                this.loadingDoctors = true;
                this.doctorId = '';
                
                fetch(`/api/branches/${this.branchId}/doctors`)
                    .then(res => res.json())
                    .then(data => {
                        this.doctors = data;
                        if (oldDoctor && data.find(d => d.id == oldDoctor)) {
                            this.doctorId = oldDoctor;
                            oldDoctor = null; // only use once
                        }
                    })
                    .catch(err => console.error('Error fetching doctors:', err))
                    .finally(() => {
                        this.loadingDoctors = false;
                    });
            }
        };
    }
</script>
@endpush
