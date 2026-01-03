@extends('dashboard.master', ['title' => __('dashboard.governorate_centers')])
@section('locations-active', 'active')
@section('tab-name', 'Governorates')

@section('content')
    @php
        $governorateId = request()->get('id');
        $governorate = \App\Models\Governorate::find($governorateId);
        $country = $governorate ? $governorate->country : null;
    @endphp

    <div class="row">
        <div class="col-12">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.locations.index') }}">Countries</a>
                    </li>
                    @if ($country)
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard.governorates.index', ['country_id' => $country->id]) }}">
                                {{ $country->getTranslation('name', app()->getLocale()) }}
                            </a>
                        </li>
                    @endif
                    @if ($governorate)
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $governorate->getTranslation('name', app()->getLocale()) }} - Centers
                        </li>
                    @endif
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ __('dashboard.governorate_centers') }}</h4>
                    <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i data-feather='plus'></i> {{ __('dashboard.governorate_center_add') }}
                    </button>
                </div>
                @livewire('dashboard.locations.center-governorate.center-governorate', ['id' => request()->get('id')])
            </div>
        </div>
    </div>

    @livewire('dashboard.locations.center-governorate.add-center-governorate', ['governorateId' => $governorate->id])
    @livewire('dashboard.locations.center-governorate.update-center-governorate', ['governorateId' => $governorate->id])
@endsection

@push('js')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Success message
            Livewire.on('success', function(message) {
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            // Center created
            Livewire.on('centerGovernorateCreatedMs', function() {
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: '{{ __('dashboard.center_created_successfully') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            // Center updated
            Livewire.on('centerGovernorateUpdatedMs', function() {
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: '{{ __('dashboard.center_updated_successfully') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            // Delete confirmation
            Livewire.on('centerGovernorateDelete', function(data) {
                Swal.fire({
                    title: "{{ __('dashboard.are_you_sure') }}",
                    text: "{{ __('dashboard.confirm_delete_message') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('dashboard.yes_delete') }}",
                    cancelButtonText: "{{ __('dashboard.cancel') }}",
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary ms-1'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteCenterGovernorate', {
                            id: data.id
                        });
                    }
                });
            });

            // Item deleted
            window.addEventListener('itemDeleted', function() {
                Livewire.dispatch('refreshData');
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: '{{ __('dashboard.item_deleted_successfully') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            // Toggle create modal
            Livewire.on('createModalToggle', function() {
                const modalElement = document.getElementById('createModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                        modalElement);
                    modal.toggle();
                }
            });

            // Toggle update modal
            Livewire.on('updateModalToggle', function() {
                const modalElement = document.getElementById('updateModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                        modalElement);
                    modal.toggle();
                }
            });
        });
    </script>
@endpush
