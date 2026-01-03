<x-createcomponent title="{{ __('dashboard.create-subscription-plan') }}" class="btn-success" size="modal-xl">
    <div class="row">
        <!-- الاسم بالإنجليزي -->
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name_en') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name.en') is-invalid @enderror" wire:model.live="name.en"
                placeholder="{{ __('dashboard.name_en') }}">
            @error('name.en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- الاسم بالعربي -->
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name_ar') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name.ar') is-invalid @enderror" wire:model.live="name.ar"
                placeholder="{{ __('dashboard.name_ar') }}">
            @error('name.ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- الوصف بالإنجليزي -->
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.description') }} (EN)</label>
            <textarea class="form-control @error('description.en') is-invalid @enderror" wire:model.live="description.en"
                rows="2" placeholder="Short description in English"></textarea>
            @error('description.en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- الوصف بالعربي -->
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.description') }} (AR)</label>
            <textarea class="form-control @error('description.ar') is-invalid @enderror" wire:model.live="description.ar"
                rows="2" placeholder="وصف مختصر بالعربي"></textarea>
            @error('description.ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- الحد الأقصى للوحدات -->
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.max_units') }} <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('max_units') is-invalid @enderror"
                wire:model.live="max_units" placeholder="50">
            @error('max_units')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- فترة التجربة -->
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.trial_days') }} <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('trial_days') is-invalid @enderror"
                wire:model.live="trial_days" placeholder="14">
            @error('trial_days')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- الحالة -->
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.status') }}</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" wire:model="status" id="isActiveSwitch">
                <label class="form-check-label" for="isActiveSwitch">
                    {{ $status ? __('dashboard.active') : __('dashboard.inactive') }}
                </label>
            </div>
        </div>

        <!-- المميزات بالإنجليزي -->
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.features') }} (EN) <small
                    class="text-muted">({{ __('dashboard.one_per_line') }})</small></label>
            <textarea class="form-control @error('features_en') is-invalid @enderror" wire:model.live="features_en" rows="4"
                placeholder="Up to 50 units&#10;Technical support&#10;Reports & Analytics"></textarea>
            @error('features_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- المميزات بالعربي -->
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.features') }} (AR) <small
                    class="text-muted">({{ __('dashboard.one_per_line') }})</small></label>
            <textarea class="form-control @error('features_ar') is-invalid @enderror" wire:model.live="features_ar" rows="4"
                placeholder="حتى 50 وحدة&#10;دعم فني&#10;تقارير وإحصائيات"></textarea>
            @error('features_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- عنوان التسعير حسب الدول -->
        <div class="col-12 mb-2 mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-primary mb-0">
                    <i class="fa-solid fa-globe me-1"></i>
                    {{ __('dashboard.country_pricing') }}
                </h5>
                <button type="button" class="btn btn-sm btn-outline-primary" wire:click="addPrice">
                    <i class="fa-solid fa-plus me-1"></i>
                    {{ __('dashboard.add_country_price') }}
                </button>
            </div>
            <hr class="mt-2">
            @error('prices')
                <div class="alert alert-danger py-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- أسعار الدول -->
        @foreach ($prices as $index => $price)
            <div class="col-12 mb-3" wire:key="price-{{ $index }}">
                <div class="card border shadow-none mb-0">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <span class="fw-bold">
                            <i class="fa-solid fa-flag me-1"></i>
                            {{ __('dashboard.country_price') }} #{{ $index + 1 }}
                        </span>
                        @if (count($prices) > 1)
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                wire:click="removePrice({{ $index }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        @endif
                    </div>
                    <div class="card-body py-3">
                        <div class="row">
                            <!-- اختيار الدولة -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">{{ __('dashboard.country') }} <span
                                        class="text-danger">*</span></label>
                                <select
                                    class="form-select @error('prices.' . $index . '.country_id') is-invalid @enderror"
                                    wire:model.live="prices.{{ $index }}.country_id">
                                    <option value="">{{ __('dashboard.select_country') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->getTranslation('name', app()->getLocale()) }}
                                            ({{ $country->currency_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('prices.' . $index . '.country_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- التسعير الشهري -->
                            <div class="col-12 mb-2">
                                <small class="text-primary fw-bold">
                                    <i class="fa-solid fa-calendar-day me-1"></i>
                                    {{ __('dashboard.monthly_pricing') }}
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.first_year_price') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('prices.' . $index . '.monthly_price_initial') is-invalid @enderror"
                                    wire:model.live="prices.{{ $index }}.monthly_price_initial"
                                    placeholder="500.00">
                                @error('prices.' . $index . '.monthly_price_initial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.renewal_price') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('prices.' . $index . '.monthly_price_renewal') is-invalid @enderror"
                                    wire:model.live="prices.{{ $index }}.monthly_price_renewal"
                                    placeholder="450.00">
                                @error('prices.' . $index . '.monthly_price_renewal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- التسعير السنوي -->
                            <div class="col-12 mb-2">
                                <small class="text-success fw-bold">
                                    <i class="fa-solid fa-calendar-days me-1"></i>
                                    {{ __('dashboard.yearly_pricing') }}
                                </small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.first_year_price') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('prices.' . $index . '.yearly_price_initial') is-invalid @enderror"
                                    wire:model.live="prices.{{ $index }}.yearly_price_initial"
                                    placeholder="5000.00">
                                @error('prices.' . $index . '.yearly_price_initial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.renewal_price') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('prices.' . $index . '.yearly_price_renewal') is-invalid @enderror"
                                    wire:model.live="prices.{{ $index }}.yearly_price_renewal"
                                    placeholder="4500.00">
                                @error('prices.' . $index . '.yearly_price_renewal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- سعر الوحدة الإضافية -->
                            <div class="col-12 mb-2">
                                <small class="text-warning fw-bold">
                                    <i class="fa-solid fa-plus-circle me-1"></i>
                                    {{ __('dashboard.extra_unit_price') }}
                                </small>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label">{{ __('dashboard.monthly') }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('prices.' . $index . '.extra_unit_price_monthly') is-invalid @enderror"
                                    wire:model.live="prices.{{ $index }}.extra_unit_price_monthly"
                                    placeholder="10.00">
                                @error('prices.' . $index . '.extra_unit_price_monthly')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-2">
                                <label class="form-label">{{ __('dashboard.yearly') }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('prices.' . $index . '.extra_unit_price_yearly') is-invalid @enderror"
                                    wire:model.live="prices.{{ $index }}.extra_unit_price_yearly"
                                    placeholder="100.00">
                                @error('prices.' . $index . '.extra_unit_price_yearly')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-createcomponent>
