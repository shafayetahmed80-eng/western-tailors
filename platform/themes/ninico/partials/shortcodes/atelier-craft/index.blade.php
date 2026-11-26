<section id="crafted" class="wb-section wb-section--emerald wb-crafted">
    <div class="container">
        <div class="wb-crafted__grid">
            {{-- Left Column: Interactive Mill Swatches & Provenance Card --}}
            <div class="wb-crafted__swatches-col">
                <p class="wb-eyebrow">{{ __('Tactile Provenance') }}</p>
                <h2 class="wb-section-title wb-section-title--light">
                    CRAFTED <span class="wb-italic-brass">BY HAND</span>
                </h2>
                <p class="wb-crafted__lead">
                    {{ __('Tap a mill swatch below to inspect origin, GSM weight, and recommended tailored silhouette.') }}
                </p>

                {{-- 4 Tappable Circular Swatches --}}
                <div class="wb-swatch-row" role="tablist" aria-label="{{ __('Fabric Swatches') }}">
                    <button type="button" data-wb-fabric="wool" onclick="window.selectAtelierFabric('wool')" class="wb-swatch-btn is-selected">
                        <span class="wb-swatch-ring">
                            <span class="wb-swatch-fill wb-swatch-wool"></span>
                        </span>
                        <span class="wb-swatch-label">Italian<br>Wool</span>
                    </button>

                    <button type="button" data-wb-fabric="velvet" onclick="window.selectAtelierFabric('velvet')" class="wb-swatch-btn">
                        <span class="wb-swatch-ring">
                            <span class="wb-swatch-fill wb-swatch-velvet"></span>
                        </span>
                        <span class="wb-swatch-label">Royal<br>Velvet</span>
                    </button>

                    <button type="button" data-wb-fabric="silk" onclick="window.selectAtelierFabric('silk')" class="wb-swatch-btn">
                        <span class="wb-swatch-ring">
                            <span class="wb-swatch-fill wb-swatch-silk"></span>
                        </span>
                        <span class="wb-swatch-label">Mulberry<br>Silk</span>
                    </button>

                    <button type="button" data-wb-fabric="linen" onclick="window.selectAtelierFabric('linen')" class="wb-swatch-btn">
                        <span class="wb-swatch-ring">
                            <span class="wb-swatch-fill wb-swatch-linen"></span>
                        </span>
                        <span class="wb-swatch-label">Irish<br>Linen</span>
                    </button>
                </div>

                {{-- Live Swatch Specification Card --}}
                <div class="wb-spec-card">
                    <div class="wb-spec-card__head">
                        <h3 id="wb-fab-name" class="wb-spec-card__title">Italian Super 150s Wool</h3>
                        <span id="wb-fab-gsm" class="wb-spec-card__gsm">260 GSM</span>
                    </div>
                    <div class="wb-spec-card__grid">
                        <div>
                            <p class="wb-spec-card__key">{{ __('Origin') }}</p>
                            <p id="wb-fab-origin" class="wb-spec-card__val">Biella, Italy</p>
                        </div>
                        <div>
                            <p class="wb-spec-card__key">{{ __('Recommended') }}</p>
                            <p id="wb-fab-garment" class="wb-spec-card__val wb-spec-card__val--brass">Bespoke Suits</p>
                        </div>
                        <div class="wb-spec-card__full">
                            <p class="wb-spec-card__key">{{ __('Texture & Drape') }}</p>
                            <p id="wb-fab-texture" class="wb-spec-card__desc">Fluid four-season drape with natural crease recovery.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: 4-Stage Bespoke Timeline --}}
            <div class="wb-crafted__timeline-col">
                <p class="wb-eyebrow mb-4">{{ __('The 4-Stage Bespoke Journey') }}</p>
                <div class="wb-timeline">
                    <div class="wb-timeline__step">
                        <span class="wb-timeline__dot">01</span>
                        <h4 class="wb-timeline__title">{{ __('Consultation') }}</h4>
                        <p class="wb-timeline__desc">{{ __('Fabric selection, lapel architecture & personal styling.') }}</p>
                    </div>

                    <div class="wb-timeline__step">
                        <span class="wb-timeline__dot">02</span>
                        <h4 class="wb-timeline__title">{{ __('32 Measurements') }}</h4>
                        <p class="wb-timeline__desc">{{ __('Anatomical posture profiling drafted onto your personal pattern.') }}</p>
                    </div>

                    <div class="wb-timeline__step">
                        <span class="wb-timeline__dot">03</span>
                        <h4 class="wb-timeline__title">{{ __('Basted Fitting') }}</h4>
                        <p class="wb-timeline__desc">{{ __('Hand-basted canvas sculpted directly to your shoulders & waist.') }}</p>
                    </div>

                    <div class="wb-timeline__step wb-timeline__step--final">
                        <span class="wb-timeline__dot wb-timeline__dot--brass">04</span>
                        <h4 class="wb-timeline__title wb-timeline__title--brass">{{ __('Final Delivery') }}</h4>
                        <p class="wb-timeline__desc">{{ __('Hand-sewn horn buttons, monogrammed lining & garment bag.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
