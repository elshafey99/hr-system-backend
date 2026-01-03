<x-show title="{{ __('dashboard.plan_details') }}">
    @php
        $locale = app()->getLocale();
        $planName = $plan?->getTranslation('name', $locale) ?? ($plan?->name ?? '-');
        $planDescription = $plan?->getTranslation('description', $locale) ?? null;
        $planFeatures = $plan?->getTranslation('features', $locale) ?? [];
    @endphp

    <div class="plan-details-container">

        {{-- Plan Header Card --}}
        <div class="card plan-header-card shadow-sm border-0 mb-3">
            <div class="card-body p-3">
                <div class="row align-items-start">
                    <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
                        <div class="d-flex align-items-start">
                            <div class="plan-icon-wrapper me-3">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h4 class="mb-1 fw-bold plan-title">{{ $planName }}</h4>
                                @if ($planDescription)
                                    <p class="text-muted mb-0 plan-description">{{ $planDescription }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="d-flex justify-content-md-end">
                            <div class="status-badge-wrapper">
                                <span
                                    class="status-badge {{ $plan?->is_active ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas {{ $plan?->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $plan?->is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-icon-container">
                                <div class="info-icon bg-primary-soft">
                                    <i class="fas fa-building text-primary"></i>
                                </div>
                            </div>
                            <div class="info-content">
                                <small class="info-label">{{ __('dashboard.max_units') }}</small>
                                <div class="info-value">{{ $plan?->max_units ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <div class="info-icon-container">
                                <div class="info-icon bg-info-soft">
                                    <i class="fas fa-calendar-check text-info"></i>
                                </div>
                            </div>
                            <div class="info-content">
                                <small class="info-label">{{ __('dashboard.trial_days') }}</small>
                                <div class="info-value">{{ $plan?->trial_days ?? '-' }} {{ __('dashboard.days') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features Card --}}
        <div class="card features-card shadow-sm border-0 mb-3">
            <div class="card-header bg-white border-bottom py-2">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-star text-warning me-2"></i>
                    {{ __('dashboard.features') }}
                </h5>
            </div>
            <div class="card-body p-3">
                @if (is_array($planFeatures) && count($planFeatures) > 0)
                    <div class="row g-2">
                        @foreach ($planFeatures as $feature)
                            <div class="col-md-6">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="fas fa-check-circle text-success"></i>
                                    </div>
                                    <span class="feature-text">{{ $feature }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-inbox text-muted mb-2" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="text-muted mb-0">{{ __('dashboard.no-features') }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Pricing Card --}}
        <div class="card pricing-card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-2">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-globe text-primary me-2"></i>
                    {{ __('dashboard.country_pricing') }}
                </h5>
            </div>
            <div class="card-body p-3">
                @if ($plan?->planPrices && $plan->planPrices->count() > 0)
                    <div class="row g-3">
                        @foreach ($plan->planPrices as $price)
                            <div class="col-lg-6">
                                <div class="pricing-box">
                                    <div class="pricing-header">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="d-flex align-items-center">
                                                <span class="country-flag me-2">🌍</span>
                                                <h6 class="mb-0 fw-bold">
                                                    {{ $price?->country?->getTranslation('name', $locale) ?? ($price?->country?->name ?? 'N/A') }}
                                                </h6>
                                            </div>
                                            <span
                                                class="badge bg-primary">{{ $price?->country?->currency_code ?? '' }}</span>
                                        </div>
                                    </div>

                                    <div class="pricing-content">
                                        {{-- Monthly Pricing --}}
                                        <div class="pricing-section mb-2">
                                            <div class="pricing-label">
                                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                                <span class="fw-semibold">{{ __('dashboard.monthly') }}</span>
                                            </div>
                                            <div class="pricing-values mt-2">
                                                <div class="price-item">
                                                    <div class="price-badge initial">
                                                        <small
                                                            class="price-label">{{ __('dashboard.first_year') }}</small>
                                                        <div class="price-value">
                                                            {{ number_format($price->monthly_price_initial ?? 0, 2) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-arrow">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                                <div class="price-item">
                                                    <div class="price-badge renewal">
                                                        <small
                                                            class="price-label">{{ __('dashboard.renewal') }}</small>
                                                        <div class="price-value">
                                                            {{ number_format($price->monthly_price_renewal ?? 0, 2) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Yearly Pricing --}}
                                        <div class="pricing-section">
                                            <div class="pricing-label">
                                                <i class="fas fa-calendar text-success me-2"></i>
                                                <span class="fw-semibold">{{ __('dashboard.yearly') }}</span>
                                            </div>
                                            <div class="pricing-values mt-2">
                                                <div class="price-item">
                                                    <div class="price-badge initial">
                                                        <small
                                                            class="price-label">{{ __('dashboard.first_year') }}</small>
                                                        <div class="price-value">
                                                            {{ number_format($price->yearly_price_initial ?? 0, 2) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="price-arrow">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                                <div class="price-item">
                                                    <div class="price-badge renewal">
                                                        <small
                                                            class="price-label">{{ __('dashboard.renewal') }}</small>
                                                        <div class="price-value">
                                                            {{ number_format($price->yearly_price_renewal ?? 0, 2) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Extra Unit Pricing --}}
                                        @if ($price->extra_unit_price_monthly > 0 || $price->extra_unit_price_yearly > 0)
                                            <div class="extra-pricing mt-3 pt-3 border-top">
                                                <small class="text-muted d-block mb-2">
                                                    <i class="fas fa-plus-circle me-1"></i>
                                                    {{ __('dashboard.extra_unit_price') ?? 'Extra Unit Price' }}
                                                </small>
                                                <div class="d-flex gap-3">
                                                    @if ($price->extra_unit_price_monthly > 0)
                                                        <div class="extra-price-item">
                                                            <small
                                                                class="text-muted">{{ __('dashboard.monthly') }}</small>
                                                            <div class="fw-bold text-primary">
                                                                {{ number_format($price->extra_unit_price_monthly, 2) }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($price->extra_unit_price_yearly > 0)
                                                        <div class="extra-price-item">
                                                            <small
                                                                class="text-muted">{{ __('dashboard.yearly') }}</small>
                                                            <div class="fw-bold text-success">
                                                                {{ number_format($price->extra_unit_price_yearly, 2) }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-dollar-sign text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="text-muted mb-0">{{ __('dashboard.no_prices') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .plan-details-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Plan Header Card */
        .plan-header-card {
            background: white;
            border-radius: 12px !important;
            overflow: hidden;
        }

        .plan-header-card .card-body {
            background: white;
        }

        .plan-icon-wrapper {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
            flex-shrink: 0;
        }

        .plan-title {
            color: #667eea;
            font-size: 1.5rem;
            line-height: 1.3;
        }

        .plan-description {
            font-size: 0.9rem;
            color: #6c757d;
            line-height: 1.5;
        }

        /* Status Badge */
        .status-badge-wrapper {
            display: inline-block;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .status-badge i {
            font-size: 1rem;
        }

        .status-active {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-color: #b1dfbb;
        }

        .status-inactive {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-color: #f1b0b7;
        }

        .status-badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Info Boxes */
        .info-box {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 3px solid #667eea;
            transition: all 0.3s ease;
            gap: 0.875rem;
        }

        .info-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            background: #f1f3f5;
        }

        .info-icon-container {
            flex-shrink: 0;
        }

        .info-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .info-content {
            flex-grow: 1;
        }

        .info-label {
            display: block;
            color: #6c757d;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #212529;
            line-height: 1.2;
        }

        .bg-primary-soft {
            background-color: rgba(102, 126, 234, 0.12);
        }

        .bg-info-soft {
            background-color: rgba(23, 162, 184, 0.12);
        }

        /* Badges */
        .badge-success-soft {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .badge-secondary-soft {
            background-color: #e2e3e5;
            color: #383d41;
            border: 1px solid #d6d8db;
        }

        /* Features Card */
        .features-card {
            border-radius: 15px !important;
        }

        .feature-item {
            display: flex;
            align-items: center;
            padding: 0.625rem;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .feature-icon {
            font-size: 1.25rem;
            margin-right: 0.75rem;
            min-width: 25px;
        }

        .feature-text {
            font-size: 0.95rem;
            color: #495057;
        }

        /* Pricing Card */
        .pricing-card {
            border-radius: 15px !important;
        }

        .pricing-box {
            background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1.125rem;
            height: 100%;
            transition: all 0.3s ease;
        }

        .pricing-box:hover {
            border-color: #667eea;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
            transform: translateY(-3px);
        }

        .country-flag {
            font-size: 1.5rem;
        }

        .pricing-section {
            padding: 0.75rem;
            background: white;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .pricing-label {
            display: flex;
            align-items: center;
            font-size: 1rem;
            color: #495057;
        }

        .pricing-values {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .price-item {
            flex: 1;
        }

        .price-badge {
            padding: 0.5rem;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .price-badge.initial {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #b1dfbb;
        }

        .price-badge.renewal {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffd93d;
        }

        .price-badge:hover {
            transform: scale(1.05);
        }

        .price-label {
            display: block;
            font-size: 0.7rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .price-value {
            font-size: 1.1rem;
            font-weight: bold;
            color: #212529;
        }

        .price-arrow {
            color: #6c757d;
            font-size: 1rem;
            opacity: 0.5;
        }

        .extra-pricing {
            background: #f8f9fa;
            padding: 0.75rem;
            border-radius: 8px;
        }

        .extra-price-item {
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .plan-icon-wrapper {
                width: 48px;
                height: 48px;
                font-size: 1.4rem;
            }

            .plan-title {
                font-size: 1.25rem;
            }

            .plan-description {
                font-size: 0.85rem;
            }

            .status-badge {
                font-size: 0.85rem;
                padding: 0.4rem 1rem;
            }

            .info-box {
                padding: 0.875rem;
            }

            .info-icon {
                width: 38px;
                height: 38px;
                font-size: 1.1rem;
            }

            .info-value {
                font-size: 1.1rem;
            }

            .pricing-values {
                flex-direction: column;
                gap: 0.75rem;
            }

            .price-arrow {
                transform: rotate(90deg);
            }
        }

        /* Card Headers */
        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.5s ease-out;
        }
    </style>
</x-show>
