<x-updatecomponent title="{{ __('dashboard.update-floor') }}">
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
            <select class="form-select @error('building_id') is-invalid @enderror" wire:model="building_id"
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
            <label class="form-label">{{ __('dashboard.name_en') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name.en') is-invalid @enderror"
                wire:model.live="name.en" placeholder="{{ __('dashboard.name_en') }}">
            @error('name.en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name_ar') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name.ar') is-invalid @enderror"
                wire:model.live="name.ar" placeholder="{{ __('dashboard.name_ar') }}">
            @error('name.ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.floor_number') }} <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('floor_number') is-invalid @enderror"
                wire:model.live="floor_number" placeholder="{{ __('dashboard.floor_number') }}" min="0">
            <small class="text-muted">{{ __('dashboard.floor_number_hint') }}</small>
            @error('floor_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.type') }}</label>
            <select class="form-select @error('type') is-invalid @enderror" wire:model="type">
                <option value="">{{ __('dashboard.choose') }}</option>
                <option value="residential">{{ __('dashboard.residential') }}</option>
                <option value="administrative">{{ __('dashboard.administrative') }}</option>
                <option value="services">{{ __('dashboard.services') }}</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</x-updatecomponent>

