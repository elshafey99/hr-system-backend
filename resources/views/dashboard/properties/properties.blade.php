<div>
    <div class="card-body pb-0">
        <div class="row gy-2">
            <div class="col-md-4 col-12">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                    <input wire:model.live="search" type="text" class="form-control"
                        placeholder="{{ __('dashboard.search') }}">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <select class="form-select" wire:model.live="filter_country">
                    <option value="">{{ __('dashboard.all_countries') }}</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">
                            {{ $country->name ?? ($country->title ?? ($country->name_en ?? $country->name_ar)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-12">
                <select class="form-select" wire:model.live="filter_status">
                    <option value="">{{ __('dashboard.statuses') }}</option>
                    <option value="1">{{ __('dashboard.active') }}</option>
                    <option value="0">{{ __('dashboard.inactive') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="table-responsive mt-2">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 4%;">#</th>
                    <th class="align-middle">{{ __('dashboard.name') }}</th>
                    <th class="align-middle">{{ __('dashboard.code') }}</th>
                    <th class="align-middle">{{ __('dashboard.property_number') }}</th>
                    <th class="align-middle">{{ __('dashboard.address') }}</th>
                    <th class="align-middle">{{ __('dashboard.area_land') }}</th>
                    <th class="align-middle">{{ __('dashboard.area_built') }}</th>
                    <th class="text-center align-middle">{{ __('dashboard.status') }}</th>
                    <th class="text-center align-middle" style="width: 18%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="property-{{ $item->id }}" style="height: 72px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>

                            <td class="align-middle">
                                <strong
                                    class="text-primary">{{ \Illuminate\Support\Str::limit(strip_tags($item->name), 80) }}</strong>
                            </td>

                            <td class="align-middle">
                                <span>{{ $item->code }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ $item->property_number ?? '-' }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ $item->address_street ?? '-' }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ $item->area_land ? number_format($item->area_land, 2) : '-' }}</span>
                            </td>
                            <td class="align-middle">
                                <span>{{ $item->area_built ? number_format($item->area_built, 2) : '-' }}</span>
                            </td>

                            <td class="text-center align-middle">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox"
                                        wire:click="toggleStatus({{ $item->id }})"
                                        {{ $item->is_active ? 'checked' : '' }}>
                                </div>
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <button type="button"
                                        onclick="Livewire.dispatch('viewItem', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.show') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-info action-btn">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button"
                                        onclick="Livewire.dispatch('editItem', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.update') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-warning action-btn">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    {{-- <button type="button"
                                        onclick="Livewire.dispatch('deleteConfirm', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.delete') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-danger action-btn">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr style="height: 72px;">
                        <td colspan="8" class="text-center align-middle">
                            <div class="text-muted">
                                <i data-feather="inbox" class="mb-1"></i>
                                <p class="mb-0">{{ __('dashboard.no-data') }}</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="mt-3">
            {{ $data->links() }}
        </div>
    </div>
</div>
