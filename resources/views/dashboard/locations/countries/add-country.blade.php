<x-createcomponent title="{{ __('dashboard.add_country') }}">
    <div class="row mt-4">
        <!-- English Name -->
        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">{{ __('dashboard.name_en') }}</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="name.en" placeholder="{{ __('dashboard.name_en') }}" class="form-control">
            </div>
            @include('dashboard.partials.error', ['property' => 'name.en'])
        </div>

        <!-- Arabic Name -->
        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">{{ __('dashboard.name_ar') }}</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="name.ar" placeholder="{{ __('dashboard.name_ar') }}"
                    class="form-control">
            </div>
            @include('dashboard.partials.error', ['property' => 'name.ar'])
        </div>

        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">{{ __('dashboard.code') }}</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="code" placeholder="{{ __('dashboard.code') }}" class="form-control">
            </div>
            @include('dashboard.partials.error', ['property' => 'code'])
        </div>

        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">{{ __('dashboard.phone-code') }}</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="phone_code" placeholder="{{ __('dashboard.phone-code') }}"
                    class="form-control">
            </div>
            @include('dashboard.partials.error', ['property' => 'phone_code'])
        </div>

        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">{{ __('dashboard.currency_code') }}</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="currency_code" placeholder="{{ __('dashboard.currency_code') }}"
                    class="form-control">
            </div>
            @include('dashboard.partials.error', ['property' => 'currency_code'])
        </div>
            <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.image') }}</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror"
                wire:model="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            @if ($image)
                <div class="mt-2">
                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" 
                        class="rounded" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @endif
        </div>

    </div>
</x-createcomponent>
