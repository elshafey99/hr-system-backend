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
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i data-feather="filter"></i></span>
                    <select wire:model.live="filter_type" class="form-control">
                        <option value="">{{ __('dashboard.all_types') }}</option>
                        <option value="owner">{{ __('dashboard.owner') }}</option>
                        <option value="responsible">{{ __('dashboard.responsible') }}</option>
                        <option value="user">{{ __('dashboard.user') }}</option>
                        <option value="treasurer">{{ __('dashboard.treasurer') }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 5%;">#</th>
                    <th class="align-middle" style="width: 40%;">{{ __('dashboard.display_name') }}</th>
                    <th class="align-middle" style="width: 20%;">{{ __('dashboard.type') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.members_count') }}</th>
                    <th class="text-center align-middle" style="width: 15%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="property-role-{{ $item->id }}">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>
                            <td class="align-middle">
                                <strong>{{ $item->display_name }}</strong>
                            </td>
                            <td class="align-middle">
                                @if ($item->type == 'owner')
                                    <span class="badge rounded-pill bg-primary">
                                        {{ __('dashboard.owner') }}
                                    </span>
                                @elseif($item->type == 'responsible')
                                    <span class="badge rounded-pill bg-warning">
                                        {{ __('dashboard.responsible') }}
                                    </span>
                                @elseif($item->type == 'user')
                                    <span class="badge rounded-pill bg-success">
                                        {{ __('dashboard.user') }}
                                    </span>
                                @elseif($item->type == 'treasurer')
                                    <span class="badge rounded-pill bg-danger">
                                        {{ __('dashboard.treasurer') }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-info">
                                        {{ $item->type }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill bg-secondary">
                                    {{ $item->members()->count() }}
                                </span>
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
                    <tr>
                        <td colspan="5" class="text-center align-middle">
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
