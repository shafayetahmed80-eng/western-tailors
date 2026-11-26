(function () {
    'use strict';

    const FABRICS = {
        wool: {
            name: 'Italian Super 150s Wool',
            gsm: '260 GSM',
            origin: 'Biella, Italy',
            garment: 'Bespoke Suits',
            texture: 'Fluid four-season drape with natural crease recovery.'
        },
        velvet: {
            name: 'Royal Silk Velvet',
            gsm: '340 GSM',
            origin: 'Como, Italy',
            garment: 'Royal Tuxedos',
            texture: 'Deep luminous evening pile with structured architectural hold.'
        },
        silk: {
            name: 'Raw Mulberry Silk',
            gsm: '210 GSM',
            origin: 'Rajshahi & Varanasi',
            garment: 'Groom Sherwanis',
            texture: 'Regal handloom slub weave engineered to carry heirloom Zardozi.'
        },
        linen: {
            name: 'Irish Heritage Linen',
            gsm: '280 GSM',
            origin: 'Belfast, Ireland',
            garment: 'Gurkha Trousers',
            texture: 'Crisp, breathable tropical weave that softens gracefully with wear.'
        }
    };

    let selectedQuickViewSize = 'Custom Bespoke';
    let toastTimer = null;

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    window.showAtelierToast = function (msg) {
        const toast = document.getElementById('wb-toast');
        const txt = document.getElementById('wb-toast-text');
        if (!toast || !txt) return;
        txt.textContent = msg;
        toast.hidden = false;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () {
            toast.hidden = true;
        }, 2800);
    };

    window.scrollToAtelierSection = function (sectionId) {
        const target = document.getElementById(sectionId);
        if (!target) return false;
        const offset = window.innerWidth >= 1200 ? 78 : 64;
        const top = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
        return true;
    };

    window.closeAtelierNavDrawer = function () {
        if (window.jQuery) {
            window.jQuery('.tpsideinfo').removeClass('tp-sidebar-opened');
            window.jQuery('.body-overlay').removeClass('opened');
        }
    };

    /* ---------------------------------------------------------------------
       FABRIC SWATCH SELECTOR
       --------------------------------------------------------------------- */
    window.selectAtelierFabric = function (key) {
        const data = FABRICS[key];
        if (!data) return;

        document.querySelectorAll('.wb-swatch-btn').forEach(function (btn) {
            btn.classList.toggle('is-selected', btn.getAttribute('data-wb-fabric') === key);
        });

        const setEl = function (id, val) {
            const el = document.getElementById(id);
            if (el) el.textContent = val;
        };
        setEl('wb-fab-name', data.name);
        setEl('wb-fab-gsm', data.gsm);
        setEl('wb-fab-origin', data.origin);
        setEl('wb-fab-garment', data.garment);
        setEl('wb-fab-texture', data.texture);
    };

    /* ---------------------------------------------------------------------
       CURATED MASTERPIECES FILTERING
       --------------------------------------------------------------------- */
    window.filterAtelierProducts = function (group) {
        const normalized = String(group || 'all').toLowerCase();

        document.querySelectorAll('.wb-cat-pill').forEach(function (pill) {
            pill.classList.toggle('is-active', pill.getAttribute('data-wb-filter') === normalized);
        });

        document.querySelectorAll('#wb-product-grid .wb-prod-card').forEach(function (card) {
            const cardGroup = card.getAttribute('data-wb-group');
            const visible = normalized === 'all' || cardGroup === normalized;
            card.hidden = !visible;
        });
    };

    window.selectAtelierCategory = function (group) {
        window.filterAtelierProducts(group);
        window.scrollToAtelierSection('masterpieces');
    };

    /* ---------------------------------------------------------------------
       SHEET OPEN / CLOSE HELPERS
       --------------------------------------------------------------------- */
    function openBackdropSheet(backdropId) {
        const backdrop = document.getElementById(backdropId);
        if (!backdrop) return;
        backdrop.hidden = false;
        backdrop.setAttribute('aria-hidden', 'false');
        requestAnimationFrame(function () {
            backdrop.classList.add('is-open');
        });
    }

    function closeBackdropSheet(backdropId) {
        const backdrop = document.getElementById(backdropId);
        if (!backdrop) return;
        backdrop.classList.remove('is-open');
        backdrop.setAttribute('aria-hidden', 'true');
        setTimeout(function () {
            backdrop.hidden = true;
        }, 260);
    }

    /* ---------------------------------------------------------------------
       PRODUCT QUICK-VIEW SHEET
       --------------------------------------------------------------------- */
    window.openAtelierQuickView = function (itemId) {
        const list = window.ATELIER_MASTERPIECES || [];
        const p = list.find(function (item) {
            return String(item.id) === String(itemId);
        });
        if (!p) return;

        selectedQuickViewSize = 'Custom Bespoke';
        const sizes = ['S', 'M', 'L', 'XL', 'Custom Bespoke'];
        const body = document.getElementById('wb-quickview-body');
        if (!body) return;

        const addActionHtml = p.productId && p.addToCartUrl && !p.hasVariations
            ? '<button type="button" onclick="window.addAtelierItemToBag(\'' + escapeHtml(p.id) + '\')" class="wb-qv-btn-emerald">Add to Bag</button>'
            : '<a href="' + escapeHtml(p.url) + '" class="wb-qv-btn-emerald">Select Options</a>';

        body.innerHTML =
            '<div class="wb-qv-media">' +
                '<img src="' + escapeHtml(p.imageLarge || p.image) + '" alt="' + escapeHtml(p.name) + '" onerror="this.onerror=null;this.src=\'' + escapeHtml(p.fallback) + '\';" />' +
                '<span class="wb-qv-media__badge">' + escapeHtml(p.fabric) + '</span>' +
            '</div>' +
            '<div class="wb-qv-head">' +
                '<div>' +
                    '<p class="wb-eyebrow wb-eyebrow--brass mb-0">' + escapeHtml(p.category) + '</p>' +
                    '<h3 id="wb-qv-title" class="wb-qv-title">' + escapeHtml(p.name) + '</h3>' +
                '</div>' +
                '<span class="wb-qv-price">' + escapeHtml(p.priceFormatted) + '</span>' +
            '</div>' +
            '<p class="wb-qv-desc">' + escapeHtml(p.desc) + '</p>' +
            '<div>' +
                '<p class="wb-label" style="color:#5C635F;">Select Size</p>' +
                '<div class="wb-qv-sizes">' +
                    sizes.map(function (s) {
                        const cls = s === 'Custom Bespoke' ? 'wb-qv-size-pill is-selected' : 'wb-qv-size-pill';
                        return '<button type="button" onclick="window.pickAtelierQuickViewSize(this, \'' + s + '\')" class="' + cls + '">' + s + '</button>';
                    }).join('') +
                '</div>' +
            '</div>' +
            '<div class="wb-qv-actions">' +
                addActionHtml +
                '<button type="button" data-garment="' + escapeHtml(p.name) + '" onclick="window.bookFitFromQuickView(this)" class="wb-btn-brass" style="padding:14px 16px;">Book Custom Fit</button>' +
            '</div>' +
            '<div class="text-center">' +
                '<a href="' + escapeHtml(p.url) + '" class="wb-qv-link">View Full Piece Details &rarr;</a>' +
            '</div>';

        openBackdropSheet('wb-quickview-backdrop');
    };

    window.pickAtelierQuickViewSize = function (btn, size) {
        selectedQuickViewSize = size;
        document.querySelectorAll('.wb-qv-size-pill').forEach(function (el) {
            el.classList.remove('is-selected');
        });
        btn.classList.add('is-selected');
    };

    window.bookFitFromQuickView = function (btn) {
        const garment = btn ? btn.getAttribute('data-garment') : '';
        window.closeAtelierQuickView();
        window.openAtelierFitting(garment);
    };

    window.closeAtelierQuickView = function () {
        closeBackdropSheet('wb-quickview-backdrop');
    };

    window.addAtelierItemToBag = function (itemId) {
        const list = window.ATELIER_MASTERPIECES || [];
        const p = list.find(function (item) {
            return String(item.id) === String(itemId);
        });
        if (!p || !p.productId || !p.addToCartUrl) return;

        const cfg = window.atelierConfig || {};
        const formData = new FormData();
        formData.append('id', String(p.productId));
        formData.append('qty', '1');

        fetch(p.addToCartUrl, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': cfg.csrfToken || ''
            },
            body: formData
        })
            .then(function (res) { return res.json(); })
            .then(function (json) {
                if (json && json.error) {
                    window.location.href = p.url;
                    return;
                }
                window.closeAtelierQuickView();
                window.showAtelierToast(p.name + ' (' + selectedQuickViewSize + ') added to Atelier Bag');

                if (window.siteConfig && window.siteConfig.ajaxCart && window.jQuery) {
                    window.jQuery.ajax({
                        url: window.siteConfig.ajaxCart,
                        method: 'GET',
                        success: function (cartRes) {
                            if (cartRes && cartRes.data) {
                                window.jQuery('.tpcartinfo .tpcart__product').html(cartRes.data.html);
                                window.jQuery('.header-cart .tp-product-count').text(cartRes.data.count);
                            }
                        }
                    });
                }
            })
            .catch(function () {
                window.location.href = p.url;
            });
    };

    /* ---------------------------------------------------------------------
       PRIVATE FITTING BOOKING SHEET
       --------------------------------------------------------------------- */
    window.openAtelierFitting = function (garmentName) {
        const form = document.getElementById('wb-fitting-form');
        const receipt = document.getElementById('wb-fitting-receipt');
        const select = document.getElementById('wb-fit-garment');
        const dateInput = document.getElementById('wb-fit-date');
        const errEl = document.getElementById('wb-fit-error');

        if (form) form.hidden = false;
        if (receipt) receipt.hidden = true;
        if (errEl) errEl.hidden = true;

        if (dateInput && !dateInput.value) {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            dateInput.value = tomorrow.toISOString().split('T')[0];
        }

        if (garmentName && select) {
            let matched = false;
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].value.toLowerCase() === String(garmentName).toLowerCase()) {
                    select.selectedIndex = i;
                    matched = true;
                    break;
                }
            }
            if (!matched) {
                select.add(new Option(garmentName, garmentName, true, true));
            }
        }

        openBackdropSheet('wb-fitting-backdrop');
    };

    window.closeAtelierFitting = function () {
        closeBackdropSheet('wb-fitting-backdrop');
    };

    window.selectAtelierTimeSlot = function (btn, slot) {
        const input = document.getElementById('wb-fit-timeslot');
        if (input) input.value = slot;
        document.querySelectorAll('.wb-time-pill').forEach(function (el) {
            el.classList.remove('is-selected');
        });
        btn.classList.add('is-selected');
    };

    /* ---------------------------------------------------------------------
       ATELIER FILM MODAL
       --------------------------------------------------------------------- */
    window.openAtelierFilm = function () {
        const modal = document.getElementById('wb-film-backdrop');
        if (!modal) return;
        modal.hidden = false;
        modal.setAttribute('aria-hidden', 'false');
    };

    window.closeAtelierFilm = function () {
        const modal = document.getElementById('wb-film-backdrop');
        if (!modal) return;
        modal.hidden = true;
        modal.setAttribute('aria-hidden', 'true');
    };

    /* ---------------------------------------------------------------------
       DOM INITIALIZATION & AJAX HANDLERS
       --------------------------------------------------------------------- */
    document.addEventListener('DOMContentLoaded', function () {
        const cfg = window.atelierConfig || {};

        // Backdrop click-outside to close
        ['wb-fitting-backdrop', 'wb-quickview-backdrop'].forEach(function (id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.addEventListener('click', function (e) {
                if (e.target === el) {
                    closeBackdropSheet(id);
                }
            });
        });

        const filmEl = document.getElementById('wb-film-backdrop');
        if (filmEl) {
            filmEl.addEventListener('click', function (e) {
                if (e.target === filmEl) {
                    window.closeAtelierFilm();
                }
            });
        }

        // Escape key closes open modals
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                window.closeAtelierFitting();
                window.closeAtelierQuickView();
                window.closeAtelierFilm();
            }
        });

        // Smooth in-page scroll & category triggers on Homepage
        document.querySelectorAll('[data-wb-scroll]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                const targetId = link.getAttribute('data-wb-scroll');
                if (targetId && document.getElementById(targetId)) {
                    e.preventDefault();
                    window.scrollToAtelierSection(targetId);
                }
            });
        });

        document.querySelectorAll('[data-wb-cat]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                const cat = link.getAttribute('data-wb-cat');
                if (cat && document.getElementById('masterpieces')) {
                    e.preventDefault();
                    window.selectAtelierCategory(cat);
                }
            });
        });

        document.querySelectorAll('[data-wb-drawer-scroll]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                const targetId = link.getAttribute('data-wb-drawer-scroll');
                if (targetId && document.getElementById(targetId)) {
                    e.preventDefault();
                    window.closeAtelierNavDrawer();
                    window.scrollToAtelierSection(targetId);
                }
            });
        });

        document.querySelectorAll('[data-wb-drawer-cat]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                const cat = link.getAttribute('data-wb-drawer-cat');
                if (cat && document.getElementById('masterpieces')) {
                    e.preventDefault();
                    window.closeAtelierNavDrawer();
                    window.selectAtelierCategory(cat);
                }
            });
        });

        // Private Fitting Form AJAX Submit -> Saves to Admin Contacts + Receipt + WhatsApp
        const fittingForm = document.getElementById('wb-fitting-form');
        if (fittingForm) {
            fittingForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const submitBtn = document.getElementById('wb-fit-submit');
                const errEl = document.getElementById('wb-fit-error');
                if (errEl) errEl.hidden = true;

                const name = (document.getElementById('wb-fit-name').value || '').trim();
                const phone = (document.getElementById('wb-fit-phone').value || '').trim();
                const dateVal = (document.getElementById('wb-fit-date').value || '').trim();

                if (name.length < 2 || phone.length < 6 || !dateVal) {
                    if (errEl) {
                        errEl.textContent = 'Please enter your name, WhatsApp/phone number, and preferred date.';
                        errEl.hidden = false;
                    }
                    return;
                }

                const formData = new FormData(fittingForm);
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Confirming...';
                }

                fetch(cfg.fittingUrl || '/ajax/atelier-fitting', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': cfg.csrfToken || ''
                    },
                    body: formData
                })
                    .then(function (res) { return res.json(); })
                    .then(function (json) {
                        if (!json || json.error || !json.data) {
                            throw new Error((json && json.message) || 'Could not confirm booking. Please try again.');
                        }
                        const d = json.data;
                        const rowsEl = document.getElementById('wb-receipt-rows');
                        if (rowsEl) {
                            rowsEl.innerHTML =
                                '<div class="wb-receipt-row"><span class="wb-receipt-row__k">Ref Code</span><span class="wb-receipt-row__v wb-brass-text">' + escapeHtml(d.ref) + '</span></div>' +
                                '<div class="wb-receipt-row"><span class="wb-receipt-row__k">Client</span><span class="wb-receipt-row__v">' + escapeHtml(d.name) + '</span></div>' +
                                '<div class="wb-receipt-row"><span class="wb-receipt-row__k">WhatsApp</span><span class="wb-receipt-row__v">' + escapeHtml(d.phone) + '</span></div>' +
                                '<div class="wb-receipt-row"><span class="wb-receipt-row__k">Garment</span><span class="wb-receipt-row__v">' + escapeHtml(d.garment) + '</span></div>' +
                                '<div class="wb-receipt-row"><span class="wb-receipt-row__k">Fabric</span><span class="wb-receipt-row__v">' + escapeHtml(d.fabric) + '</span></div>' +
                                '<div class="wb-receipt-row"><span class="wb-receipt-row__k">Schedule</span><span class="wb-receipt-row__v">' + escapeHtml(d.schedule) + '</span></div>';
                        }
                        const waBtn = document.getElementById('wb-receipt-wa-btn');
                        if (waBtn && d.whatsapp_url) {
                            waBtn.href = d.whatsapp_url;
                        }
                        fittingForm.hidden = true;
                        document.getElementById('wb-fitting-receipt').hidden = false;
                    })
                    .catch(function (err) {
                        if (errEl) {
                            errEl.textContent = err.message || 'Unable to submit reservation right now.';
                            errEl.hidden = false;
                        }
                    })
                    .finally(function () {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Confirm Private Fitting';
                        }
                    });
            });
        }

        // Footer Newsletter Form AJAX Submit
        const nlForm = document.getElementById('wb-newsletter-form');
        if (nlForm) {
            nlForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const emailInput = document.getElementById('wb-newsletter-email');
                const email = emailInput ? emailInput.value.trim() : '';
                if (!email || email.indexOf('@') === -1) {
                    window.showAtelierToast('Please enter a valid email address');
                    return;
                }

                const fd = new FormData();
                fd.append('email', email);

                fetch(cfg.newsletterUrl || '/ajax/atelier-newsletter', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': cfg.csrfToken || ''
                    },
                    body: fd
                })
                    .then(function (res) { return res.json(); })
                    .then(function (json) {
                        if (emailInput) emailInput.value = '';
                        window.showAtelierToast((json && json.message) || 'Welcome to the Western Bespoke Private Archive');
                    })
                    .catch(function () {
                        window.showAtelierToast('Welcome to the Western Bespoke Private Archive');
                    });
            });
        }
    });
})();
