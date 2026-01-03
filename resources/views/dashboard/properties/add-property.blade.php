<x-createcomponent title="{{ __('dashboard.create-property') }}" class="btn-success">
    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.live="name"
                placeholder="{{ __('dashboard.name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.code') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('code') is-invalid @enderror" wire:model.live="code"
                placeholder="{{ __('dashboard.code') }}">
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.property_number') }}</label>
            <input type="text" class="form-control @error('property_number') is-invalid @enderror"
                wire:model.live="property_number" placeholder="{{ __('dashboard.property_number') }}">
            @error('property_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.country') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('country_id') is-invalid @enderror" wire:model.live="country_id">
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}">
                        {{ $country->name ?? ($country->title ?? ($country->name_en ?? $country->name_ar)) }}</option>
                @endforeach
            </select>
            @error('country_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.governorate') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('governorate_id') is-invalid @enderror" wire:model.live="governorate_id"
                @if (!$country_id) disabled @endif>
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($governorates as $g)
                    <option value="{{ $g->id }}">{{ $g->name ?? $g->title }}</option>
                @endforeach
            </select>
            @error('governorate_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.city') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('city_id') is-invalid @enderror" wire:model="city_id"
                @if (!$governorate_id) disabled @endif>
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($cities as $c)
                    <option value="{{ $c->id }}">{{ $c->name ?? $c->title }}</option>
                @endforeach
            </select>
            @error('city_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 mb-3">
            <label class="form-label">{{ __('dashboard.specs') }}</label>

            <div class="row g-2">
                <div class="col-md-6">
                    <label class="form-label">{{ __('dashboard.finishing_in_english') }}</label>
                    <input type="text" class="form-control @error('specs.finishing.en') is-invalid @enderror"
                        wire:model.live="specs.finishing.en" placeholder="{{ __('dashboard.finishing_in_english') }}">
                    @error('specs.finishing.en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('dashboard.finishing_in_arabic') }}</label>
                    <input type="text" class="form-control @error('specs.finishing.ar') is-invalid @enderror"
                        wire:model.live="specs.finishing.ar" placeholder="{{ __('dashboard.finishing_in_arabic') }}">
                    @error('specs.finishing.ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ __('dashboard.facade_in_english') }}</label>
                    <input type="text" class="form-control @error('specs.facade.en') is-invalid @enderror"
                        wire:model.live="specs.facade.en" placeholder="{{ __('dashboard.facade_in_english') }}">
                    @error('specs.facade.en')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('dashboard.facade_in_arabic') }}</label>
                    <input type="text" class="form-control @error('specs.facade.ar') is-invalid @enderror"
                        wire:model.live="specs.facade.ar" placeholder="{{ __('dashboard.facade_in_arabic') }}">
                    @error('specs.facade.ar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">{{ __('dashboard.floors') }}</label>
                    <input type="number" class="form-control @error('specs.floors') is-invalid @enderror"
                        wire:model.live="specs.floors" placeholder="{{ __('dashboard.floors') }}">
                    @error('specs.floors')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('dashboard.rooms') }}</label>
                    <input type="number" class="form-control @error('specs.rooms') is-invalid @enderror"
                        wire:model.live="specs.rooms" placeholder="{{ __('dashboard.rooms') }}">
                    @error('specs.rooms')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('dashboard.bathrooms') }}</label>
                    <input type="number" class="form-control @error('specs.bathrooms') is-invalid @enderror"
                        wire:model.live="specs.bathrooms">
                    @error('specs.bathrooms')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mt-3">

                    <div class="col-md-6">
                        <input type="checkbox" wire:model.live="specs.garden" class="form-check-input"
                            id="garden">
                        <label for="garden">{{ __('dashboard.Has Garden') }}</label>
                    </div>

                    <div class="col-md-6">
                        <input type="checkbox" wire:model.live="specs.swimming_pool" class="form-check-input"
                            id="swimming_pool">
                        <label for="swimming_pool">{{ __('dashboard.Has Swimming Pool') }}</label>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.address_street') }}</label>
            <input type="text" class="form-control @error('address_street') is-invalid @enderror"
                wire:model.live="address_street" placeholder="{{ __('dashboard.address_street') }}">
            @error('address_street')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.district_code') }}</label>
            <input type="text" class="form-control @error('district_code') is-invalid @enderror"
                wire:model.live="district_code" placeholder="{{ __('dashboard.district_code') }}">
            @error('district_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.area_land') }}</label>
            <input type="number" step="0.01" class="form-control @error('area_land') is-invalid @enderror"
                wire:model.live="area_land" placeholder="{{ __('dashboard.area_land') }}">
            @error('area_land')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.area_built') }}</label>
            <input type="number" step="0.01" class="form-control @error('area_built') is-invalid @enderror"
                wire:model.live="area_built" placeholder="{{ __('dashboard.area_built') }}">
            @error('area_built')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.boundaries') }}</label>
            <textarea class="form-control @error('boundaries') is-invalid @enderror" wire:model.live="boundaries" rows="2"
                placeholder="{{ __('dashboard.boundaries') }}"></textarea>
            @error('boundaries')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.residential_buildings_count') }}</label>
            <input type="number" class="form-control @error('residential_buildings_count') is-invalid @enderror"
                wire:model.live="residential_buildings_count"
                placeholder="{{ __('dashboard.residential_buildings_count') }}">
            @error('residential_buildings_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.administrative_buildings_count') }}</label>
            <input type="number" class="form-control @error('administrative_buildings_count') is-invalid @enderror"
                wire:model.live="administrative_buildings_count"
                placeholder="{{ __('dashboard.administrative_buildings_count') }}">
            @error('administrative_buildings_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.total_users_count') }}</label>
            <input type="number" class="form-control @error('total_users_count') is-invalid @enderror"
                wire:model.live="total_users_count" placeholder="{{ __('dashboard.total_users_count') }}">
            @error('total_users_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.commissioner_count') }}</label>
            <input type="number" class="form-control @error('commissioner_count') is-invalid @enderror"
                wire:model.live="commissioner_count" placeholder="{{ __('dashboard.commissioner_count') }}">
            @error('commissioner_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.treasurer_count') }}</label>
            <input type="number" class="form-control @error('treasurer_count') is-invalid @enderror"
                wire:model.live="treasurer_count" placeholder="{{ __('dashboard.treasurer_count') }}">
            @error('treasurer_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.union_member_count') }}</label>
            <input type="number" class="form-control @error('union_member_count') is-invalid @enderror"
                wire:model.live="union_member_count" placeholder="{{ __('dashboard.union_member_count') }}">
            @error('union_member_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.investors_count') }}</label>
            <input type="number" class="form-control @error('investors_count') is-invalid @enderror"
                wire:model.live="investors_count" placeholder="{{ __('dashboard.investors_count') }}">
            @error('investors_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.owners_count') }}</label>
            <input type="number" class="form-control @error('owners_count') is-invalid @enderror"
                wire:model.live="owners_count" placeholder="{{ __('dashboard.owners_count') }}">
            @error('owners_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.tenants_count') }}</label>
            <input type="number" class="form-control @error('tenants_count') is-invalid @enderror"
                wire:model.live="tenants_count" placeholder="{{ __('dashboard.tenants_count') }}">
            @error('tenants_count')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.bank_name') }}</label>
            <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                wire:model.live="bank_name" placeholder="{{ __('dashboard.bank_name') }}">
            @error('bank_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.bank_account_number') }}</label>
            <input type="text" class="form-control @error('bank_account_number') is-invalid @enderror"
                wire:model.live="bank_account_number" placeholder="{{ __('dashboard.bank_account_number') }}">
            @error('bank_account_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.bank_iban') }}</label>
            <input type="text" class="form-control @error('bank_iban') is-invalid @enderror"
                wire:model.live="bank_iban" placeholder="{{ __('dashboard.bank_iban') }}">
            @error('bank_iban')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.approved_by') }}</label>
            <select class="form-select" wire:model="approved_by_admin_id">
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($admins as $admin)
                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.status') }}</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" wire:model="is_active" id="isActiveSwitch">
                <label class="form-check-label" for="isActiveSwitch">
                    {{ $is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                </label>
            </div>
        </div>

    </div>
</x-createcomponent>
