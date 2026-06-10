<div class="space-y-5">
    <div>
        <label for="name" class="mb-2 block text-xs font-bold text-slate-700">{{ $fieldLabels['name'] }}</label>
        <input type="text" name="name" id="name" value="{{ old('name', $branch->name ?? '') }}" required 
            placeholder="اسم الفرع (مثال: مجمع قلوة)"
            class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
    </div>
    
    <div>
        <label for="address" class="mb-2 block text-xs font-bold text-slate-700">{{ $fieldLabels['address'] }}</label>
        <textarea name="address" id="address" rows="3" required 
            placeholder="العنوان الكامل للفرع بالتفصيل"
            class="w-full rounded-xl border border-slate-250 bg-white px-4 py-2.5 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">{{ old('address', $branch->address ?? '') }}</textarea>
    </div>
    
    <div>
        <label for="phone" class="mb-2 block text-xs font-bold text-slate-700">{{ $fieldLabels['phone'] }}</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $branch->phone ?? '') }}" required 
            placeholder="رقم الهاتف للتواصل"
            class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350" dir="ltr">
    </div>
    
    <div>
        <label for="email" class="mb-2 block text-xs font-bold text-slate-700">{{ $fieldLabels['email'] }}</label>
        <input type="email" name="email" id="email" value="{{ old('email', $branch->email ?? '') }}" 
            placeholder="example@luzanmedical.com"
            class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350" dir="ltr">
    </div>
    
    <div>
        <label for="map_url" class="mb-2 block text-xs font-bold text-slate-700">{{ $fieldLabels['map_url'] }}</label>
        <input type="url" name="map_url" id="map_url" value="{{ old('map_url', $branch->map_url ?? '') }}" 
            placeholder="رابط موقع GPS من خرائط جوجل (مثال: https://maps.app.goo.gl/...)"
            class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350" dir="ltr">
    </div>
    
    <div class="flex items-center gap-2 py-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $branch->is_active ?? true)) class="h-4 w-4 rounded border-slate-350 text-primary focus:ring-primary transition-all">
        <label for="is_active" class="text-xs font-bold text-slate-650 cursor-pointer select-none">{{ $fieldLabels['is_active'] }}</label>
    </div>
</div>
