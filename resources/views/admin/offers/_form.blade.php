<div class="space-y-6">
    <div>
        <label for="title" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['title'] }}</label>
        <input type="text" name="title" id="title" value="{{ old('title', $offer->title ?? '') }}" required 
            class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
    </div>
    
    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['description'] }}</label>
        <textarea name="description" id="description" rows="4" required 
            class="w-full rounded-xl border border-slate-250 bg-white px-4 py-3 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">{{ old('description', $offer->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="start_date" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['start_date'] }}</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date', isset($offer) ? $offer->start_date->format('Y-m-d') : '') }}" required 
                class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
        </div>
        <div>
            <label for="end_date" class="mb-2 block text-sm font-semibold text-[#1e293b]">{{ $fieldLabels['end_date'] }}</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date', isset($offer) ? $offer->end_date->format('Y-m-d') : '') }}" required 
                class="h-11 w-full rounded-xl border border-slate-250 bg-white px-4 text-sm outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/10 hover:border-slate-350">
        </div>
    </div>
    
    <div x-data="imageUpload(@json($offer->image_url ?? null))" class="space-y-2">
        <label class="mb-2 block text-sm font-semibold text-[#1e293b]">صورة العرض (اختياري)</label>
        
        <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-2xl border border-slate-100 bg-slate-50/50">
            <!-- Preview Area -->
            <div class="relative flex h-24 w-32 shrink-0 items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-slate-200 bg-white shadow-sm transition-all">
                <template x-if="imageUrl">
                    <img :src="imageUrl" class="h-full w-full object-cover">
                </template>
                <template x-if="!imageUrl">
                    <svg class="h-8 w-8 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </template>
                <!-- Clear Button -->
                <template x-if="imageUrl">
                    <button type="button" @click="clearImage" class="absolute inset-0 flex items-center justify-center bg-black/60 text-white opacity-0 hover:opacity-100 transition-opacity duration-200" title="حذف الصورة">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </template>
            </div>

            <!-- Upload Button / Drag Zone -->
            <div class="flex-1 w-full">
                <div 
                    @dragover.prevent="dragOver = true" 
                    @dragleave.prevent="dragOver = false" 
                    @drop.prevent="handleDrop($event)"
                    :class="dragOver ? 'border-primary bg-primary/5' : 'border-slate-200 bg-white'"
                    class="relative flex flex-col items-center justify-center rounded-xl border-2 border-dashed p-6 text-center transition-all cursor-pointer hover:border-primary/50 group"
                    @click="$refs.fileInput.click()"
                >
                    <svg class="h-8 w-8 text-slate-400 group-hover:text-primary transition-colors mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                    </svg>
                    <p class="text-sm font-semibold text-slate-700">اضغط لرفع صورة أو اسحبها هنا</p>
                    <p class="text-xs text-slate-400 mt-1">PNG, JPG, JPEG (أقصى حجم 2 ميجابايت)</p>
                    
                    <input 
                        type="file" 
                        name="image" 
                        x-ref="fileInput" 
                        class="hidden" 
                        accept="image/*" 
                        @change="handleFileSelect($event)"
                    >
                </div>
            </div>
        </div>
    </div>
    
    <div class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $offer->is_active ?? true)) 
            class="h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary transition-all">
        <label for="is_active" class="text-sm font-semibold text-[#1e293b] cursor-pointer select-none">{{ $fieldLabels['is_active'] }}</label>
    </div>
</div>

@push('scripts')
<script>
    function imageUpload(initialUrl) {
        return {
            imageUrl: initialUrl || null,
            dragOver: false,
            handleFileSelect(e) {
                const file = e.target.files[0];
                if (file) {
                    this.previewFile(file);
                }
            },
            handleDrop(e) {
                this.dragOver = false;
                const file = e.dataTransfer.files[0];
                if (file) {
                    this.$refs.fileInput.files = e.dataTransfer.files;
                    this.previewFile(file);
                }
            },
            previewFile(file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imageUrl = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            clearImage() {
                this.imageUrl = null;
                this.$refs.fileInput.value = '';
            }
        }
    }
</script>
@endpush
