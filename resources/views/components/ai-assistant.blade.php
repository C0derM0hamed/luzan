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
            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
            </svg>
        </span>
        <span class="ai-assistant-trigger__icon" x-show="isOpen" x-transition.opacity>
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
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
        class="ai-assistant-panel"
        @click.outside="isOpen = false"
        role="dialog"
        aria-label="المساعد الذكي"
    >
        {{-- Header --}}
        <div class="ai-assistant-header">
            <div class="flex items-center gap-3">
                <div class="ai-assistant-avatar">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">المساعد الذكي</h3>
                    <p class="text-[11px] text-white/75 font-medium" x-text="config.clinicName"></p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <button type="button" @click="clearChat()" class="ai-assistant-header-btn" title="محادثة جديدة" aria-label="محادثة جديدة">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182"/></svg>
                </button>
                <button type="button" @click="isOpen = false" class="ai-assistant-header-btn" aria-label="إغلاق">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div class="ai-assistant-messages" x-ref="messagesContainer">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="ai-assistant-message" :class="msg.role === 'user' ? 'ai-assistant-message--user' : 'ai-assistant-message--assistant'">
                    <div class="ai-assistant-message__bubble" x-html="formatMessage(msg.content, msg.role)"></div>
                </div>
            </template>

            {{-- Typing indicator --}}
            <div x-show="isLoading" class="ai-assistant-message ai-assistant-message--assistant">
                <div class="ai-assistant-message__bubble ai-assistant-typing">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="ai-assistant-quick-actions" x-show="showQuickActions && !isLoading">
            <template x-for="action in config.quickActions" :key="action.label">
                <button type="button" @click="handleQuickAction(action)" class="ai-assistant-quick-btn" x-text="action.label"></button>
            </template>
        </div>

        {{-- Input --}}
        <form @submit.prevent="sendMessage()" class="ai-assistant-input-area">
            <textarea
                x-model="input"
                x-ref="inputField"
                @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                rows="1"
                placeholder="اكتب رسالتك هنا..."
                class="ai-assistant-input"
                :disabled="isLoading"
                maxlength="2000"
            ></textarea>
            <button type="submit" class="ai-assistant-send" :disabled="isLoading || !input.trim()" aria-label="إرسال">
                <svg x-show="!isLoading" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                </svg>
                <svg x-show="isLoading" class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>
@endif
