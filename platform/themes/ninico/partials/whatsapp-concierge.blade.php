@php
    $whatsappEnabled = theme_option('whatsapp_concierge_enabled', 'yes');
    if ($whatsappEnabled !== 'yes') {
        return;
    }

    $rawPhone = theme_option('whatsapp_number') ?: theme_option('hotline', '8801700000000');
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    if (empty($cleanPhone)) {
        $cleanPhone = '8801700000000';
    }

    $currentProduct = (isset($product) && is_object($product) && isset($product->name)) ? $product : null;
    $productName = $currentProduct ? $currentProduct->name : null;
    $productUrl = $currentProduct ? $currentProduct->url : url()->current();

    $defaultGreeting = 'Hello Western Bespoke Atelier, I would like to inquire about bespoke tailoring services and fabrics.';
    if ($productName) {
        $defaultGreeting = "Hello Western Bespoke Atelier, I am interested in custom tailoring for: {$productName} ({$productUrl}).";
    }
@endphp

<div id="bespoke-whatsapp-widget" class="bespoke-whatsapp-widget" data-phone="{{ $cleanPhone }}">
    {{-- Concierge Floating Card --}}
    <div id="bespoke-whatsapp-card" class="bespoke-wa-card" aria-hidden="true">
        <div class="bespoke-wa-header">
            <div class="bespoke-wa-header-brand">
                <div class="bespoke-wa-avatar">
                    <span class="bespoke-wa-monogram">WB</span>
                    <span class="bespoke-wa-status-dot" title="Online"></span>
                </div>
                <div class="bespoke-wa-header-text">
                    <h5 class="bespoke-wa-title mb-0">Western Bespoke</h5>
                    <p class="bespoke-wa-subtitle mb-0">Master Tailor & Atelier Concierge</p>
                </div>
            </div>
            <button type="button" class="bespoke-wa-close-btn" id="bespoke-wa-close" aria-label="Close Concierge">
                &times;
            </button>
        </div>

        <div class="bespoke-wa-body">
            <div class="bespoke-wa-message-bubble">
                <p class="bespoke-wa-message-text mb-0">
                    {{ __('Greetings. How may our Master Tailor assist your bespoke wardrobe journey today?') }}
                </p>
                <span class="bespoke-wa-time">{{ date('g:i A') }}</span>
            </div>

            <div class="bespoke-wa-quick-actions">
                <span class="bespoke-wa-quick-label">{{ __('Quick inquiries:') }}</span>
                <div class="bespoke-wa-chips">
                    @if($productName)
                        <button type="button" class="bespoke-wa-chip" data-msg="Hello Western Bespoke, I would like to inquire about bespoke tailoring for {{ $productName }}.">
                            👔 {{ __('Inquire about this piece') }}
                        </button>
                    @endif
                    <button type="button" class="bespoke-wa-chip" data-msg="Hello Western Bespoke, I would like to schedule a private master measurement and fitting consultation.">
                        ✂️ {{ __('Book Atelier Fitting') }}
                    </button>
                    <button type="button" class="bespoke-wa-chip" data-msg="Hello Western Bespoke, what premium suiting fabrics (Scabal, Zegna, Loro Piana, English wool) do you currently stock?">
                        🧵 {{ __('Fabric Selection & Advice') }}
                    </button>
                </div>
            </div>

            <div class="bespoke-wa-input-wrapper">
                <textarea
                    id="bespoke-wa-input"
                    class="bespoke-wa-input"
                    rows="2"
                    placeholder="{{ __('Type your bespoke inquiry here...') }}"
                >{{ $defaultGreeting }}</textarea>
            </div>

            <button type="button" id="bespoke-wa-send-btn" class="bespoke-wa-send-btn">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span>{{ __('Start WhatsApp Chat') }}</span>
            </button>
        </div>
    </div>

    {{-- Concierge Floating Trigger Button --}}
    <button
        type="button"
        id="bespoke-whatsapp-trigger"
        class="bespoke-wa-trigger"
        aria-label="Contact Master Tailor on WhatsApp"
        title="Western Bespoke Atelier Concierge"
    >
        <span class="bespoke-wa-pulse-ring"></span>
        <span class="bespoke-wa-trigger-icon">
            <svg viewBox="0 0 24 24" width="28" height="28" fill="#ffffff">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
        </span>
        <span class="bespoke-wa-tooltip">
            <span class="bespoke-wa-tooltip-dot"></span>
            {{ __('Atelier Concierge') }}
        </span>
    </button>
</div>

<style>
    /* Bespoke Floating WhatsApp Concierge Styles */
    .bespoke-whatsapp-widget {
        position: fixed;
        inset-inline-end: 28px;
        bottom: 28px;
        z-index: 1040;
        font-family: var(--primary-font, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif);
    }

    /* Floating Trigger Button */
    .bespoke-wa-trigger {
        position: relative;
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        border: 2px solid #C6A364;
        box-shadow: 0 8px 24px rgba(10, 25, 47, 0.25), 0 2px 6px rgba(37, 211, 102, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        outline: none;
        padding: 0;
        transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.25s ease;
    }

    .bespoke-wa-trigger:hover {
        transform: scale(1.08);
        box-shadow: 0 12px 30px rgba(10, 25, 47, 0.35), 0 4px 12px rgba(37, 211, 102, 0.6);
    }

    .bespoke-wa-trigger:active {
        transform: scale(0.96);
    }

    .bespoke-wa-trigger-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }

    /* Soft pulse ring */
    .bespoke-wa-pulse-ring {
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border-radius: 50%;
        border: 2px solid #25D366;
        animation: bespoke-pulse 2.2s infinite ease-out;
        pointer-events: none;
        z-index: 1;
    }

    @keyframes bespoke-pulse {
        0% {
            transform: scale(1);
            opacity: 0.8;
        }
        70% {
            transform: scale(1.4);
            opacity: 0;
        }
        100% {
            transform: scale(1.4);
            opacity: 0;
        }
    }

    /* Tooltip / Badge */
    .bespoke-wa-tooltip {
        position: absolute;
        inset-inline-end: calc(100% + 14px);
        top: 50%;
        transform: translateY(-50%);
        background: #0B1C18;
        color: #F8F9FA;
        border: 1px solid #C6A364;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        white-space: nowrap;
        letter-spacing: 0.03em;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.18);
        display: flex;
        align-items: center;
        gap: 6px;
        pointer-events: none;
        opacity: 0;
        visibility: hidden;
        transition: all 0.25s ease;
    }

    .bespoke-wa-tooltip-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #25D366;
        box-shadow: 0 0 6px #25D366;
    }

    .bespoke-wa-trigger:hover .bespoke-wa-tooltip {
        opacity: 1;
        visibility: visible;
        transform: translateY(-50%) translateX(-4px);
    }

    /* Concierge Card Container */
    .bespoke-wa-card {
        position: absolute;
        inset-inline-end: 0;
        bottom: calc(100% + 16px);
        width: 340px;
        max-width: calc(100vw - 32px);
        background: #ffffff;
        border: 1px solid rgba(197, 168, 128, 0.4);
        border-radius: 12px;
        box-shadow: 0 16px 40px rgba(10, 25, 47, 0.22), 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        display: none;
        opacity: 0;
        transform: translateY(12px) scale(0.96);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 1050;
    }

    .bespoke-wa-card.active {
        display: block;
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    /* Card Header */
    .bespoke-wa-header {
        background: #0B1C18;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #C6A364;
    }

    .bespoke-wa-header-brand {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .bespoke-wa-avatar {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #06110E;
        border: 1px solid #C6A364;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bespoke-wa-monogram {
        color: #C6A364;
        font-family: var(--heading-font, serif);
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 0.05em;
    }

    .bespoke-wa-status-dot {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #25D366;
        border: 2px solid #0B1C18;
    }

    .bespoke-wa-title {
        color: #ffffff;
        font-family: var(--heading-font, serif);
        font-size: 0.95rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    .bespoke-wa-subtitle {
        color: #C6A364;
        font-size: 0.72rem;
        letter-spacing: 0.03em;
        text-transform: uppercase;
    }

    .bespoke-wa-close-btn {
        background: transparent;
        border: none;
        color: #ffffff;
        font-size: 1.5rem;
        line-height: 1;
        cursor: pointer;
        padding: 0;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .bespoke-wa-close-btn:hover {
        opacity: 1;
        color: #C6A364;
    }

    /* Card Body */
    .bespoke-wa-body {
        padding: 18px;
        background: #FDFBF8;
    }

    .bespoke-wa-message-bubble {
        background: #ffffff;
        border: 1px solid #EBE5DC;
        border-radius: 10px 10px 10px 2px;
        padding: 12px 14px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        margin-bottom: 14px;
    }

    .bespoke-wa-message-text {
        font-size: 0.82rem;
        color: #2D3748;
        line-height: 1.45;
    }

    .bespoke-wa-time {
        display: block;
        text-align: right;
        font-size: 0.68rem;
        color: #A0AEC0;
        margin-top: 4px;
    }

    .bespoke-wa-quick-actions {
        margin-bottom: 12px;
    }

    .bespoke-wa-quick-label {
        display: block;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #718096;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .bespoke-wa-chips {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .bespoke-wa-chip {
        background: #ffffff;
        border: 1px solid #D8CFC4;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 0.76rem;
        color: #0B1C18;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
    }

    .bespoke-wa-chip:hover {
        background: #0B1C18;
        color: #C6A364;
        border-color: #0B1C18;
    }

    .bespoke-wa-input-wrapper {
        margin-bottom: 12px;
    }

    .bespoke-wa-input {
        width: 100%;
        border: 1px solid #D8CFC4;
        border-radius: 6px;
        padding: 8px 10px;
        font-size: 0.8rem;
        color: #1A202C;
        background: #ffffff;
        resize: none;
        outline: none;
        transition: border-color 0.2s;
        box-sizing: border-box;
    }

    .bespoke-wa-input:focus {
        border-color: #0B1C18;
        box-shadow: 0 0 0 2px rgba(10, 25, 47, 0.1);
    }

    .bespoke-wa-send-btn {
        width: 100%;
        background: #25D366;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        padding: 11px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }

    .bespoke-wa-send-btn:hover {
        background: #1EBE5D;
        box-shadow: 0 6px 16px rgba(37, 211, 102, 0.45);
        color: #ffffff;
    }

    /* Mobile Responsive Adaptation - Handled elegantly via mobile bottom navigation */
    @media (max-width: 768px) {
        .bespoke-whatsapp-widget {
            display: none !important;
        }
    }
</style>

<script>
    (function () {
        document.addEventListener('DOMContentLoaded', function () {
            var widget = document.getElementById('bespoke-whatsapp-widget');
            if (!widget) return;

            var trigger = document.getElementById('bespoke-whatsapp-trigger');
            var card = document.getElementById('bespoke-whatsapp-card');
            var closeBtn = document.getElementById('bespoke-wa-close');
            var sendBtn = document.getElementById('bespoke-wa-send-btn');
            var textarea = document.getElementById('bespoke-wa-input');
            var chips = widget.querySelectorAll('.bespoke-wa-chip');
            var phone = widget.getAttribute('data-phone');

            function openCard() {
                card.classList.add('active');
                card.setAttribute('aria-hidden', 'false');
                if (textarea) textarea.focus();
            }

            function closeCard() {
                card.classList.remove('active');
                card.setAttribute('aria-hidden', 'true');
            }

            trigger.addEventListener('click', function (e) {
                e.stopPropagation();
                if (card.classList.contains('active')) {
                    closeCard();
                } else {
                    openCard();
                }
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    closeCard();
                });
            }

            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    var msg = this.getAttribute('data-msg');
                    if (textarea) {
                        textarea.value = msg;
                    }
                });
            });

            function launchWhatsApp() {
                var text = textarea ? textarea.value.trim() : '';
                var targetUrl = 'https://wa.me/' + encodeURIComponent(phone);
                if (text) {
                    targetUrl += '?text=' + encodeURIComponent(text);
                }
                window.open(targetUrl, '_blank');
                closeCard();
            }

            if (sendBtn) {
                sendBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    launchWhatsApp();
                });
            }

            // Close on click outside
            document.addEventListener('click', function (e) {
                if (card.classList.contains('active') && !widget.contains(e.target)) {
                    closeCard();
                }
            });
        });
    })();
</script>
