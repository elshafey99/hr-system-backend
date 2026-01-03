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
                <select class="form-select" wire:model.live="filter_status">
                    <option value="">{{ __('dashboard.all_statuses') }}</option>
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
                    <th class="align-middle">{{ __('dashboard.user') }}</th>
                    <th class="align-middle">{{ __('dashboard.property') }}</th>
                    <th class="align-middle">{{ __('dashboard.role') }}</th>
                    <th class="text-center align-middle">{{ __('dashboard.status') }}</th>
                    <th class="text-center align-middle" style="width: 18%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="member-{{ $item->id }}" style="height: 72px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>

                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    @if ($item->user?->image)
                                        <img src="{{ asset($item->user->image) }}" alt="{{ $item->user->name }}"
                                            class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                            style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($item->user?->name ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <strong class="text-primary">{{ $item->user?->name ?? '-' }}</strong>
                                        @if ($item->user?->email)
                                            <br><small class="text-muted">{{ $item->user->email }}</small>
                                        @endif
                                        @if ($item->user?->phone)
                                            <br><small class="text-muted" dir="ltr">{{ $item->user->phone }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle">
                                <span>{{ optional($item->property)->getTranslation('name', app()->getLocale()) ?? (optional($item->property)->name ?? '-') }}</span>
                            </td>

                            <td class="align-middle">
                                <span
                                    class="badge bg-info">{{ optional($item->role)->getTranslation('display_name', app()->getLocale()) ?? '-' }}</span>
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

