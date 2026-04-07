(function () {
    function initWelcomeBooking() {
        const configElement = document.getElementById('welcome-booking-config');
        if (!configElement) return;

        let bookingConfig = {};
        try {
            bookingConfig = JSON.parse(configElement.textContent);
        } catch (error) {
            console.error('Invalid booking config JSON', error);
            return;
        }

        let currentBookingData = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const MODE_LABELS = { video: 'Video Call', call: 'Phone Call', in_person: 'In-Person' };

        function showError(msg) {
            const el = document.getElementById('bookingFormError');
            if (!el) return;
            el.textContent = msg;
            el.classList.remove('hidden');
        }

        function hideError() {
            document.getElementById('bookingFormError')?.classList.add('hidden');
        }

        function resetSubmitBtn() {
            const btn = document.getElementById('bookingSubmitBtn');
            const text = document.getElementById('bookingSubmitText');
            if (btn) btn.disabled = false;
            if (text) text.textContent = 'Proceed to Payment';
        }

        async function confirmPayment(payload) {
            const res = await fetch(bookingConfig.paymentCallbackUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    Accept: 'application/json',
                },
                body: JSON.stringify(payload),
            });

            const data = await res.json();
            document.getElementById('paymentOverlay')?.classList.remove('active');

            const bookingRef = data.booking_reference || payload.booking_reference;
            const message = data.message || 'Your counsellor will reach out shortly.';
            const bookingRefEl = document.getElementById('successBookingRef');
            const messageEl = document.getElementById('successMessage');
            if (bookingRefEl) bookingRefEl.textContent = bookingRef;
            if (messageEl) messageEl.textContent = message;
            document.getElementById('successOverlay')?.classList.add('active');
        }

        function openRazorpay(data) {
            if (!window.Razorpay) {
                showError('Payment gateway failed to load. Please refresh and try again.');
                resetSubmitBtn();
                return;
            }

            const options = {
                key: data.razorpay_key_id,
                amount: data.amount,
                currency: data.currency,
                name: 'Prafulta Care',
                description: `Session Booking — ${data.booking_reference}`,
                order_id: data.razorpay_order_id,
                prefill: data.prefill,
                theme: { color: '#0a5f53' },
                handler: async (response) => {
                    await confirmPayment({
                        booking_reference: data.booking_reference,
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_signature: response.razorpay_signature,
                        simulated: false,
                    });
                },
                modal: {
                    ondismiss: function () {
                        resetSubmitBtn();
                    },
                },
            };

            new window.Razorpay(options).open();
        }

        function openSimulatedPayment(data) {
            const amountEl = document.getElementById('paymentAmountDisplay');
            const refEl = document.getElementById('paymentBookingRef');
            const progressEl = document.getElementById('paymentProgressBar');
            const statusEl = document.getElementById('paymentStatusText');
            const payBtn = document.getElementById('payNowBtn');

            if (amountEl) amountEl.textContent = `₹${Number(data.amount).toLocaleString('en-IN')}`;
            if (refEl) refEl.textContent = data.booking_reference;
            if (progressEl) progressEl.style.width = '0%';
            if (statusEl) statusEl.textContent = 'Click "Pay Now" to complete payment';
            if (payBtn) {
                payBtn.disabled = false;
                payBtn.classList.remove('opacity-60');
                payBtn.innerHTML = 'Pay Now';
            }

            document.getElementById('paymentOverlay')?.classList.add('active');
        }

        window.openBookingModal = function (counsellor) {
            document.getElementById('bookingCounsellorName').textContent = `with ${counsellor.name}`;
            document.getElementById('bookingSpec').textContent = counsellor.specializations;
            document.getElementById('bookingDuration').textContent = `${counsellor.session_duration} min session`;
            document.getElementById('bookingPrice').textContent = `₹${Number(counsellor.session_price).toLocaleString('en-IN')}`;
            document.getElementById('bf_counsellor_id').value = counsellor.counsellor_id;

            const modeSelect = document.getElementById('bf_session_mode');
            modeSelect.innerHTML = '';
            (counsellor.session_modes || ['video', 'call', 'in_person']).forEach((mode) => {
                const option = document.createElement('option');
                option.value = mode;
                option.textContent = MODE_LABELS[mode] || mode;
                modeSelect.appendChild(option);
            });

            const now = new Date();
            now.setHours(now.getHours() + 1);
            document.getElementById('bf_scheduled_at').min = now.toISOString().slice(0, 16);

            if (bookingConfig.prefill?.name) document.getElementById('bf_name').value = bookingConfig.prefill.name;
            if (bookingConfig.prefill?.email) document.getElementById('bf_email').value = bookingConfig.prefill.email;
            if (bookingConfig.prefill?.phone) document.getElementById('bf_phone').value = bookingConfig.prefill.phone;

            hideError();
            resetSubmitBtn();
            document.getElementById('bookingOverlay')?.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        window.submitBooking = async function (event) {
            event.preventDefault();
            hideError();

            const btn = document.getElementById('bookingSubmitBtn');
            const submitText = document.getElementById('bookingSubmitText');
            if (btn) btn.disabled = true;
            if (submitText) submitText.innerHTML = '<span class="pf-spinner"></span> Submitting...';

            const form = document.getElementById('bookingForm');
            const body = Object.fromEntries(new FormData(form));

            try {
                const res = await fetch(bookingConfig.bookStoreUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        Accept: 'application/json',
                    },
                    body: JSON.stringify(body),
                });

                const data = await res.json();
                if (!res.ok) {
                    const errors = data.errors || {};
                    const firstError = Object.values(errors)[0];
                    showError(Array.isArray(firstError) ? firstError[0] : data.message || 'Something went wrong.');
                    resetSubmitBtn();
                    return;
                }

                currentBookingData = data;
                document.getElementById('bookingOverlay')?.classList.remove('active');

                if (data.mode === 'razorpay' && data.razorpay_key_id) {
                    openRazorpay(data);
                } else {
                    openSimulatedPayment(data);
                }
            } catch (error) {
                showError('Network error. Please try again.');
                resetSubmitBtn();
            }
        };

        window.simulatePayment = async function () {
            const btn = document.getElementById('payNowBtn');
            const statusEl = document.getElementById('paymentStatusText');
            const progressEl = document.getElementById('paymentProgressBar');

            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-60');
                btn.innerHTML = '<span class="pf-spinner"></span> Processing...';
            }
            if (statusEl) statusEl.textContent = 'Processing your payment...';
            if (progressEl) progressEl.style.width = '100%';

            await new Promise((resolve) => setTimeout(resolve, 2600));
            await confirmPayment({
                booking_reference: currentBookingData.booking_reference,
                simulated: true,
            });
        };

        window.closeAllModals = function () {
            document.getElementById('bookingOverlay')?.classList.remove('active');
            document.getElementById('paymentOverlay')?.classList.remove('active');
            document.getElementById('successOverlay')?.classList.remove('active');
            document.body.style.overflow = '';
            resetSubmitBtn();
        };

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') window.closeAllModals();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWelcomeBooking);
    } else {
        initWelcomeBooking();
    }
})();
