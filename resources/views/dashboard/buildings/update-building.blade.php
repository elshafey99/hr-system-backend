<x-updatecomponent title="{{ __('dashboard.update-building') }}">
    <div class="row">
        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">{{ __('dashboard.name_en') }}</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="name.en" placeholder="{{ __('dashboard.name_en') }}" class="form-control @error('name.en') is-invalid @enderror">
                 @error('name.en') 
                  <div class="invalid-feedback">{{ $message }}</div> 
                 @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">{{ __('dashboard.name_ar') }}</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="name.ar" placeholder="{{ __('dashboard.name_ar') }}" class="form-control @error('name.ar') is-invalid @enderror">
                @error('name.ar') 
                 <div class="invalid-feedback">{{ $message }}</div> 
                @enderror
            </div>
        </div>

        <div class="col-md-6 mb-3 mt-2">
            <label class="form-label">{{ __('dashboard.property') }}</label>
            <select class="form-select @error('property_id') is-invalid @enderror" wire:model="property_id">
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach($properties as $p)
                    <option value="{{ $p->id }}">{{ is_array($p->name) ? ($p->name['en'] ?? reset($p->name)) : $p->name }}</option>
                @endforeach
            </select>
            @error('property_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6 mb-3 mt-2">
            <label class="form-label">{{ __('dashboard.type') }}</label>
            <select class="form-select @error('type') is-invalid @enderror" wire:model="type">
                <option value="">{{ __('dashboard.choose') }}</option>
                <option value="residential">{{ __('dashboard.residential') }}</option>
                <option value="administrative">{{ __('dashboard.administrative') }}</option>
                <option value="commercial">{{ __('dashboard.commercial') }}</option>
            </select>
            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

    </div>

</x-updatecomponent>
