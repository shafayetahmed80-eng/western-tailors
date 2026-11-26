{{-- Private Fitting Bottom Sheet (Mobile) / Luxury Modal (Desktop) --}}
<div id="wb-fitting-backdrop" class="wb-sheet-backdrop" hidden aria-hidden="true">
    <div id="wb-fitting-sheet" class="wb-sheet wb-sheet--emerald" role="dialog" aria-modal="true" aria-labelledby="wb-fitting-title">
        {{-- Sticky Sheet Header --}}
        <div class="wb-sheet__header wb-sheet__header--emerald">
            <div class="wb-sheet__handle"></div>
            <div class="wb-sheet__header-row">
                <div>
                    <p class="wb-eyebrow mb-1">{{ __('Private Concierge') }}</p>
                    <h3 id="wb-fitting-title" class="wb-sheet__title">{{ __('Book Private Fitting') }}</h3>
                </div>
                <button type="button" onclick="window.closeAtelierFitting && window.closeAtelierFitting()" class="wb-sheet__close" aria-label="{{ __('Close Fitting Sheet') }}">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Booking Form --}}
        <form id="wb-fitting-form" class="wb-fitting-form" novalidate>
            @csrf
            <div class="wb-field">
                <label for="wb-fit-garment" class="wb-label">{{ __('Garment Selection') }}</label>
                <select id="wb-fit-garment" name="garment" class="wb-input no-nice-select">
                    <option value="Charcoal Double-Breasted Suit">{{ __('Charcoal Double-Breasted Suit') }}</option>
                    <option value="Ivory Zardozi Groom Sherwani">{{ __('Ivory Zardozi Groom Sherwani') }}</option>
                    <option value="Royal Midnight Velvet Tuxedo">{{ __('Royal Midnight Velvet Tuxedo') }}</option>
                    <option value="Midnight Embroidered Prince Coat">{{ __('Midnight Embroidered Prince Coat') }}</option>
                    <option value="Sand Beige Gurkha Trousers">{{ __('Sand Beige Gurkha Trousers') }}</option>
                    <option value="Heritage Navy Bandhgala Suit">{{ __('Heritage Navy Bandhgala Suit') }}</option>
                    <option value="Private Home Measurement">{{ __('Private Home Measurement') }}</option>
                    <option value="Full Wardrobe Consultation">{{ __('Full Wardrobe Consultation') }}</option>
                </select>
            </div>

            <div class="wb-field">
                <label for="wb-fit-fabric" class="wb-label">{{ __('Fabric Preference') }}</label>
                <select id="wb-fit-fabric" name="fabric" class="wb-input no-nice-select">
                    <option value="Italian Super 150s Wool (Biella)">{{ __('Italian Super 150s Wool (Biella)') }}</option>
                    <option value="Royal Silk Velvet (Como)">{{ __('Royal Silk Velvet (Como)') }}</option>
                    <option value="Raw Mulberry Silk & Zardozi">{{ __('Raw Mulberry Silk & Zardozi') }}</option>
                    <option value="Irish Heritage Linen">{{ __('Irish Heritage Linen') }}</option>
                    <option value="Decide at Atelier with Head Cutter">{{ __('Decide at Atelier with Head Cutter') }}</option>
                </select>
            </div>

            <div class="wb-field">
                <label for="wb-fit-date" class="wb-label">{{ __('Preferred Date') }}</label>
                <input id="wb-fit-date" name="preferred_date" type="date" required class="wb-input" />
            </div>

            <div class="wb-field">
                <label class="wb-label">{{ __('Time Slot') }}</label>
                <input type="hidden" id="wb-fit-timeslot" name="time_slot" value="12:00 PM" />
                <div class="wb-time-grid">
                    <button type="button" onclick="window.selectAtelierTimeSlot(this, '12:00 PM')" class="wb-time-pill is-selected">12:00 PM</button>
                    <button type="button" onclick="window.selectAtelierTimeSlot(this, '04:00 PM')" class="wb-time-pill">04:00 PM</button>
                    <button type="button" onclick="window.selectAtelierTimeSlot(this, '07:30 PM')" class="wb-time-pill">07:30 PM</button>
                </div>
            </div>

            <div class="wb-field-row">
                <div class="wb-field">
                    <label for="wb-fit-name" class="wb-label">{{ __('Your Name') }}</label>
                    <input id="wb-fit-name" name="name" type="text" required placeholder="Tariq Rahman" class="wb-input" />
                </div>
                <div class="wb-field">
                    <label for="wb-fit-phone" class="wb-label">{{ __('Phone / WhatsApp') }}</label>
                    <input id="wb-fit-phone" name="phone" type="tel" required placeholder="+880 17XX..." class="wb-input" />
                </div>
            </div>

            <p id="wb-fit-error" class="wb-form-error" hidden></p>

            <button id="wb-fit-submit" type="submit" class="wb-btn-brass w-100">
                {{ __('Confirm Private Fitting') }}
            </button>
        </form>

        {{-- Luxury Booking Confirmation Receipt --}}
        <div id="wb-fitting-receipt" class="wb-fitting-receipt" hidden>
            <div class="wb-receipt-card">
                <div class="wb-receipt-card__check">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
                <p class="wb-eyebrow mb-1">{{ __('Reservation Confirmed') }}</p>
                <h4 class="wb-receipt-card__title">{{ __('We Await You') }}</h4>

                <div id="wb-receipt-rows" class="wb-receipt-rows"></div>

                <p class="wb-receipt-card__note">
                    {{ __('Saved to our Banani & Dhanmondi Concierge desk. You may also notify our Master Tailor instantly via WhatsApp.') }}
                </p>

                <div class="wb-receipt-actions">
                    <a id="wb-receipt-wa-btn" href="#" target="_blank" rel="noopener noreferrer" class="wb-btn-brass w-100 mb-2">
                        {{ __('Send Confirmation on WhatsApp') }} &rarr;
                    </a>
                    <button type="button" onclick="window.closeAtelierFitting && window.closeAtelierFitting()" class="wb-btn-outline-brass w-100">
                        {{ __('Return to Atelier') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
