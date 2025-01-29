@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/css/bs-stepper.min.css" rel="stylesheet">
@endpush

<h3 class="mb-4">Dynamic Wizard Form</h3>

<div class="bs-stepper">
    <div class="bs-stepper-header" role="tablist">
        @for ($page = 1; $page < $pageCount + 1; $page++)
            <div class="step" data-target="#step-{{ $page }}">
                <button type="button" class="step-trigger" role="tab" aria-controls="step-{{ $page }}">
                    <span class="bs-stepper-circle">{{ $page }}</span>
                    <span class="bs-stepper-label">Step {{ $page }}</span>
                </button>
            </div>
        @endfor
    </div>

    <div class="bs-stepper-content">
        @foreach ($pages as $index => $page)
            <div id="step-{{ $index }}" class="content" role="tabpanel">
                <h3>Step {{ $index }} </h3>
                @foreach ($page as $question)
                    <div class="pb-3">
                        <strong>{{ $question['id'] }}-{{ $question['question'] }}</strong>
                        @switch($question['answer_type'])
                            @case('text')
                                {{-- @dd($question['question_key']) --}}
                                <x-FormInputText name="{{ $question['question_key'] }}" id="{{ $question['question_key'] }}"
                                    {{-- label="{{ $question['question'] }}" --}} {{-- value="{{ old($question['question_key'], $answers[$question['question_key'] ?? '']) }}" --}} required="{{ $question['is_required'] }}" />
                            @break

                            @case('numeric')
                                @php
                                    $min = 0;
                                    $max = 12;
                                    $step = 1;

                                    if ($question['question_key'] === 'height') {
                                        $min = 48;
                                        $max = 84;
                                        $step = 1;
                                    }
                                @endphp
                                <x-FormInputRange name="{{ $question['question_key'] }}" id="{{ $question['question_key'] }}"
                                    :min="$min" :max="$max" :step="$step" {{-- value="{{ old($question['question_key'], $previousAnswers[$question['question_key']] ?? 48) }}" --}}
                                    required="{{ $question['is_required'] }}" />
                            @break

                            @case('single_select')
                                @if (count($question['options']) < 10)
                                    @foreach ($question['options'] as $option)
                                        <div>
                                            <input type="radio" id="{{ $option['question_key'] }}"
                                                name="{{ $question['question_key'] }}" value="{{ $option['option_value'] }}"
                                                @if ($question['is_required']) required @endif {{-- @if (old($question['question_key'], $previousAnswers[$question['question_key']] ?? '') == $option['option_value']) checked @endif --}}>
                                            <label for="{{ $option['question_key'] }}">{{ $option['option_value'] }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <select class="form-select form-select-sm" name="{{ $question['question_key'] }}"
                                        @if ($question['is_required']) required @endif>
                                        <option value="">Select an option</option>
                                        @foreach ($question['options'] as $option)
                                            <option value="{{ $option['option_value'] }}" {{-- @if (old($question['question_key'], $previousAnswers[$question['question_key']] ?? '') == $option['option_value']) selected @endif --}}>
                                                {{ $option['option_value'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            @break

                            @case('boolean')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="{{ $question['question_key'] }}"
                                        name="{{ $question['question_key'] }}" value="1" {{-- @if (old($question['question_key'], $previousAnswers[$question['question_key']] ?? '') == 1) checked @endif --}}
                                        @if ($question['is_required']) required @endif>
                                </div>
                            @break
                        @endswitch
                    </div>
                @endforeach
                <div class="d-flex justify-content-between">
                    @if($index > 1)
                        <button class="btn btn-secondary prev-step">Prev Page</button>
                    @endif
                    @if($index < $pageCount )
                        <button class="btn btn-success next-step" id="next-step">Next Page</button>
                    @endif
                    @if($index == $pageCount )
                        <button class="btn btn-success" id="publish-button">Publish</button>
                    @endif
                </div>
            </div>
            
        @endforeach
    </div>

</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bs-stepper@1.7.0/dist/js/bs-stepper.min.js"></script>

<script>
    // راه‌اندازی bs-stepper
    const stepper = new Stepper(document.querySelector('.bs-stepper'), {
        linear: false, // اجازه نمی‌دهیم مراحل به صورت خطی طی شوند
        animation: true // انیمیشن بین مراحل فعال است
    });

    // مدیریت کلیک روی دکمه‌های Next و Previous
    document.querySelector('.bs-stepper').addEventListener('click', function(event) {
        // بررسی کلیک روی دکمه‌های Next
        if (event.target.classList.contains('btn') && event.target.classList.contains('next-step')) {
            console.log('Next button clicked');
            stepper.next();
        }

        // بررسی کلیک روی دکمه‌های Prev
        if (event.target.classList.contains('btn') && event.target.classList.contains('prev-step')) {
            console.log('Prev button clicked');
            stepper.previous();
        }
    });

    // مدیریت دکمه Publish در صفحه آخر
    document.querySelector('#publish-button')?.addEventListener('click', () => {
        alert('مراحل با موفقیت ثبت شدند!');
    });
</script>
@endpush
