<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true" 
    wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">{{ __('dashboard.create-property') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:ignore></button>
            </div>
            <div class="modal-body" wire:ignore.self>
                {{-- Progress Steps --}}
                <div class="steps-progress mb-4 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between align-items-center position-relative">
                        @for ($i = 1; $i <= $totalSteps; $i++)
                            <div class="step-item {{ $currentStep >= $i ? 'active' : '' }} {{ $currentStep > $i ? 'completed' : '' }}"
                                style="flex: 1; text-align: center; position: relative; z-index: 2;">
                                <div class="step-number {{ $currentStep == $i ? 'bg-primary' : ($currentStep > $i ? 'bg-success' : 'bg-secondary') }} text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 45px; height: 45px; margin-bottom: 8px; font-weight: bold; cursor: pointer;"
                                    wire:click="goToStep({{ $i }})" wire:loading.attr="disabled">
                                    @if ($currentStep > $i)
                                        <i class="fas fa-check"></i>
                                    @else
                                        {{ $i }}
                                    @endif
                                </div>
                                <div class="step-label small fw-bold">
                                    @if ($i == 1) {{ __('dashboard.user_data') }}
                                    @elseif ($i == 2) {{ __('dashboard.property_data') }}
                                    @elseif ($i == 3) {{ __('dashboard.building_data') }}
                                    @elseif ($i == 4) {{ __('dashboard.floors') }}
                                    @elseif ($i == 5) {{ __('dashboard.units') }}
                                    @elseif ($i == 6) {{ __('dashboard.facilities') }}
                                    @else {{ __('dashboard.services') }}
                                    @endif
                                </div>
                            </div>
                            @if ($i < $totalSteps)
                                <div class="step-line position-absolute" 
                                    style="height: 3px; background: {{ $currentStep > $i ? '#28a745' : '#dee2e6' }}; 
                                           width: calc((100% - {{ $totalSteps * 45 }}px) / {{ $totalSteps - 1 }}); 
                                           top: 22.5px; left: calc({{ ($i - 1) * (100 / $totalSteps) }}% + 22.5px); 
                                           z-index: 1;"></div>
                            @endif
                        @endfor
                    </div>
                </div>

                {{-- Step 1: User Data --}}
                @if ($currentStep == 1)
                    <div class="step-content">
                        <h5 class="mb-3">{{ __('dashboard.user_data') }}</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('user_name') is-invalid @enderror"
                                    wire:model="user_name" placeholder="{{ __('dashboard.name') }}">
                                @error('user_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.email') }}</label>
                                <input type="email" class="form-control @error('user_email') is-invalid @enderror"
                                    wire:model="user_email" placeholder="{{ __('dashboard.email') }}">
                                @error('user_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.phone') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('user_phone') is-invalid @enderror"
                                    wire:model="user_phone" placeholder="{{ __('dashboard.phone') }}">
                                @error('user_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.password') }} <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('user_password') is-invalid @enderror"
                                    wire:model="user_password" placeholder="{{ __('dashboard.password') }}">
                                @error('user_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.password_confirmation') }} <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('user_password_confirmation') is-invalid @enderror"
                                    wire:model="user_password_confirmation" placeholder="{{ __('dashboard.password_confirmation') }}">
                                @error('user_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Step 2: Property Data --}}
                @if ($currentStep == 2)
                    <div class="step-content">
                        <h5 class="mb-3">{{ __('dashboard.property_data') }}</h5>
                        @include('dashboard.properties.partials.property-form-fields', [
                            'countries' => $countries,
                            'governorates' => $governorates,
                            'cities' => $cities,
                            'admins' => $admins
                        ])
                    </div>
                @endif

                {{-- Step 3: Building Data --}}
                @if ($currentStep == 3)
                    <div class="step-content">
                        <h5 class="mb-3">{{ __('dashboard.building_data') }}</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.name_en') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('building_name.en') is-invalid @enderror"
                                    wire:model="building_name.en" placeholder="{{ __('dashboard.name_en') }}">
                                @error('building_name.en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.name_ar') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('building_name.ar') is-invalid @enderror"
                                    wire:model="building_name.ar" placeholder="{{ __('dashboard.name_ar') }}">
                                @error('building_name.ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('dashboard.type') }} <span class="text-danger">*</span></label>
                                <select class="form-select @error('building_type') is-invalid @enderror" wire:model="building_type">
                                    <option value="residential">{{ __('dashboard.residential') }}</option>
                                    <option value="administrative">{{ __('dashboard.administrative') }}</option>
                                    <option value="commercial">{{ __('dashboard.commercial') }}</option>
                                </select>
                                @error('building_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Step 4: Floors --}}
                @if ($currentStep == 4)
                    <div class="step-content">
                        <h5 class="mb-3">{{ __('dashboard.floors') }}</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('dashboard.floors_count') }} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" wire:model.live="floors_count" min="1" value="1">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('dashboard.floor_number') }}</th>
                                        <th>{{ __('dashboard.name_en') }}</th>
                                        <th>{{ __('dashboard.name_ar') }}</th>
                                        <th>{{ __('dashboard.type') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($floors as $index => $floor)
                                        <tr>
                                            <td>
                                                <input type="number" class="form-control form-control-sm"
                                                    wire:model="floors.{{ $index }}.floor_number" min="0">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="floors.{{ $index }}.name.en" placeholder="{{ __('dashboard.name_en') }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    wire:model="floors.{{ $index }}.name.ar" placeholder="{{ __('dashboard.name_ar') }}">
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm" wire:model="floors.{{ $index }}.type">
                                                    <option value="">{{ __('dashboard.choose') }}</option>
                                                    <option value="residential">{{ __('dashboard.residential') }}</option>
                                                    <option value="administrative">{{ __('dashboard.administrative') }}</option>
                                                    <option value="services">{{ __('dashboard.services') }}</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Step 5: Units --}}
                @if ($currentStep == 5)
                    <div class="step-content">
                        <h5 class="mb-3">{{ __('dashboard.units') }}</h5>
                        <p class="text-muted mb-3">{{ __('dashboard.units_per_floor_hint') }}</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('dashboard.floor') }}</th>
                                        <th>{{ __('dashboard.units_count') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($floors as $index => $floor)
                                        <tr>
                                            <td>
                                                <strong>{{ $floor['name'][app()->getLocale()] ?? $floor['name']['en'] ?? __('dashboard.floor') . ' ' . ($index + 1) }}</strong>
                                                <br><small class="text-muted">{{ __('dashboard.floor_number') }}: {{ $floor['floor_number'] }}</small>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    wire:model="units_per_floor.{{ $index }}" min="0" value="0">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Step 6: Facilities --}}
                @if ($currentStep == 6)
                    <div class="step-content">
                        <h5 class="mb-3">{{ __('dashboard.facilities') }}</h5>
                        <button type="button" class="btn btn-sm btn-primary mb-3" wire:click="addFacility">
                            <i class="fas fa-plus"></i> {{ __('dashboard.add_facility') }}
                        </button>
                        @if (count($facilities) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('dashboard.facility_type') }}</th>
                                            <th>{{ __('dashboard.number') }}</th>
                                            <th>{{ __('dashboard.is_available') }}</th>
                                            <th>{{ __('dashboard.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($facilities as $index => $facility)
                                            <tr>
                                                <td>
                                                    <select class="form-select form-select-sm" wire:model="facilities.{{ $index }}.facility_type_id">
                                                        <option value="">{{ __('dashboard.choose') }}</option>
                                                        @foreach ($facilityTypes as $type)
                                                            <option value="{{ $type->id }}">
                                                                {{ $type->getTranslation('name', app()->getLocale()) }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm"
                                                        wire:model="facilities.{{ $index }}.number" min="1" value="1">
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            wire:model="facilities.{{ $index }}.is_available">
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        wire:click="removeFacility({{ $index }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">{{ __('dashboard.no_facilities_added') }}</p>
                        @endif
                    </div>
                @endif

                {{-- Step 7: Service Providers --}}
                @if ($currentStep == 7)
                    <div class="step-content">
                        <h5 class="mb-3">{{ __('dashboard.service_providers') }}</h5>
                        <button type="button" class="btn btn-sm btn-primary mb-3" wire:click="addServiceProvider">
                            <i class="fas fa-plus"></i> {{ __('dashboard.add_service_provider') }}
                        </button>
                        @if (count($service_providers) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('dashboard.type') }}</th>
                                            <th>{{ __('dashboard.name') }}</th>
                                            <th>{{ __('dashboard.phone') }}</th>
                                            <th>{{ __('dashboard.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($service_providers as $index => $provider)
                                            <tr>
                                                <td>
                                                    <select class="form-select form-select-sm" wire:model="service_providers.{{ $index }}.type_id">
                                                        <option value="">{{ __('dashboard.choose') }}</option>
                                                        @foreach ($serviceProviderTypes as $type)
                                                            <option value="{{ $type->id }}">
                                                                {{ $type->getTranslation('display_name', app()->getLocale()) }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        wire:model="service_providers.{{ $index }}.name" placeholder="{{ __('dashboard.name') }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm"
                                                        wire:model="service_providers.{{ $index }}.phone" placeholder="{{ __('dashboard.phone') }}">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        wire:click="removeServiceProvider({{ $index }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">{{ __('dashboard.no_service_providers_added') }}</p>
                        @endif
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:ignore>
                    <i class="fas fa-times"></i> {{ __('dashboard.cancel') }}
                </button>
                @if ($currentStep > 1)
                    <button type="button" class="btn btn-secondary" wire:click="previousStep" wire:loading.attr="disabled">
                        <i class="fas fa-arrow-right"></i> {{ __('dashboard.previous') }}
                    </button>
                @endif
                @if ($currentStep < $totalSteps)
                    <button type="button" class="btn btn-primary" wire:click="nextStep" wire:loading.attr="disabled">
                        {{ __('dashboard.next') }} <i class="fas fa-arrow-left"></i>
                    </button>
                @else
                    <button type="button" class="btn btn-success" wire:click="submit" wire:loading.attr="disabled">
                        <i class="fas fa-check"></i> {{ __('dashboard.submit') }}
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>


