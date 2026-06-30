<div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="patient_name" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['patient_name'] }}</label>
            <input type="text" name="patient_name" id="patient_name" value="{{ old('patient_name', $report->patient_name ?? '') }}" required 
                class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
        </div>
        
        <div>
            <label for="title" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['title'] }}</label>
            <input type="text" name="title" id="title" value="{{ old('title', $report->title ?? '') }}" required 
                class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="email" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['email'] }}</label>
            <input type="email" name="email" id="email" value="{{ old('email', $report->email ?? '') }}" required dir="ltr"
                class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
            <p class="text-xs text-slate-400 mt-1">سيستخدم المريض هذا البريد للوصول لتقاريره.</p>
        </div>
        
        <div>
            <label for="phone" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['phone'] }}</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $report->phone ?? '') }}" required dir="ltr"
                class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
        </div>
    </div>
    
    <div>
        <label for="file" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['file'] }}</label>
        <div class="flex items-center gap-4">
            <input type="file" name="file" id="file" {{ isset($report) ? '' : 'required' }} accept=".pdf,.jpg,.jpeg,.png"
                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all cursor-pointer">
        </div>
        <p class="text-xs text-slate-400 mt-2">الصيغ المدعومة: PDF, JPG, PNG. أقصى حجم: 10 ميجابايت.</p>
        
        @if(isset($report) && $report->file_path)
            <div class="mt-4 p-3 rounded-lg border border-slate-100 bg-slate-50 text-sm text-slate-600 flex justify-between items-center">
                <span>يوجد ملف مرفق حالياً ({{ strtoupper($report->file_type) }})</span>
                <span class="text-xs text-amber-600">إذا قمت برفع ملف جديد، سيتم استبدال القديم.</span>
            </div>
        @endif
    </div>

    <div>
        <label for="notes" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['notes'] }}</label>
        <textarea name="notes" id="notes" rows="3" 
            class="w-full rounded-xl border border-slate-250 bg-white px-4 py-3 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">{{ old('notes', $report->notes ?? '') }}</textarea>
    </div>
</div>
