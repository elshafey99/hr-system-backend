<x-createcomponent title="{{ __('dashboard.create-property-member') }}" class="btn-success">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.property') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('property_id') is-invalid @enderror" wire:model="property_id">
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
            <label class="form-label">{{ __('dashboard.user') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('user_id') is-invalid @enderror" wire:model="user_id">
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email ?? $user->phone ?? '-' }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.role') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('role_id') is-invalid @enderror" wire:model="role_id">
                <option value="">{{ __('dashboard.choose') }}</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">
                        {{ $role->getTranslation('display_name', app()->getLocale()) }}</option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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

