<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Prafulta Care') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
    <script src="{{ asset('js/welcome-booking.js') }}" defer></script>
    <style>
        /* Fallback modal styles to ensure popups work even if Vite CSS cache is stale */
        .pf-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;
            background: rgba(15, 30, 28, 0.55);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .pf-overlay.active { opacity: 1; pointer-events: auto; }
        .pf-modal {
            background: var(--pf-card, #fff);
            border: 1px solid var(--pf-border, #d8e8e4);
            border-radius: 1.25rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.18);
            width: 95%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px) scale(0.97);
            transition: transform 0.3s ease;
            padding: 1.75rem;
        }
        .pf-overlay.active .pf-modal { transform: translateY(0) scale(1); }
        .pf-sim-gateway { text-align: center; }
        .pf-sim-gateway .pf-sim-amount {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--pf-brand-dark, #0a5f53);
            font-family: 'Fraunces', serif;
        }
        .pf-sim-progress {
            height: 6px;
            border-radius: 999px;
            background: var(--pf-border, #d8e8e4);
            overflow: hidden;
            margin-top: 1.25rem;
        }
        .pf-sim-progress-bar {
            height: 100%;
            width: 0;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--pf-brand, #0a8f7a) 0%, #0f6f7f 100%);
            transition: width 2.5s ease;
        }
        .pf-checkmark-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--pf-brand, #0a8f7a) 0%, #0f6f7f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        .pf-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--pf-muted, #4f6b67);
            margin-bottom: 0.3rem;
        }
        .pf-input {
            width: 100%;
            padding: 0.6rem 0.85rem;
            border: 1px solid var(--pf-border, #d8e8e4);
            border-radius: 0.75rem;
            font-size: 0.875rem;
            background: #fff;
            outline: none;
            font-family: inherit;
        }
        .pf-input:focus {
            border-color: var(--pf-brand, #0a8f7a);
            box-shadow: 0 0 0 3px rgba(10, 143, 122, 0.12);
        }
        .pf-form-error {
            font-size: 0.75rem;
            color: #dc2626;
            margin-top: 0.25rem;
        }
        .pf-spinner {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid #fff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: pfSpin 0.6s linear infinite;
        }
        @keyframes pfSpin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    @include('home.partials.header')

    <main class="pb-16">
        @include('home.partials.hero')
        @include('home.partials.services')
        @include('home.partials.specialists')
        @include('home.partials.training-preview')
        @include('home.partials.bottom-cta')
    </main>

    @include('home.partials.booking-modals')

    @php
        $welcomeBookingConfig = [
            'bookStoreUrl' => route('book.store'),
            'paymentCallbackUrl' => route('book.payment.callback'),
            'prefill' => [
                'name' => optional(auth()->user())->name,
                'email' => optional(auth()->user())->email,
                'phone' => optional(auth()->user())->phone ?: '',
            ],
        ];
    @endphp

    <script id="welcome-booking-config" type="application/json">@json($welcomeBookingConfig)</script>
</body>
</html>
