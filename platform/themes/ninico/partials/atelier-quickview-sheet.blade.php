{{-- Product Quick-View Bottom Sheet (Mobile) / Luxury Modal (Desktop) --}}
<div id="wb-quickview-backdrop" class="wb-sheet-backdrop" hidden aria-hidden="true">
    <div id="wb-quickview-sheet" class="wb-sheet wb-sheet--travertine" role="dialog" aria-modal="true" aria-labelledby="wb-qv-title">
        <div class="wb-sheet__header wb-sheet__header--travertine">
            <span class="wb-sheet__spacer"></span>
            <span class="wb-sheet__handle wb-sheet__handle--dark"></span>
            <button type="button" onclick="window.closeAtelierQuickView && window.closeAtelierQuickView()" aria-label="{{ __('Close Quick View') }}" class="wb-sheet__close wb-sheet__close--dark">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="wb-quickview-body" class="wb-quickview-body"></div>
    </div>
</div>
