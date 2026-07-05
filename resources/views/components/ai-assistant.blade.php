@if($aiAssistant['enabled'] ?? false)
<div
    x-data="aiAssistant(@js($aiAssistant))"
    x-cloak
    class="ai-assistant-root"
    dir="rtl"
>
    {{-- Floating trigger button --}}
    <button
        type="button"
        @click="toggle()"
        class="ai-assistant-trigger group"
        :class="{ 'ai-assistant-trigger--open': isOpen }"
        :aria-expanded="isOpen"
        aria-label="فتح المساعد الذكي"
    >
        <span class="ai-assistant-trigger__pulse"></span>
        <span class="ai-assistant-trigger__icon" x-show="!isOpen" x-transition.opacity>
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
            </svg>
        </span>
        <span class="ai-assistant-trigger__icon" x-show="isOpen" x-transition.opacity>
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </span>
    </button>

    {{-- Chat panel --}}
    <div
        x-show="isOpen"
        x-transition:enter="ai-assistant-panel-enter"
        x-transition:enter-start="ai-assistant-panel-enter-from"
        x-transition:enter-end="ai-assistant-panel-enter-to"
        x-transition:leave="ai-assistant-panel-leave"
        x-transition:leave-start="ai-assistant-panel-leave-from"
        x-transition:leave-end="ai-assistant-panel-leave-to"
        class="ai-assistant-panel border border-slate-100 shadow-2xl"
        @click.outside="isOpen = false"
        role="dialog"
        aria-label="المساعد الذكي"
    >
        {{-- Header --}}
        <div class="flex items-center justify-between p-4 bg-slate-950 text-white shrink-0 border-b border-slate-900">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/5 border border-white/10 text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-black text-white leading-tight">المساعد الطبي الذكي</h3>
                    <p class="text-[10px] text-slate-400 font-bold mt-0.5" x-text="config.clinicName"></p>
                </div>
            </div>
            <div class="flex items-center gap-1.5">
                <button type="button" @click="clearChat()" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all" title="محادثة جديدة" aria-label="محادثة جديدة">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                </button>
                <button type="button" @click="isOpen = false" class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all" aria-label="إغلاق">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div class="ai-assistant-messages bg-slate-50/50" x-ref="messagesContainer">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="ai-assistant-message" :class="msg.role === 'user' ? 'ai-assistant-message--user' : 'ai-assistant-message--assistant'">
                    <div class="ai-assistant-message__bubble shadow-sm" :class="msg.role === 'user' ? '!bg-slate-900 border border-slate-900' : '!bg-white border border-slate-100'" x-html="formatMessage(msg.content, msg.role)"></div>
                </div>
            </template>

            {{-- Typing indicator --}}
            <div x-show="isLoading" class="ai-assistant-message ai-assistant-message--assistant">
                <div class="ai-assistant-message__bubble ai-assistant-typing !bg-white border border-slate-100 shadow-sm">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="flex flex-wrap gap-1.5 p-3.5 border-t border-slate-100 bg-white shrink-0" x-show="showQuickActions && !isLoading">
            <template x-for="action in config.quickActions" :key="action.label">
                <button type="button" @click="handleQuickAction(action)" class="px-3.5 py-1.5 rounded-xl text-[11px] font-black text-slate-700 bg-slate-50 border border-slate-200/80 hover:bg-primary hover:text-white hover:border-primary transition-all duration-300" x-text="action.label"></button>
            </template>
        </div>

        {{-- Input --}}
        <form @submit.prevent="sendMessage()" class="flex items-end gap-2 p-3.5 border-t border-slate-100 bg-white shrink-0">
            <textarea
                x-model="input"
                x-ref="inputField"
                @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                rows="1"
                placeholder="اكتب استفسارك هنا..."
                class="flex-1 resize-none border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs font-bold text-slate-800 outline-none transition-all focus:border-primary focus:ring-4 focus:ring-primary/10 bg-slate-50"
                :disabled="isLoading"
                maxlength="2000"
            ></textarea>
            <button type="submit" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-white transition-all hover:bg-primary hover:scale-105 active:scale-95 disabled:opacity-40 disabled:hover:bg-slate-900 disabled:scale-100" :disabled="isLoading || !input.trim()" aria-label="إرسال">
                <svg x-show="!isLoading" class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                </svg>
                <svg x-show="isLoading" class="h-4.5 w-4.5 animate-spin" fill="none" viewBox="0 0 24 24" x-cloak>
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>
@endif
