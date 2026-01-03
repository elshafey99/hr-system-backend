<x-createcomponent title="Create Governorates">
    <div class="row mt-4">
        <!-- English Name -->
        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">Name (EN)</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="name.en" placeholder="Enter name in English" class="form-control">
            </div>
            @include('dashboard.partials.error', ['property' => 'name.en'])
        </div>

        <!-- Arabic Name -->
        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">Name (AR)</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="name.ar" placeholder="ادخل الاسم بالعربية" class="form-control">
            </div>
            @include('dashboard.partials.error', ['property' => 'name.ar'])
        </div>

        <div class="col-md-6">
            <div class="col-sm-6">
                <label class="col-form-label">Code</label>
            </div>
            <div class="form-group">
                <input type="text" wire:model="code" placeholder="Enter code" class="form-control">
            </div>
            @include('dashboard.partials.error', ['property' => 'code'])
        </div>
    </div>
</x-createcomponent>
