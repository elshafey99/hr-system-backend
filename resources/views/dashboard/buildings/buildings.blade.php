<div>
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-4 col-12 mb-2">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                    <input wire:model.live="search" type="text" class="form-control"
                        placeholder="{{ __('dashboard.search') }}">
                </div>
            </div>

            <div class="col-md-4 col-12 mb-2">
                <select class="form-select" wire:model.live="filter_property">
                    <option value="">{{ __('dashboard.all_properties') }}</option>
                    @foreach ($properties as $p)
                        <option value="{{ $p->id }}">
                            {{ is_array($p->name) ? $p->name['en'] ?? reset($p->name) : $p->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 5%;">#</th>
                    <th class="align-middle" style="width: 30%;">{{ __('dashboard.name') }}</th>
                    <th class="align-middle" style="width: 15%;">{{ __('dashboard.property') }}</th>
                    <th class="align-middle" style="width: 10%;">{{ __('dashboard.type') }}</th>
                    <th class="text-center align-middle" style="width: 20%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="building-{{ $item->id }}" style="height: 80px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>

                            <td class="align-middle">
                                <strong class="text-primary">{{ $item->getTranslation('name', app()->getLocale()) }}</strong>
                            </td>
                            <td class="align-middle">
                                <span>{{ optional($item->property)->getTranslation('name', app()->getLocale()) ?? (optional($item->property)->name ?? '-') }}</span>
                            </td>

                            <td class="align-middle">
                                <span>{{ ucfirst($item->type) }}</span>
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
                    <tr style="height: 80px;">
                        <td colspan="6" class="text-center align-middle">
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
