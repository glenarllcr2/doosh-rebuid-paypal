<x-FormWizard :questions="$questions" formAction="" />
{{-- @push('styles')
    <style>
        .wizard-step {
            display: none;
        }

        .wizard-step:not(.d-none) {
            display: block;
        }

        .wizard-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .wizard-step-indicator {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f8f9fa;
            position: relative;
        }

        .wizard-step-indicator.active {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .wizard-step-indicator:not(:last-child)::after {
            content: "";
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 2px;
            background-color: #ddd;
            z-index: 1;
        }

        .wizard-step-indicator.active::after {
            background-color: #007bff;
        }
    </style>
@endpush

<h3>Dynamic Wizard Form</h3>
<!-- نمایش مراحل -->
<div class="wizard-steps">
    @foreach (range(0, $questions->max('page')) as $step)  <!-- تغییر در اینجا -->
        <div class="wizard-step-indicator" id="step-indicator-{{ $step + 1 }}"> <!-- شماره گذاری از 1 -->
            Step {{ $step + 1 }}  <!-- نمایش شماره صفحه به صورت از 1 شروع می‌شود -->
        </div>
    @endforeach
</div>


<form id="wizardForm" class="p-4 shadow rounded bg-light mx-auto" style="max-width: 700px;">
    @php
        $currentPage = null;
    @endphp

    @foreach ($questions as $question)
        @if ($currentPage !== $question->page)
            @if (!is_null($currentPage))
                </div> <!-- پایان صفحه قبلی -->
            @endif
            @php $currentPage = $question->page; @endphp
            <div class="wizard-step d-none" id="step-{{ $currentPage }}">
        @endif

        <div class="mb-3">
            <label class="form-label">{{ $question->question }}
                @if ($question->is_required)
                    <span class="text-danger">*</span>
                @endif
            </label>

            @switch($question->answer_type)
                @case('text')
                    <input type="text" class="form-control form-control-sm" name="{{ $question->question_key }}"
                        @if ($question->is_required) required @endif>
                @break

                @case('number')
                    <input type="number" class="form-control form-control-sm" name="{{ $question->question_key }}"
                        @if ($question->is_required) required @endif>
                @break

                @case('textarea')
                    <textarea class="form-control form-control-sm" name="{{ $question->question_key }}"
                        @if ($question->is_required) required @endif></textarea>
                @break

                @case('radio')
                    @foreach ($question->options as $option)
                        <div>
                            <input type="radio" id="{{ $option->question_key }}" name="{{ $question->question_key }}"
                                value="{{ $option->option_value }}" @if ($question->is_required) required @endif>
                            <label for="{{ $option->question_key }}">{{ $option->option_value }}</label>
                        </div>
                    @endforeach
                @break

                @case('checkbox')
                    @foreach ($question->options as $option)
                        <div>
                            <input type="checkbox" id="{{ $option->question_key }}" name="{{ $question->question_key }}[]"
                                value="{{ $option->option_value }}">
                            <label for="{{ $option->question_key }}">{{ $option->option_value }}</label>
                        </div>
                    @endforeach
                @break

                @case('select')
                    <select class="form-select form-select-sm" name="{{ $question->question_key }}"
                        @if ($question->is_required) required @endif>
                        <option value="">Select an option</option>
                        @foreach ($question->options as $option)
                            <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                        @endforeach
                    </select>
                @break

                @case('single_select')
                    @if (count($question->options) < 10)
                        <!-- اگر تعداد آیتم‌ها کمتر از ۱۰ باشد از radio استفاده کن -->
                        @foreach ($question->options as $option)
                            <div>
                                <input type="radio" id="{{ $option->question_key }}" name="{{ $question->question_key }}"
                                    value="{{ $option->option_value }}" @if ($question->is_required) required @endif>
                                <label for="{{ $option->question_key }}">{{ $option->option_value }}</label>
                            </div>
                        @endforeach
                    @else
                        <!-- اگر تعداد آیتم‌ها بیشتر از ۱۰ باشد از select استفاده کن -->
                        <select class="form-select form-select-sm" name="{{ $question->question_key }}"
                            @if ($question->is_required) required @endif>
                            <option value="">Select an option</option>
                            @foreach ($question->options as $option)
                                <option value="{{ $option->option_value }}">{{ $option->option_value }}</option>
                            @endforeach
                        </select>
                    @endif
                @break

                @case('boolean')
                    <!-- برای مقدار boolean از Bootstrap Switch استفاده می‌کنیم -->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="{{ $question->question_key }}"
                            name="{{ $question->question_key }}" value="1"
                            @if ($question->is_required) required @endif>
                        <label class="form-check-label" for="{{ $question->question_key }}">
                            {{ $question->question }}
                        </label>
                    </div>
                @break

                @case('multi_select')
                    @foreach ($question->options as $option)
                        <div>
                            <input type="checkbox" id="{{ $option->question_key }}" name="{{ $question->question_key }}[]"
                                value="{{ $option->option_value }}" @if ($question->is_required) required @endif>
                            <label for="{{ $option->question_key }}">{{ $option->option_value }}</label>
                        </div>
                    @endforeach
                @break

                @case('numeric')
                    <!-- برای ورودی عددی (اعشاری) از input استفاده می‌کنیم -->
                    <input type="number" class="form-control form-control-sm" name="{{ $question->question_key }}"
                        step="any" @if ($question->is_required) required @endif>
                @break

                @default
                        {{ $question->answer_type }}
                    <p class="text-danger">Invalid question type: {{ $question->answer_type }}</p>
            @endswitch
        </div>

        @if ($loop->last)
            </div> <!-- پایان صفحه آخر -->
        @endif
    @endforeach

    <div class="mt-3 d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
        <button type="submit" class="btn btn-success d-none" id="finishButton">Finish</button>
    </div>
</form>



@push('scripts')
    <script>
        let currentStep = 1;

        function updateStepIndicator() {
            document.querySelectorAll('.wizard-step-indicator').forEach((indicator, index) => {
                indicator.classList.toggle('active', index + 1 === currentStep);
            });
        }

        function showStep(step) {
            // مخفی کردن تمام مراحل و نمایش فقط مرحله جاری
            document.querySelectorAll(".wizard-step").forEach((stepElement, index) => {
                stepElement.classList.toggle("d-none", index + 1 !== step);
            });

            // مدیریت نمایش دکمه‌های "Back" و "Next"
            document.querySelector("button[onclick='prevStep()']").style.display = step === 1 ? 'none' : 'inline-block';
            document.querySelector("button[onclick='nextStep()']").style.display = step === document.querySelectorAll(
                ".wizard-step").length ? 'none' : 'inline-block';
            document.getElementById("finishButton").classList.toggle("d-none", step !== document.querySelectorAll(
                ".wizard-step").length);

            updateStepIndicator();
        }

        function nextStep() {
            const currentStepElement = document.getElementById(`step-${currentStep}`);
            const inputs = currentStepElement.querySelectorAll("input, select, textarea");

            // اعتبارسنجی ورودی‌ها
            // for (const input of inputs) {
            //     // بررسی وضعیت اعتبارسنجی
            //     if (!input.checkValidity()) {
            //         console.log('error');
            //         input.reportValidity();
            //         return; // اگر ورودی معتبر نبود، از ادامه کار جلوگیری می‌کنیم
            //     }
            // }

            const totalSteps = document.querySelectorAll(".wizard-step").length;
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        document.getElementById("wizardForm").addEventListener("submit", (e) => {
            e.preventDefault();
            alert("Wizard completed successfully!");
        });

        showStep(currentStep);
    </script>
@endpush --}}
