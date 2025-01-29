@push('styles')
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

        .card {
            border-radius: 10px;
            border: 1px solid #ddd;
        }

        .card-body {
            padding: 30px;
        }

        .card-footer {
            background-color: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
        }

        .wizard-step {
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .wizard-steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
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
        }
    </style>
@endpush

<h3 class="mb-4">Dynamic Wizard Form</h3>

<!-- نمایش مراحل -->
<div class="wizard-steps">
    @foreach (range(0, $questions->max('page') - 1) as $step)
        <div class="wizard-step-indicator" id="step-indicator-{{ $step }}">
            Step {{ $step + 1 }}
        </div>
    @endforeach
</div>

<!-- فرم ویزارد داخل کارت -->
<div class="card shadow-lg mx-auto" style="max-width: 700px;">
    <div class="card-body">
        <form id="wizardForm" action="{{ $formAction }}" method="POST">
            @csrf
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
        <p>.slider-red input.slider</p>
                    <div class="slider-blue">
                      <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                           data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal"
                           data-slider-selection="before" data-slider-tooltip="show">
                    </div>
        <div class="mb-4">
            <strong>
                <label for="{{ $question->question_key }}" class="form-label">
                    {{ $question->id }} - {{ $question->question }}
                </label>
            </strong>
            @switch($question->answer_type)
                @case('text')
                    <x-FormInputText name="{{ $question->question_key }}" id="{{ $question->question_key }}"
                        label="{{ $question->question }}"
                        value="{{ old($question->question_key, $previousAnswers[$question->question_key] ?? '') }}"
                        required="{{ $question->is_required }}" floating />
                @break

                @case('numeric')
                    @php
                        // تنظیم مقادیر پیش‌فرض
                        $min = 0;
                        $max = 12;
                        $step = 1;

                        // در صورتیکه سوال "height" باشد، مقادیر برای قد انسان تنظیم می‌شود
                        if ($question->question_key === 'height') {
                            $min = 48; // حداقل قد (4 فوت = 48 اینچ)
                            $max = 84; // حداکثر قد (7 فوت = 84 اینچ)
                            $step = 1; // فاصله گام‌ها به اینچ
                        }
                    @endphp
                    <x-FormInputRange name="{{ $question->question_key }}" id="{{ $question->question_key }}"
                        label="{{ $question->question }}" :min="$min" :max="$max" :step="$step"
                        value="{{ old($question->question_key, $previousAnswers[$question->question_key] ?? 48) }}"
                        required="{{ $question->is_required }}" />
                @break

                @case('textarea')
                    <textarea class="form-control form-control-sm" name="{{ $question->question_key }}"
                        @if ($question->is_required) required @endif>{{ old($question->question_key, $previousAnswers[$question->question_key] ?? '') }}</textarea>
                @break

                @case('radio')
                    @foreach ($question->options as $option)
                        <div>
                            <input type="radio" id="{{ $option->question_key }}" name="{{ $question->question_key }}"
                                value="{{ $option->option_value }}" @if ($question->is_required) required @endif
                                @if (old($question->question_key, $previousAnswers[$question->question_key] ?? '') == $option->option_value) checked @endif>
                            <label for="{{ $option->question_key }}">{{ $option->option_value }}</label>
                        </div>
                    @endforeach
                @break

                @case('checkbox')
                    @foreach ($question->options as $option)
                        <div>
                            <input type="checkbox" id="{{ $option->question_key }}" name="{{ $question->question_key }}[]"
                                value="{{ $option->option_value }}" @if (in_array($option->option_value, old($question->question_key, $previousAnswers[$question->question_key] ?? []))) checked @endif
                                @if ($question->is_required) required @endif>
                            <label for="{{ $option->question_key }}">{{ $option->option_value }}</label>
                        </div>
                    @endforeach
                @break

                @case('select')
                    <select class="form-select form-select-sm" name="{{ $question->question_key }}"
                        @if ($question->is_required) required @endif>
                        <option value="">Select an option</option>
                        @foreach ($question->options as $option)
                            <option value="{{ $option->option_value }}" @if (old($question->question_key, $previousAnswers[$question->question_key] ?? '') == $option->option_value) selected @endif>
                                {{ $option->option_value }}
                            </option>
                        @endforeach
                    </select>
                @break

                @case('single_select')
                    @if (count($question->options) < 10)
                        @foreach ($question->options as $option)
                            <div>
                                <input type="radio" id="{{ $option->question_key }}" name="{{ $question->question_key }}"
                                    value="{{ $option->option_value }}" @if ($question->is_required) required @endif
                                    @if (old($question->question_key, $previousAnswers[$question->question_key] ?? '') == $option->option_value) checked @endif>
                                <label for="{{ $option->question_key }}">{{ $option->option_value }}</label>
                            </div>
                        @endforeach
                    @else
                        <select class="form-select form-select-sm" name="{{ $question->question_key }}"
                            @if ($question->is_required) required @endif>
                            <option value="">Select an option</option>
                            @foreach ($question->options as $option)
                                <option value="{{ $option->option_value }}" @if (old($question->question_key, $previousAnswers[$question->question_key] ?? '') == $option->option_value) selected @endif>
                                    {{ $option->option_value }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                @break

                @case('boolean')
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="{{ $question->question_key }}"
                            name="{{ $question->question_key }}" value="1"
                            @if (old($question->question_key, $previousAnswers[$question->question_key] ?? '') == 1) checked @endif
                            @if ($question->is_required) required @endif>
                    </div>
                @break

                @case('multi_select')
                    @foreach ($question->options as $option)
                        <div>
                            <input type="checkbox" id="{{ $option->question_key }}" name="{{ $question->question_key }}[]"
                                value="{{ $option->option_value }}" @if (in_array($option->option_value, old($question->question_key, $previousAnswers[$question->question_key] ?? []))) checked @endif
                                @if ($question->is_required) required @endif>
                            <label for="{{ $option->question_key }}">{{ $option->option_value }}</label>
                        </div>
                    @endforeach
                @break

                @default
                    <p class="text-danger">Invalid question type: {{ $question->answer_type }}</p>
            @endswitch
        </div>

        @if ($loop->last)
    </div> <!-- پایان صفحه آخر -->
    @endif
    @endforeach
    </form>
</div>

<!-- دکمه‌ها در footer کارت -->
<div class="card-footer d-flex justify-content-between">
    <button type="button" class="btn btn-lg btn-secondary px-4" onclick="prevStep()">Back</button>
    <button type="button" class="btn btn-lg btn-primary px-4" onclick="nextStep()">Next</button>
    <button type="submit" class="btn btn-lg btn-success px-4 d-none" id="finishButton">Finish</button>
</div>
</div>

<script>
    // کد برای تغییر صفحه ویزارد
    let currentStep = 0;

    function nextStep() {
        if (currentStep < {{ $questions->max('page') }} - 1) {
            currentStep++;
            updateWizardStep();
        }
    }

    function prevStep() {
        if (currentStep > 0) {
            currentStep--;
            updateWizardStep();
        }
    }

    function updateWizardStep() {
        // پنهان کردن همه مراحل
        document.querySelectorAll('.wizard-step').forEach(function(step) {
            step.classList.add('d-none');
        });

        // نشان دادن مرحله فعلی
        document.getElementById('step-' + currentStep).classList.remove('d-none');

        // بروز رسانی وضعیت دکمه‌ها
        document.querySelectorAll('.wizard-step-indicator').forEach(function(indicator, index) {
            indicator.classList.remove('active');
            if (index <= currentStep) {
                indicator.classList.add('active');
            }
        });

        // نمایش دکمه Finish در آخرین مرحله
        document.getElementById('finishButton').classList.toggle('d-none', currentStep <
            {{ $questions->max('page') }} - 1);
    }

    updateWizardStep();
</script>
