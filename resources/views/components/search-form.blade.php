<!-- Modal -->
<div class="modal fade" id="agreementModal" tabindex="-1" aria-labelledby="agreementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agreementModalLabel">Agreement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Please read and accept the agreement before proceeding.
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam vehicula libero.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAgreement">I Agree</button>
            </div>
        </div>
    </div>
</div>

<form id="searchForm" method="GET" action="{{ route('search.users') }}">

    <div class="mb-3">
        <label for="church" class="form-label">Denomination</label>
        <select class="form-select" id="church" name="church">
            <option value="">All Denomination</option>

            @foreach ($churchOptions as $option)
                <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="living_place" class="form-label">Country</label>
        <select class="form-select" id="living_place" name="living_place">
            <option value="">All Country</option>
            @foreach ($livingPlaceOptions as $option)
                <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="education_level" class="form-label">Education</label>
        <select class="form-select" id="education_level" name="education_level">
            <option value="">All Education Level</option>
            @foreach ($educationLevelOptions as $option)
                <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="industry" class="form-label">Job</label>
        <select class="form-select" id="industry" name="industry">
            <option value="">All Job</option>
            @foreach ($industryOptions as $option)
                <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
            @endforeach
        </select>
    </div>

    <div class="row mb-3">
        <label for="height" class="form-label col-sm-2 col-form-label">Age</label>
        <div class="col-sm-10">
            <x-multi-range-slider id="age" name="age" :min="$min_age" :max="$max_age" :start="[20, 150]"
                :decimal="false" :show-tooltip="true" tooltip-suffix=" years" />
        </div>

    </div>
    {{-- <div class="row mb-3">
        <label for="height" class="form-label col-sm-2 col-form-label">Height</label>
        <div class="col-sm-10">
            <x-multi-range-slider :min="60" :max="72" :start="[60, 72]" :decimal="false"
                      :show-tooltip="true" tooltip-suffix=" cm" id="height-slider"
                      name="height" format="feet" />



        </div>

    </div> --}}
    <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" role="switch" id="married" name="married">
        <label class="form-check-label" for="married">Divorced</label>
    </div>

    <button type="submit" class="btn btn-primary">Search</button>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('searchForm');
        const modal = new bootstrap.Modal(document.getElementById('agreementModal'));
        const confirmButton = document.getElementById('confirmAgreement');

        form.addEventListener('submit', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Show the modal
            modal.show();
        });

        confirmButton.addEventListener('click', function () {
            // Close the modal
            modal.hide();

            // Submit the form programmatically
            form.submit();
        });
    });
</script>
@endpush