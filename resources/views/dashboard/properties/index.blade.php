@extends('dashboard.master', ['title' => __('dashboard.properties')])
@section('properties-active', 'active')
@section('properties-open', 'open')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ __('dashboard.properties') }}</h4>

                    <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i data-feather='plus'></i> {{ __('dashboard.create-property') }}
                    </button>
                </div>

                @livewire('dashboard.properties.properties')

            </div>
        </div>
    </div>

    @livewire('dashboard.properties.add-property-wizard')
    @livewire('dashboard.properties.add-property')
    @livewire('dashboard.properties.update-property')
    @livewire('dashboard.properties.show-property')
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

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

            Livewire.on('somethingFailed', function() {
                Swal.fire({
                    position: 'top-start',
                    icon: 'error',
                    title: '{{ __('validation.something-valid') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            Livewire.on('deleteConfirm', function(data) {
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
                        Livewire.dispatch('delete', {
                            id: data.id
                        });
                    }
                });
            });

            Livewire.on('createModalToggle', function() {
                const modalElement = document.getElementById('createModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                        modalElement);
                    modal.toggle();
                }
            });

            // Prevent modal from closing during Livewire updates for wizard
            document.addEventListener('livewire:init', () => {
                const modalElement = document.getElementById('createModal');
                if (modalElement) {
                    let isLivewireUpdating = false;
                    
                    // Track Livewire updates
                    Livewire.hook('message.processed', (message, component) => {
                        if (component && component.__instance && component.__instance.name === 'dashboard.properties.add-property-wizard') {
                            isLivewireUpdating = true;
                            setTimeout(() => {
                                isLivewireUpdating = false;
                            }, 500);
                        }
                    });

                    // Prevent closing during updates
                    modalElement.addEventListener('hide.bs.modal', function(event) {
                        if (isLivewireUpdating) {
                            event.preventDefault();
                            event.stopPropagation();
                            return false;
                        }
                    });
                }
            });

            Livewire.on('updateModalToggle', function() {
                const modalElement = document.getElementById('updateModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                        modalElement);
                    modal.toggle();
                }
            });
            document.addEventListener('showModalToggle', function(event) {
                const modalElement = document.getElementById('showModal');
                if (!modalElement) return;

                if (modalElement.parentElement !== document.body) {
                    document.body.appendChild(modalElement);
                }

                const modal = bootstrap.Modal.getOrCreateInstance(modalElement, {
                    backdrop: true,
                    keyboard: true,
                    focus: true,
                });

                modal.show();
            });
        });
    </script>
@endpush
