/**
 * Premium AI Assistant chat widget for Luzan Medical Clinic.
 */
function aiAssistant(config) {
    const STORAGE_KEY = 'luzan_ai_chat_history';
    const SESSION_KEY = 'luzan_ai_session_id';

    return {
        config,
        isOpen: false,
        isLoading: false,
        input: '',
        messages: [],
        sessionId: '',
        showQuickActions: true,
        hasOpenedOnce: false,

        init() {
            this.sessionId = sessionStorage.getItem(SESSION_KEY) || '';
            this.loadHistory();
            this.$watch('messages', () => this.scrollToBottom());
            this.$watch('isLoading', () => this.scrollToBottom());
        },

        toggle() {
            this.isOpen = !this.isOpen;
            if (this.isOpen && !this.hasOpenedOnce) {
                this.hasOpenedOnce = true;
                if (this.messages.length === 0) {
                    this.messages.push({
                        role: 'assistant',
                        content: this.config.welcomeMessage,
                    });
                }
                this.$nextTick(() => this.$refs.inputField?.focus());
            }
        },

        loadHistory() {
            if (!this.config.chatHistoryEnabled) return;

            try {
                const stored = sessionStorage.getItem(STORAGE_KEY);
                if (stored) {
                    const parsed = JSON.parse(stored);
                    if (Array.isArray(parsed) && parsed.length > 0) {
                        this.messages = parsed;
                        this.showQuickActions = parsed.length <= 1;
                    }
                }
            } catch {
                sessionStorage.removeItem(STORAGE_KEY);
            }
        },

        saveHistory() {
            if (!this.config.chatHistoryEnabled) return;

            try {
                sessionStorage.setItem(STORAGE_KEY, JSON.stringify(this.messages.slice(-40)));
            } catch {
                // Storage full or unavailable — ignore
            }
        },

        clearChat() {
            this.messages = [{
                role: 'assistant',
                content: this.config.welcomeMessage,
            }];
            this.showQuickActions = true;
            this.sessionId = '';
            sessionStorage.removeItem(STORAGE_KEY);
            sessionStorage.removeItem(SESSION_KEY);
        },

        handleQuickAction(action) {
            if (action.message) {
                this.sendMessage(action.message);
            }
        },

        async sendMessage(text) {
            const message = (text || this.input).trim();
            if (!message || this.isLoading) return;

            this.input = '';
            this.showQuickActions = false;

            this.messages.push({ role: 'user', content: message });
            this.saveHistory();
            this.isLoading = true;

            const history = this.messages
                .slice(0, -1)
                .filter(m => m.role === 'user' || m.role === 'assistant')
                .slice(-18)
                .map(m => ({ role: m.role, content: m.content }));

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                const response = await fetch('/api/ai/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        message,
                        history,
                        session_id: this.sessionId,
                    }),
                });

                const data = await response.json();

                if (!response.ok) {
                    this.messages.push({
                        role: 'assistant',
                        content: data.error || 'عذراً، حدث خطأ. يرجى المحاولة لاحقاً أو التواصل مع العيادة.',
                    });
                } else {
                    if (data.session_id) {
                        this.sessionId = data.session_id;
                        sessionStorage.setItem(SESSION_KEY, this.sessionId);
                    }
                    this.messages.push({
                        role: 'assistant',
                        content: data.reply,
                    });
                }
            } catch {
                this.messages.push({
                    role: 'assistant',
                    content: 'عذراً، تعذر الاتصال بالمساعد الذكي. يرجى التحقق من اتصالك بالإنترنت أو التواصل مع العيادة.',
                });
            } finally {
                this.isLoading = false;
                this.saveHistory();
                this.$nextTick(() => this.$refs.inputField?.focus());
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        formatMessage(content, role = 'assistant') {
            if (!content) return '';

            if (role === 'user') {
                return this.escapeHtml(content).replace(/\n/g, '<br>');
            }

            return this.renderMarkdown(content);
        },

        escapeHtml(text) {
            return text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        },

        applyInlineFormatting(line) {
            let html = this.escapeHtml(line);

            html = html.replace(/`([^`]+)`/g, '<code class="ai-md-code">$1</code>');
            html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
            html = html.replace(/__(.+?)__/g, '<strong>$1</strong>');
            html = html.replace(/(^|[^*])\*([^*\n]+)\*(?!\*)/g, '$1<em>$2</em>');
            html = html.replace(/(https?:\/\/[^\s<]+?(?=[.,:;"')\]]*(?:\s|<|$)))/g, '<a href="$1" target="_blank" rel="noopener" class="ai-assistant-link">$1</a>');

            return html;
        },

        renderMarkdown(content) {
            const lines = content.replace(/\r\n/g, '\n').split('\n');
            let html = '';
            let inList = null;

            const closeList = () => {
                if (inList === 'ul') html += '</ul>';
                if (inList === 'ol') html += '</ol>';
                inList = null;
            };

            for (const rawLine of lines) {
                const line = rawLine.trimEnd();
                const trimmed = line.trim();

                if (trimmed === '') {
                    closeList();
                    continue;
                }

                const headingMatch = trimmed.match(/^#{1,3}\s+(.+)$/);
                if (headingMatch) {
                    closeList();
                    html += `<p class="ai-md-heading">${this.applyInlineFormatting(headingMatch[1])}</p>`;
                    continue;
                }

                const bulletMatch = trimmed.match(/^[-*•●]\s+(.+)$/);
                if (bulletMatch) {
                    if (inList !== 'ul') {
                        closeList();
                        html += '<ul class="ai-md-list">';
                        inList = 'ul';
                    }
                    html += `<li>${this.applyInlineFormatting(bulletMatch[1])}</li>`;
                    continue;
                }

                const numberedMatch = trimmed.match(/^\d+[.)]\s+(.+)$/);
                if (numberedMatch) {
                    if (inList !== 'ol') {
                        closeList();
                        html += '<ol class="ai-md-list ai-md-list--ordered">';
                        inList = 'ol';
                    }
                    html += `<li>${this.applyInlineFormatting(numberedMatch[1])}</li>`;
                    continue;
                }

                closeList();
                html += `<p class="ai-md-p">${this.applyInlineFormatting(trimmed)}</p>`;
            }

            closeList();

            return html ? `<div class="ai-md">${html}</div>` : '';
        },
    };
}

window.aiAssistant = aiAssistant;

export { aiAssistant };
