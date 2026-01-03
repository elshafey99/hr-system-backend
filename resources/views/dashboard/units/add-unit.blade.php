<x-createcomponent title="{{ __('dashboard.create-unit') }}" class="btn-success">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.property') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('property_id') is-invalid @enderror" wire:model.live="property_id">
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($properties as $p)
                    <option value="{{ $p->id }}">
                        {{ is_array($p->name) ? ($p->name['en'] ?? reset($p->name)) : $p->name }}</option>
                @endforeach
            </select>
            @error('property_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.building') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('building_id') is-invalid @enderror" wire:model.live="building_id"
                @if (!$property_id) disabled @endif>
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($buildings as $building)
                    <option value="{{ $building->id }}">
                        {{ $building->getTranslation('name', app()->getLocale()) }}</option>
                @endforeach
            </select>
            @error('building_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.floor') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('floor_id') is-invalid @enderror" wire:model="floor_id"
                @if (!$building_id) disabled @endif>
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($floors as $floor)
                    <option value="{{ $floor->id }}">
                        {{ $floor->getTranslation('name', app()->getLocale()) }}</option>
                @endforeach
            </select>
            @error('floor_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.unit_type') }}</label>
            <select class="form-select @error('unit_type_id') is-invalid @enderror" wire:model="unit_type_id">
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($unitTypes as $type)
                    <option value="{{ $type->id }}">
                        {{ $type->getTranslation('display_name', app()->getLocale()) }}</option>
                @endforeach
            </select>
            @error('unit_type_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.unit_number') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('unit_number') is-invalid @enderror"
                wire:model.live="unit_number" placeholder="{{ __('dashboard.unit_number') }}">
            @error('unit_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.live="name"
                placeholder="{{ __('dashboard.name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.area') }} (m²)</label>
            <input type="number" step="0.01" class="form-control @error('area_sqm') is-invalid @enderror"
                wire:model.live="area_sqm" placeholder="{{ __('dashboard.area') }}">
            @error('area_sqm')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.status') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                <option value="vacant">{{ __('dashboard.vacant') }}</option>
                <option value="occupied">{{ __('dashboard.occupied') }}</option>
                <option value="reserved">{{ __('dashboard.reserved') }}</option>
                <option value="maintenance">{{ __('dashboard.maintenance') }}</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</x-createcomponent>

