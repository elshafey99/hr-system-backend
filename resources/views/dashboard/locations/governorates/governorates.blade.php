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
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 5%;">#</th>
                    <th class="align-middle" style="width: 40%;">{{ __('dashboard.name') }}</th>
                    <th class="align-middle" style="width: 15%;">{{ __('dashboard.code') }}</th>
                    <th class="text-center align-middle" style="width: 40%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="governorate-{{ $item->id }}" style="height: 80px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>
                            <td class="align-middle">
                                <strong
                                    class="text-primary">{{ $item->getTranslation('name', app()->getLocale()) }}</strong>
                            </td>
                            <td class="align-middle">
                                <span class="badge rounded-pill bg-info">{{ $item->code }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <button type="button"
                                        onclick="Livewire.dispatch('governorateUpdate', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.update') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-warning action-btn">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button"
                                        onclick="Livewire.dispatch('governorateDelete', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.delete') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-danger action-btn">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                    <a href="{{ route('dashboard.centers.index', ['id' => $item->id]) }}"
                                        title="{{ __('dashboard.centers') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-info action-btn">
                                        <i class="fa-solid fa-map-location-dot"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr style="height: 80px;">
                        <td colspan="4" class="text-center align-middle">
                            <div class="text-muted">
                                <i data-feather="inbox" class="mb-1"></i>
                                <p class="mb-0">{{ __('dashboard.no-data') }}</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="text-muted small">
                <span class="fw-bold">{{ __('dashboard.showing') }}</span>
                <span class="badge bg-light-primary">{{ $data->firstItem() ?? 0 }}</span>
                {{ __('dashboard.to') }}
                <span class="badge bg-light-primary">{{ $data->lastItem() ?? 0 }}</span>
                {{ __('dashboard.of') }}
                <span class="badge bg-light-success">{{ $data->total() }}</span>
                {{ __('dashboard.entries') }}
            </div>
            <div>
                {{ $data->links('pagination.custom') }}
            </div>
        </div>
    </div>
</div>
