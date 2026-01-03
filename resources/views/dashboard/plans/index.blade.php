@extends('dashboard.master', ['title' => __('dashboard.subscription_plans')])
@section('plans-active', 'active')
@section('plans-open', 'open')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ __('dashboard.subscription_plans') }}</h4>

                    <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i data-feather='plus'></i> {{ __('dashboard.create-subscription-plan') }}
                    </button>
                </div>

                @livewire('dashboard.plans.plans')

            </div>
        </div>
    </div>

    @livewire('dashboard.plans.add-plan')
    @livewire('dashboard.plans.update-plan')
    @livewire('dashboard.plans.show-plan')
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
