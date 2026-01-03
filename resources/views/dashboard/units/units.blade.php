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
                <select class="form-select" wire:model.live="filter_property">
                    <option value="">{{ __('dashboard.all_properties') }}</option>
                    @foreach ($properties as $p)
                        <option value="{{ $p->id }}">
                            {{ is_array($p->name) ? ($p->name['en'] ?? reset($p->name)) : $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-12">
                <select class="form-select" wire:model.live="filter_status">
                    <option value="">{{ __('dashboard.all_statuses') }}</option>
                    <option value="vacant">{{ __('dashboard.vacant') }}</option>
                    <option value="occupied">{{ __('dashboard.occupied') }}</option>
                    <option value="reserved">{{ __('dashboard.reserved') }}</option>
                    <option value="maintenance">{{ __('dashboard.maintenance') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="table-responsive mt-2">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 4%;">#</th>
                    <th class="align-middle">{{ __('dashboard.unit_number') }}</th>
                    <th class="align-middle">{{ __('dashboard.property') }}</th>
                    <th class="align-middle">{{ __('dashboard.building') }}</th>
                    <th class="align-middle">{{ __('dashboard.floor') }}</th>
                    <th class="align-middle">{{ __('dashboard.type') }}</th>
                    <th class="align-middle">{{ __('dashboard.status') }}</th>
                    <th class="align-middle">{{ __('dashboard.area') }}</th>
                    <th class="text-center align-middle" style="width: 18%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="unit-{{ $item->id }}" style="height: 72px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>

                            <td class="align-middle">
                                <strong class="text-primary">{{ $item->unit_number }}</strong>
                                @if ($item->name)
                                    <br><small class="text-muted">{{ $item->name }}</small>
                                @endif
                            </td>

                            <td class="align-middle">
                                <span>{{ optional($item->floor->building->property)->getTranslation('name', app()->getLocale()) ?? (optional($item->floor->building->property)->name ?? '-') }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ optional($item->floor->building)->getTranslation('name', app()->getLocale()) ?? '-' }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ optional($item->floor)->getTranslation('name', app()->getLocale()) ?? '-' }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ optional($item->unitType)->getTranslation('display_name', app()->getLocale()) ?? '-' }}</span>
                            </td>

                            <td class="align-middle">
                                <span
                                    class="badge bg-{{ $item->status === 'occupied' ? 'success' : ($item->status === 'vacant' ? 'warning' : ($item->status === 'reserved' ? 'info' : 'secondary')) }}">
                                    {{ ucfirst($item->status ?? 'N/A') }}
                                </span>
                            </td>

                            <td class="align-middle">
                                <span>{{ $item->area_sqm ? number_format($item->area_sqm, 2) . ' m²' : '-' }}</span>
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
                        <td colspan="9" class="text-center align-middle">
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

