<!-- Modal -->
<div class="modal fade" id="agreementModal-r" tabindex="-1" aria-labelledby="agreementModalLabel-r" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agreementModalLabel-r">Agreement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Please read and accept the agreement before proceeding.
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam vehicula libero.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAgreement-r">I Agree</button>
            </div>
        </div>
    </div>
</div>

<form id="searchForm-r" method="GET" action="{{ route('search.users') }}" class="p-4 shadow rounded bg-light mx-auto" style="max-width: 900px;">
    <!-- گروه‌بندی اصلی با Flexbox -->
    <div class="d-flex flex-wrap gap-3">
        <!-- Denomination -->
        <div style="flex: 1 1 300px; max-width: 300px;">
            <label for="church" class="form-label">Denomination</label>
            <select class="form-select form-select-sm" id="church" name="church">
                <option value="">All Denomination</option>
                @foreach ($churchOptions as $option)
                    <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                @endforeach
            </select>
        </div>

        <!-- Country -->
        <div style="flex: 1 1 300px; max-width: 300px;">
            <label for="living_place" class="form-label">Country</label>
            <select class="form-select form-select-sm" id="living_place" name="living_place">
                <option value="">All Country</option>
                @foreach ($livingPlaceOptions as $option)
                    <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                @endforeach
            </select>
        </div>

        <!-- Education -->
        <div style="flex: 1 1 300px; max-width: 300px;">
            <label for="education_level" class="form-label">Education</label>
            <select class="form-select form-select-sm" id="education_level" name="education_level">
                <option value="">All Education Level</option>
                @foreach ($educationLevelOptions as $option)
                    <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                @endforeach
            </select>
        </div>

        <!-- Job -->
        <div style="flex: 1 1 300px; max-width: 300px;">
            <label for="industry" class="form-label">Job</label>
            <select class="form-select form-select-sm" id="industry" name="industry">
                <option value="">All Job</option>
                @foreach ($industryOptions as $option)
                    <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Age -->
    <div class="mt-3">
        <label for="age1" class="form-label">Age</label>
        <x-multi-range-slider id="age1" name="age1" :min="$min_age" :max="$max_age" :start="[20, 150]"
            :decimal="false" :show-tooltip="true" tooltip-suffix=" years" />
    </div>

    <!-- Divorced (Switch) -->
    <div class="form-check form-switch mt-3">
        <input class="form-check-input" type="checkbox" role="switch" id="married" name="married">
        <label class="form-check-label" for="married">Divorced</label>
    </div>

    <!-- Submit Button -->
    <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('searchForm-r');
        const modal = new bootstrap.Modal(document.getElementById('agreementModal-r'));
        const confirmButton = document.getElementById('confirmAgreement-r');

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