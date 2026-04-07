<div id="bookingOverlay" class="pf-overlay" onclick="if(event.target===this) closeAllModals()">
    <div class="pf-modal">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-2xl" style="font-family:'Fraunces',serif">Book a Session</h2>
                <p id="bookingCounsellorName" class="mt-1 text-sm text-[color:var(--pf-muted)]"></p>
            </div>
            <button onclick="closeAllModals()" class="rounded-lg p-1.5 text-[color:var(--pf-muted)] transition hover:bg-slate-100" aria-label="Close">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div id="bookingCounsellorInfo" class="mt-4 rounded-xl border border-[color:var(--pf-border)] bg-[color:var(--pf-brand-soft)]/30 p-3">
            <div class="flex items-center justify-between">
                <div>
                    <p id="bookingSpec" class="text-xs text-[color:var(--pf-muted)]"></p>
                    <p id="bookingDuration" class="mt-0.5 text-xs text-[color:var(--pf-muted)]"></p>
                </div>
                <p id="bookingPrice" class="text-lg font-bold text-[color:var(--pf-brand-dark)]"></p>
            </div>
        </div>

        <form id="bookingForm" class="mt-5 space-y-4" onsubmit="submitBooking(event)">
            <input type="hidden" id="bf_counsellor_id" name="counsellor_id">

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="pf-label" for="bf_name">Full Name *</label>
                    <input class="pf-input" type="text" id="bf_name" name="name" required autocomplete="name">
                </div>
                <div>
                    <label class="pf-label" for="bf_phone">Phone *</label>
                    <input class="pf-input" type="tel" id="bf_phone" name="phone" required autocomplete="tel">
                </div>
            </div>

            <div>
                <label class="pf-label" for="bf_email">Email Address *</label>
                <input class="pf-input" type="email" id="bf_email" name="email" required autocomplete="email">
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="pf-label" for="bf_service_type">Service Type *</label>
                    <select class="pf-input" id="bf_service_type" name="service_type" required>
                        <option value="regular_counselling">Regular Counselling</option>
                        <option value="occupational_therapy">Occupational Therapy</option>
                        <option value="remedial_therapy">Remedial Therapy</option>
                    </select>
                </div>
                <div>
                    <label class="pf-label" for="bf_session_mode">Session Mode *</label>
                    <select class="pf-input" id="bf_session_mode" name="session_mode" required></select>
                </div>
            </div>

            <div>
                <label class="pf-label" for="bf_scheduled_at">Preferred Date & Time *</label>
                <input class="pf-input" type="datetime-local" id="bf_scheduled_at" name="scheduled_at" required>
            </div>

            <div id="bookingFormError" class="pf-form-error hidden"></div>

            <button type="submit" id="bookingSubmitBtn" class="pf-btn-primary w-full">
                <span id="bookingSubmitText">Proceed to Payment</span>
            </button>
        </form>
    </div>
</div>

<div id="paymentOverlay" class="pf-overlay" onclick="if(event.target===this) closeAllModals()">
    <div class="pf-modal pf-sim-gateway">
        <div class="flex justify-end">
            <button onclick="closeAllModals()" class="rounded-lg p-1.5 text-[color:var(--pf-muted)] transition hover:bg-slate-100" aria-label="Close">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="mt-2">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[color:var(--pf-brand-soft)]">
                <svg class="h-8 w-8 text-[color:var(--pf-brand-dark)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <p class="mt-4 text-sm font-semibold text-[color:var(--pf-muted)]">Payment Gateway</p>
            <p class="pf-sim-amount mt-1" id="paymentAmountDisplay">₹0</p>
            <p class="mt-1 text-xs text-[color:var(--pf-muted)]">Booking: <span id="paymentBookingRef">—</span></p>
        </div>

        <div class="pf-sim-progress mt-6">
            <div class="pf-sim-progress-bar" id="paymentProgressBar"></div>
        </div>
        <p class="mt-3 text-sm text-[color:var(--pf-muted)]" id="paymentStatusText">Processing your payment…</p>

        <button id="payNowBtn" class="pf-btn-primary mt-6 w-full" onclick="simulatePayment()">Pay Now</button>
    </div>
</div>

<div id="successOverlay" class="pf-overlay" onclick="if(event.target===this) closeAllModals()">
    <div class="pf-modal text-center">
        <div class="pf-checkmark-circle">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h2 class="mt-5 text-2xl" style="font-family:'Fraunces',serif">Payment Successful!</h2>
        <p class="mt-2 text-sm text-[color:var(--pf-muted)]">Your session has been booked and confirmed.</p>

        <div class="mt-5 rounded-xl border border-green-200 bg-green-50 p-4 text-left">
            <p class="text-xs font-semibold uppercase tracking-wide text-green-600">Booking Confirmed</p>
            <p class="mt-1 text-lg font-bold text-green-800" id="successBookingRef">—</p>
            <p class="mt-1 text-sm text-green-700" id="successMessage">Your counsellor will reach out shortly to confirm the schedule.</p>
        </div>

        <button onclick="closeAllModals()" class="pf-btn-primary mt-6 w-full">Done</button>
    </div>
</div>
