<div>
    <div class="card-body pb-0">
        <div class="row gy-2">
            <div class="col-md-3 col-12">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                    <input wire:model.live="search" type="text" class="form-control"
                        placeholder="{{ __('dashboard.search') }}">
                </div>
            </div>

            <div class="col-md-3 col-12">
                <select class="form-select" wire:model.live="filter_property">
                    <option value="">{{ __('dashboard.all_properties') }}</option>
                    @foreach ($properties as $p)
                        <option value="{{ $p->id }}">
                            {{ is_array($p->name) ? ($p->name['en'] ?? reset($p->name)) : $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-12">
                <select class="form-select" wire:model.live="filter_building" @if(!$filter_property) disabled @endif>
                    <option value="">{{ __('dashboard.all_buildings') }}</option>
                    @foreach ($buildings as $building)
                        <option value="{{ $building->id }}">
                            {{ $building->getTranslation('name', app()->getLocale()) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-12">
                <select class="form-select" wire:model.live="filter_type">
                    <option value="">{{ __('dashboard.all_types') }}</option>
                    <option value="residential">{{ __('dashboard.residential') }}</option>
                    <option value="administrative">{{ __('dashboard.administrative') }}</option>
                    <option value="services">{{ __('dashboard.services') }}</option>
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
                    <th class="align-middle">{{ __('dashboard.floor_number') }}</th>
                    <th class="align-middle">{{ __('dashboard.property') }}</th>
                    <th class="align-middle">{{ __('dashboard.building') }}</th>
                    <th class="align-middle">{{ __('dashboard.type') }}</th>
                    <th class="text-center align-middle">{{ __('dashboard.units_count') }}</th>
                    <th class="text-center align-middle" style="width: 18%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="floor-{{ $item->id }}" style="height: 72px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>

                            <td class="align-middle">
                                <strong class="text-primary">{{ $item->getTranslation('name', app()->getLocale()) }}</strong>
                            </td>

                            <td class="align-middle">
                                <span class="badge bg-info">{{ $item->floor_number }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ optional($item->building->property)->getTranslation('name', app()->getLocale()) ?? (optional($item->building->property)->name ?? '-') }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ optional($item->building)->getTranslation('name', app()->getLocale()) ?? '-' }}</span>
                            </td>

                            <td class="align-middle">
                                @if ($item->type)
                                    <span class="badge bg-{{ $item->type === 'residential' ? 'success' : ($item->type === 'administrative' ? 'warning' : 'info') }}">
                                        {{ ucfirst($item->type) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center align-middle">
                                <span class="badge bg-secondary">{{ $item->units->count() }}</span>
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <button type="button"
                                        onclick="Livewire.dispatch('editItem', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.update') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-warning action-btn">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <button type="button"
                                        onclick="Livewire.dispatch('deleteConfirm', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.delete') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-danger action-btn">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
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

