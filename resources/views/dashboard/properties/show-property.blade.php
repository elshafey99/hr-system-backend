@php
    $locale = app()->getLocale();
    $propertyName = $property?->getTranslation('name', $locale) ?? ($property?->name ?? '-');
@endphp

<x-show title="{{ __('dashboard.property_details') }}">
    {{-- Property Header Card --}}
    <div class="card property-header-card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-start">
                        <div class="property-icon-wrapper me-3">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="mb-2 fw-bold property-title">{{ $propertyName }}</h3>
                            <div class="property-meta">
                                <span class="badge bg-light text-dark me-2">
                                    <i class="fas fa-barcode me-1"></i>{{ $property?->code ?? '-' }}
                                </span>
                                @if ($property?->property_number)
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="fas fa-hashtag me-1"></i>{{ $property->property_number }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted mb-0 mt-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $property?->city?->getTranslation('name', $locale) ?? '-' }},
                                {{ $property?->governorate?->getTranslation('name', $locale) ?? '-' }},
                                {{ $property?->country?->getTranslation('name', $locale) ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <span class="status-badge {{ $property?->is_active ? 'status-active' : 'status-inactive' }}">
                        <i class="fas {{ $property?->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                        {{ $property?->is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                    </span>
                    @if ($property?->approvedBy)
                        <p class="text-muted small mt-2 mb-0">
                            <i class="fas fa-user-check me-1"></i>{{ __('dashboard.approved_by') }}:
                            {{ $property->approvedBy->name }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        {{-- Buildings Card --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-buildings">
                <div class="stats-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number mb-1">{{ $totalBuildings }}</h3>
                    <p class="stats-label mb-1">{{ __('dashboard.buildings') }}</p>
                    <small class="stats-detail d-block">{{ $totalFloors }} {{ __('dashboard.floors') }}</small>
                </div>
            </div>
        </div>

        {{-- Units Card --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-units">
                <div class="stats-icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number mb-1">{{ $totalUnits }}</h3>
                    <p class="stats-label mb-1">{{ __('dashboard.units') }}</p>
                    <div class="stats-detail">
                        <span class="badge bg-success-subtle text-success me-1">{{ $occupiedUnits }}
                            {{ __('dashboard.occupied') }}</span>
                        <span class="badge bg-warning-subtle text-warning">{{ $vacantUnits }}
                            {{ __('dashboard.vacant') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users Card --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-users">
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number mb-1">{{ $totalUsers }}</h3>
                    <p class="stats-label mb-1">{{ __('dashboard.users') }}</p>
                    <small class="stats-detail d-block">{{ __('dashboard.members') }}</small>
                </div>
            </div>
        </div>

        {{-- Facilities Card --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-facilities">
                <div class="stats-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number mb-1">{{ $totalFacilities }}</h3>
                    <p class="stats-label mb-1">{{ __('dashboard.facilities') }}</p>
                    <small class="stats-detail d-block">{{ __('dashboard.services') }}</small>
                </div>
            </div>
        </div>

        {{-- Garages Card --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-garages">
                <div class="stats-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number mb-1">{{ $totalGarages }}</h3>
                    <p class="stats-label mb-1">{{ __('dashboard.garages') }}</p>
                    <small class="stats-detail d-block">{{ __('dashboard.capacity') }}</small>
                </div>
            </div>
        </div>

        {{-- Attachments Card --}}
        <div class="col-lg-4 col-md-6">
            <div class="stats-card stats-attachments">
                <div class="stats-icon">
                    <i class="fas fa-paperclip"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number mb-1">{{ $totalAttachments }}</h3>
                    <p class="stats-label mb-1">{{ __('dashboard.attachments') }}</p>
                    <small class="stats-detail d-block">{{ __('dashboard.files') }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabbed Content --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom">
            <ul class="nav nav-tabs card-header-tabs" id="propertyTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="buildings-tab" data-bs-toggle="tab" href="#buildings" role="tab">
                        <i class="fas fa-building me-2"></i>{{ __('dashboard.buildings') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="units-tab" data-bs-toggle="tab" href="#units" role="tab">
                        <i class="fas fa-door-open me-2"></i>{{ __('dashboard.units') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="facilities-tab" data-bs-toggle="tab" href="#facilities" role="tab">
                        <i class="fas fa-cogs me-2"></i>{{ __('dashboard.facilities') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="users-tab" data-bs-toggle="tab" href="#users" role="tab">
                        <i class="fas fa-users me-2"></i>{{ __('dashboard.users') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="garages-tab" data-bs-toggle="tab" href="#garages" role="tab">
                        <i class="fas fa-warehouse me-2"></i>{{ __('dashboard.garages') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="files-tab" data-bs-toggle="tab" href="#files" role="tab">
                        <i class="fas fa-folder-open me-2"></i>{{ __('dashboard.attachments') }}
                    </a>
                </li>
            </ul>
        </div>

        <div class="card-body tab-content p-4" id="propertyTabsContent">
            {{-- Buildings Tab --}}
            <div class="tab-pane fade show active" id="buildings" role="tabpanel">
                @if ($buildings && $buildings->count() > 0)
                    <div class="accordion" id="buildingsAccordion">
                        @foreach ($buildings as $building)
                            <div class="accordion-item building-item mb-3">
                                <h2 class="accordion-header" id="building-{{ $building->id }}">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse-building-{{ $building->id }}">
                                        <div class="d-flex align-items-center w-100">
                                            <div class="building-icon me-3">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="mb-0">
                                                    {{ $building->getTranslation('name', $locale) ?? $building->name }}
                                                </h5>
                                                <small class="text-muted">
                                                    <span
                                                        class="badge bg-{{ $building->type === 'residential' ? 'primary' : 'info' }} me-2">
                                                        {{ ucfirst($building->type) }}
                                                    </span>
                                                    {{ $building->floors->count() }} {{ __('dashboard.floors') }} •
                                                    {{ $building->floors->sum(fn($f) => $f->units->count()) }}
                                                    {{ __('dashboard.units') }}
                                                </small>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse-building-{{ $building->id }}" class="accordion-collapse collapse"
                                    data-bs-parent="#buildingsAccordion">
                                    <div class="accordion-body">
                                        @if ($building->floors && $building->floors->count() > 0)
                                            @foreach ($building->floors as $floor)
                                                <div class="floor-section mb-4">
                                                    <h6 class="floor-title">
                                                        <i class="fas fa-layer-group me-2"></i>
                                                        {{ $floor->getTranslation('name', $locale) ?? $floor->name }}
                                                        <span
                                                            class="badge bg-secondary ms-2">{{ $floor->units->count() }}
                                                            {{ __('dashboard.units') }}</span>
                                                    </h6>

                                                    @if ($floor->units && $floor->units->count() > 0)
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-hover units-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ __('dashboard.unit_number') }}</th>
                                                                        <th>{{ __('dashboard.type') }}</th>
                                                                        <th>{{ __('dashboard.status') }}</th>
                                                                        <th>{{ __('dashboard.area') }}</th>
                                                                        <th>{{ __('dashboard.residents') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($floor->units as $unit)
                                                                        <tr>
                                                                            <td><strong>{{ $unit->unit_number }}</strong>
                                                                            </td>
                                                                            <td>{{ $unit->unitType?->getTranslation('display_name', $locale) ?? '-' }}
                                                                            </td>
                                                                            <td>
                                                                                <span
                                                                                    class="badge bg-{{ $unit->status === 'occupied' ? 'success' : ($unit->status === 'vacant' ? 'warning' : 'secondary') }}">
                                                                                    {{ ucfirst($unit->status ?? 'N/A') }}
                                                                                </span>
                                                                            </td>
                                                                            <td>{{ $unit->area_sqm ? $unit->area_sqm . ' m²' : '-' }}
                                                                            </td>
                                                                            <td>
                                                                                @if ($unit->assignments && $unit->assignments->where('is_active', true)->count() > 0)
                                                                                    @foreach ($unit->assignments->where('is_active', true) as $assignment)
                                                                                        <span
                                                                                            class="badge bg-light text-dark me-1">
                                                                                            {{ $assignment->user?->name ?? '-' }}
                                                                                        </span>
                                                                                    @endforeach
                                                                                @else
                                                                                    <span class="text-muted">-</span>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <p class="text-muted mb-0">{{ __('dashboard.no_units') }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted mb-0">{{ __('dashboard.no_floors') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        {{ $buildings->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ __('dashboard.no_buildings') }}</p>
                    </div>
                @endif
            </div>

            {{-- Units Tab --}}
            <div class="tab-pane fade" id="units" role="tabpanel">
                @php
                    $allUnits =
                        $property?->buildings->flatMap(function ($building) {
                            return $building->floors->flatMap(function ($floor) use ($building) {
                                return $floor->units->map(function ($unit) use ($building, $floor) {
                                    $unit->building_name =
                                        $building->getTranslation('name', app()->getLocale()) ?? $building->name;
                                    $unit->floor_name =
                                        $floor->getTranslation('name', app()->getLocale()) ?? $floor->name;
                                    return $unit;
                                });
                            });
                        }) ?? collect();
                @endphp

                @if ($allUnits->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover units-overview-table">
                            <thead>
                                <tr>
                                    <th>{{ __('dashboard.building') }}</th>
                                    <th>{{ __('dashboard.floor') }}</th>
                                    <th>{{ __('dashboard.unit_number') }}</th>
                                    <th>{{ __('dashboard.type') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.area') }}</th>
                                    <th>{{ __('dashboard.residents') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allUnits->take(50) as $unit)
                                    <tr>
                                        <td>{{ $unit->building_name }}</td>
                                        <td>{{ $unit->floor_name }}</td>
                                        <td><strong>{{ $unit->unit_number }}</strong></td>
                                        <td>{{ $unit->unitType?->getTranslation('display_name', $locale) ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $unit->status === 'occupied' ? 'success' : ($unit->status === 'vacant' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($unit->status ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td>{{ $unit->area_sqm ? $unit->area_sqm . ' m²' : '-' }}</td>
                                        <td>
                                            @if ($unit->assignments && $unit->assignments->where('is_active', true)->count() > 0)
                                                {{ $unit->assignments->where('is_active', true)->count() }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($allUnits->count() > 50)
                        <p class="text-muted text-center">{{ __('dashboard.showing_first_50') }}</p>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-door-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ __('dashboard.no_units') }}</p>
                    </div>
                @endif
            </div>

            {{-- Facilities Tab --}}
            <div class="tab-pane fade" id="facilities" role="tabpanel">
                @if ($facilities && $facilities->count() > 0)
                    <div class="row g-3">
                        @foreach ($facilities as $facility)
                            <div class="col-md-6 col-lg-4">
                                <div class="facility-card">
                                    <div class="facility-icon">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="facility-content">
                                        <h6 class="facility-name">
                                            {{ $facility->facilityType?->getTranslation('name', $locale) ?? '-' }}
                                        </h6>
                                        <p class="facility-details">
                                            <span
                                                class="badge bg-{{ $facility->is_available ? 'success' : 'danger' }}">
                                                {{ $facility->is_available ? __('dashboard.available') : __('dashboard.unavailable') }}
                                            </span>
                                            @if ($facility->number)
                                                <span class="ms-2">{{ __('dashboard.quantity') }}:
                                                    {{ $facility->number }}</span>
                                            @endif
                                        </p>
                                        @if ($facility->last_maintenance_date)
                                            <small class="text-muted">
                                                <i class="fas fa-wrench me-1"></i>
                                                {{ __('dashboard.last_maintenance') }}:
                                                {{ $facility->last_maintenance_date->format('Y-m-d') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3">
                        {{ $facilities->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ __('dashboard.no_facilities') }}</p>
                    </div>
                @endif
            </div>

            {{-- Users Tab --}}
            <div class="tab-pane fade" id="users" role="tabpanel">
                @if ($property?->members && $property->members->count() > 0)
                    @php
                        $membersByRole = $property->members->groupBy('role.name_key');
                    @endphp

                    @foreach ($membersByRole as $roleKey => $members)
                        <div class="role-section">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="role-title mb-0">
                                    <i class="fas fa-user-tag me-2"></i>
                                    {{ ucfirst($roleKey) }}
                                </h5>
                                <span class="badge bg-primary rounded-pill px-3">{{ $members->count() }}</span>
                            </div>
                            <div class="row g-3">
                                @foreach ($members as $member)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="user-card-compact">
                                            <div class="user-avatar-sm">
                                                @if ($member->user?->image)
                                                    <img src="{{ asset($member->user->image) }}"
                                                        alt="{{ $member->user->name }}">
                                                @else
                                                    <span class="avatar-text">
                                                        {{ strtoupper(substr($member->user?->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <h6 class="user-name-sm">{{ $member->user?->name ?? '-' }}</h6>
                                            @if ($member->user?->phone)
                                                <p class="user-phone-sm" dir="ltr">{{ $member->user->phone }}
                                                </p>
                                            @endif
                                            <span class="role-tag">
                                                {{ $member->role?->getTranslation('display_name', $locale) ?? $roleKey }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ __('dashboard.no_users') }}</p>
                    </div>
                @endif
            </div>

            {{-- Garages Tab --}}
            <div class="tab-pane fade" id="garages" role="tabpanel">
                @if ($garages && $garages->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover garages-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('dashboard.name') }}</th>
                                    <th>{{ __('dashboard.code') }}</th>
                                    <th>{{ __('dashboard.type') }}</th>
                                    <th>{{ __('dashboard.capacity') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($garages as $garage)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $garage->getTranslation('name', $locale) ?? $garage->name }}</td>
                                        <td>{{ $garage->code ?? '-' }}</td>
                                        <td>{{ $garage->type ?? '-' }}</td>
                                        <td>{{ $garage->capacity ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $garages->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-warehouse fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ __('dashboard.no_garages') }}</p>
                    </div>
                @endif
            </div>

            {{-- Files Tab --}}
            <div class="tab-pane fade" id="files" role="tabpanel">
                @if ($attachments && $attachments->count() > 0)
                    @php
                        $filesByCategory = $attachments->groupBy('category.name_key');
                    @endphp

                    @foreach ($filesByCategory as $categoryKey => $files)
                        <div class="file-category  mb-2">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5 class="category-title mb-0">
                                    <i class="fas fa-folder me-2 "></i>
                                    {{ ucfirst($categoryKey) }}
                                </h5>
                                <span class="badge bg-secondary">{{ $files->count() }}</span>
                            </div>
                            <div class="row g-3">
                                @foreach ($files as $file)
                                    <div class="col-md-6 ">
                                        <div class="file-card" role="button" data-bs-toggle="modal"
                                            data-bs-target="#fileModal{{ $file->id }}">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="file-icon">
                                                    @if (in_array(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                        <i class="fas fa-file-image"></i>
                                                    @elseif(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)) == 'pdf')
                                                        <i class="fas fa-file-pdf"></i>
                                                    @elseif(in_array(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)), ['doc', 'docx']))
                                                        <i class="fas fa-file-word"></i>
                                                    @elseif(in_array(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)), ['xls', 'xlsx']))
                                                        <i class="fas fa-file-excel"></i>
                                                    @else
                                                        <i class="fas fa-file"></i>
                                                    @endif
                                                </div>
                                                <div class="file-info flex-grow-1">
                                                    <h6 class="file-name mb-1">{{ $file->file_name }}</h6>
                                                    <small class="text-muted d-block">
                                                        <i
                                                            class="fas fa-calendar me-1"></i>{{ $file->created_at->format('Y-m-d') }}
                                                    </small>
                                                    <span class="badge bg-light text-dark mt-1">
                                                        {{ strtoupper(pathinfo($file->file_name, PATHINFO_EXTENSION)) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-external-link-alt text-primary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- File Preview Modal --}}
                                    <div class="modal fade" id="fileModal{{ $file->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-file me-2"></i>{{ $file->file_name }}
                                                    </h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    @if ($file->file_path && file_exists(public_path($file->file_path)))
                                                        @if (in_array(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                            <img src="{{ asset($file->file_path) }}"
                                                                alt="{{ $file->file_name }}"
                                                                class="img-fluid rounded">
                                                        @elseif(strtolower(pathinfo($file->file_name, PATHINFO_EXTENSION)) == 'pdf')
                                                            <iframe src="{{ asset($file->file_path) }}"
                                                                width="100%" height="600px"
                                                                frameborder="0"></iframe>
                                                        @else
                                                            <div class="py-5">
                                                                <i class="fas fa-file fa-4x text-muted mb-3"></i>
                                                                <p class="text-muted">
                                                                    {{ __('dashboard.preview_not_available') }}</p>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="py-5">
                                                            <i
                                                                class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                                                            <p class="text-muted">
                                                                {{ __('dashboard.file_not_found') }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    @if ($file->file_path && file_exists(public_path($file->file_path)))
                                                        <a href="{{ asset($file->file_path) }}"
                                                            download="{{ $file->file_name }}"
                                                            class="btn btn-primary">
                                                            <i
                                                                class="fas fa-download me-2"></i>{{ __('dashboard.download') }}
                                                        </a>
                                                    @endif
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        {{ __('dashboard.close') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-3">
                        {{ $attachments->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">{{ __('dashboard.no_files') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Custom Styles --}}
    <style>
        /* Property Header */
        .property-header-card {
            border-radius: 12px !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .property-header-card .card-body {
            background: white;
            border-radius: 12px;
        }

        .property-icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .property-title {
            color: #667eea;
            font-size: 1.75rem;
        }

        .property-meta .badge {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 600;
            border: 2px solid transparent;
        }

        .status-active {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-color: #b1dfbb;
        }

        .status-inactive {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-color: #f1b0b7;
        }

        /* Statistics Cards */
        .stats-card {
            background: white;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            opacity: 0.05;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .stats-card:hover::before {
            opacity: 0.08;
            transform: scale(1.1);
        }

        .stats-buildings {
            border-color: #667eea;
        }

        .stats-buildings::before {
            background: radial-gradient(circle, #667eea 0%, transparent 70%);
        }

        .stats-units {
            border-color: #f093fb;
        }

        .stats-units::before {
            background: radial-gradient(circle, #f093fb 0%, transparent 70%);
        }

        .stats-users {
            border-color: #4facfe;
        }

        .stats-users::before {
            background: radial-gradient(circle, #4facfe 0%, transparent 70%);
        }

        .stats-facilities {
            border-color: #43e97b;
        }

        .stats-facilities::before {
            background: radial-gradient(circle, #43e97b 0%, transparent 70%);
        }

        .stats-garages {
            border-color: #ff6b6b;
        }

        .stats-garages::before {
            background: radial-gradient(circle, #ff6b6b 0%, transparent 70%);
        }

        .stats-attachments {
            border-color: #ffa502;
        }

        .stats-attachments::before {
            background: radial-gradient(circle, #ffa502 0%, transparent 70%);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-icon {
            transform: scale(1.08) rotate(3deg);
        }

        .stats-buildings .stats-icon {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.18) 100%);
            color: #667eea;
        }

        .stats-units .stats-icon {
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(240, 147, 251, 0.18) 100%);
            color: #f093fb;
        }

        .stats-users .stats-icon {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(79, 172, 254, 0.18) 100%);
            color: #4facfe;
        }

        .stats-facilities .stats-icon {
            background: linear-gradient(135deg, rgba(67, 233, 123, 0.1) 0%, rgba(67, 233, 123, 0.18) 100%);
            color: #43e97b;
        }

        .stats-garages .stats-icon {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(255, 107, 107, 0.18) 100%);
            color: #ff6b6b;
        }

        .stats-attachments .stats-icon {
            background: linear-gradient(135deg, rgba(255, 165, 2, 0.1) 0%, rgba(255, 165, 2, 0.18) 100%);
            color: #ffa502;
        }

        .stats-content {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            line-height: 1;
            margin-bottom: 0.4rem;
        }

        .stats-label {
            font-size: 0.95rem;
            color: #718096;
            font-weight: 600;
            margin-bottom: 0.4rem;
            text-transform: capitalize;
        }

        .stats-detail {
            color: #a0aec0;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .stats-detail .badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.6rem;
            font-weight: 500;
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        /* Tabs */
        .nav-tabs {
            border-bottom: 2px solid #e2e8f0;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #718096;
            font-weight: 600;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            border-radius: 0;
            background: transparent;
        }

        .nav-tabs .nav-link:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.05);
            border-bottom: 3px solid transparent;
        }

        .nav-tabs .nav-link.active {
            color: #667eea;
            background: white;
            border-bottom: 3px solid #667eea;
            position: relative;
        }

        .nav-tabs .nav-link i {
            font-size: 1.1rem;
        }

        /* Tables */
        .units-table thead,
        .units-overview-table thead,
        .garages-table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .units-table th,
        .units-overview-table th,
        .garages-table th {
            font-weight: 600;
            color: #495057;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.75rem;
            border-bottom: 2px solid #dee2e6;
        }

        .units-table td,
        .units-overview-table td,
        .garages-table td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        .units-table tbody tr:hover,
        .units-overview-table tbody tr:hover,
        .garages-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Building Accordion */
        .building-item {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .building-item .accordion-button {
            background: #f7fafc;
            font-weight: 600;
            padding: 1.25rem;
        }

        .building-item .accordion-button:not(.collapsed) {
            background: #edf2f7;
            color: #667eea;
            box-shadow: none;
        }

        .building-item .accordion-button:focus {
            box-shadow: none;
            border-color: transparent;
        }

        .building-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
        }

        .floor-section {
            background: #ffffff;
            padding: 1.25rem;
            border-radius: 8px;
            border-left: 3px solid #667eea;
            margin-bottom: 1rem;
        }

        .floor-title {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        /* Facility Cards */
        .facility-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.25rem;
            display: flex;
            gap: 1rem;
            transition: all 0.3s ease;
            height: 100%;
        }

        .facility-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
            transform: translateY(-2px);
        }

        .facility-icon {
            width: 50px;
            height: 50px;
            background: rgba(67, 233, 123, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #43e97b;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .facility-name {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        /* User Cards - Improved Design */
        .role-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .role-section:last-child {
            margin-bottom: 0;
        }

        .role-title {
            color: #2d3748;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .user-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0;
            transition: all 0.3s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .user-card:hover {
            border-color: #4facfe;
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.15);
            transform: translateY(-3px);
        }

        /* Compact User Cards */
        .user-card-compact {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .user-card-compact:hover {
            border-color: #4facfe;
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.15);
            transform: translateY(-2px);
        }

        .user-avatar-sm {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4facfe 0%, #667eea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            overflow: hidden;
            margin-bottom: 0.75rem;
            flex-shrink: 0;
        }

        .user-avatar-sm img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-text {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-name-sm {
            color: #2d3748;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
            word-break: break-word;
            line-height: 1.3;
        }

        .user-phone-sm {
            color: #718096;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            direction: ltr;
            unicode-bidi: embed;
        }

        .role-tag {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.6rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 500;
            margin-top: auto;
        }

        /* Legacy styles for backward compatibility */
        .user-avatar-lg {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4facfe 0%, #667eea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        .user-avatar-lg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-initials {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }

        .user-card-header {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.08) 0%, rgba(102, 126, 234, 0.08) 100%);
            padding: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .user-card-body {
            padding: 1.25rem;
            text-align: center;
            flex-grow: 1;
        }

        .user-name-full {
            color: #2d3748;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
            word-break: break-word;
        }

        .user-phone,
        .user-email,
        .user-member-id {
            color: #718096;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .user-phone i,
        .user-email i,
        .user-member-id i {
            color: #4facfe;
            width: 16px;
        }

        .user-phone span {
            direction: ltr;
            unicode-bidi: embed;
        }

        .user-card-footer {
            background: #f8fafc;
            padding: 0.875rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e2e8f0;
        }

        .role-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-indicator {
            padding: 0.3rem 0.7rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-indicator.active {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-indicator.inactive {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* Legacy user-card styles for backward compatibility */
        .user-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(79, 172, 254, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4facfe;
            font-size: 1.5rem;
            flex-shrink: 0;
            overflow: hidden;
            border: 2px solid rgba(79, 172, 254, 0.2);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            min-width: 0;
        }

        .user-name {
            color: #2d3748;
            font-weight: 600;
            font-size: 1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-contact {
            color: #718096;
            font-size: 0.85rem;
        }

        .user-contact i {
            color: #4facfe;
        }

        /* File Cards */
        .file-category {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .file-category:last-child {
            border-bottom: none;
        }

        .category-title {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .file-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.25rem;
            display: flex;
            gap: 1rem;
            align-items: center;
            transition: all 0.3s ease;
            height: 100%;
        }

        .file-card:hover {
            border-color: #f093fb;
            box-shadow: 0 4px 12px rgba(240, 147, 251, 0.15);
            transform: translateY(-2px);
        }

        .file-icon {
            width: 50px;
            height: 50px;
            background: rgba(240, 147, 251, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f093fb;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .file-name {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        /* Empty States */
        .text-center.py-5 {
            padding: 3rem 1rem !important;
        }

        .text-center.py-5 i {
            opacity: 0.3;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.35rem 0.75rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .property-icon-wrapper {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .property-title {
                font-size: 1.5rem;
            }

            .stats-card {
                padding: 1rem;
            }

            .stats-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }

            .stats-number {
                font-size: 1.5rem;
            }

            .nav-tabs .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .nav-tabs .nav-link i {
                font-size: 1rem;
            }

            .building-icon {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
        }
    </style>
</x-show>
