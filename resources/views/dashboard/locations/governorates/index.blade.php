@extends('dashboard.master', ['title' => __('dashboard.governorates')])
@section('locations-active', 'active')
@section('tab-name', 'Governorates')

@section('content')
    @php
        $countryId = request()->get('country_id');
        $country = \App\Models\Country::find($countryId);
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
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $country->getTranslation('name', app()->getLocale()) }}
                        </li>
                    @endif
                </ol>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ __('dashboard.governorates') }}</h4>
                    <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i data-feather='plus'></i> {{ __('dashboard.create-governorate') }}
                    </button>
                </div>
                @livewire('dashboard.locations.governorates.governorates', ['countryId' => $countryId])
            </div>
        </div>
    </div>

    @livewire('dashboard.locations.governorates.add-governorate', ['countryId' => $country->id])
    @livewire('dashboard.locations.governorates.update-governorate', ['countryId' => $countryId])
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

            // Governorate created
            Livewire.on('governorateCreatedMs', function() {
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: '{{ __('dashboard.governorate_created_successfully') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            // Governorate updated
            Livewire.on('governorateUpdatedMs', function() {
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: '{{ __('dashboard.governorate_updated_successfully') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            // Delete confirmation
            Livewire.on('governorateDelete', function(data) {
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
                        Livewire.dispatch('deleteGovernorate', {
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
