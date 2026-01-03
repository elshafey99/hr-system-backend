<x-updatecomponent title="{{ __('dashboard.update_property_role') }}">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.display_name_ar') }}</label>
            <input type="text" class="form-control @error('display_name.ar') is-invalid @enderror"
                wire:model="display_name.ar" placeholder="{{ __('dashboard.display_name_ar') }}">
            @error('display_name.ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.display_name_en') }}</label>
            <input type="text" class="form-control @error('display_name.en') is-invalid @enderror"
                wire:model="display_name.en" placeholder="{{ __('dashboard.display_name_en') }}">
            @error('display_name.en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name_key') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name_key') is-invalid @enderror" wire:model="name_key"
                placeholder="{{ __('dashboard.name_key_placeholder') }}">
            <small class="text-muted">{{ __('dashboard.name_key_hint') }}</small>
            @error('name_key')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.type') }} <span class="text-danger">*</span></label>
            <select class="form-control @error('type') is-invalid @enderror" wire:model="type">
                <option value="">{{ __('dashboard.select_type') }}</option>
                <option value="owner">{{ __('dashboard.owner') }}</option>
                <option value="responsible">{{ __('dashboard.responsible') }}</option>
                <option value="user">{{ __('dashboard.user') }}</option>
                <option value="treasurer">{{ __('dashboard.treasurer') }}</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</x-updatecomponent>
