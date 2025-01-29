<div>
    <!-- اسلایدر با ویژگی id و name -->
    <div id="{{ $id }}" name="{{ $name }}" class="slider-container"></div>

    <!-- فیلد مخفی برای ذخیره مقادیر اسلایدر -->
    <input type="hidden" id="{{ $id }}_values" name="{{ $name }}_values">

    <!-- عنصر برای نمایش مقادیر -->
    {{-- <div id="{{ $id }}_values_display" class="output"></div> --}}
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('{{ $id }}');
        const hiddenInput = document.getElementById('{{ $id }}_values'); // فیلد مخفی برای ذخیره مقادیر
        const rangeValuesDisplay = document.getElementById('{{ $id }}_values_display'); // عنصر برای نمایش مقادیر

        // دریافت پارامترهای کامپوننت از Blade
        const min = {{ $min }}; // مقدار حداقل (بر حسب اینچ)
        const max = {{ $max }}; // مقدار حداکثر (بر حسب اینچ)
        const start = {{ json_encode($start) }}; // مقادیر شروع
        const decimal = {{ $decimal ? 'true' : 'false' }};
        const showTooltip = {{ $showTooltip ? 'true' : 'false' }};
        const tooltipSuffix = '{{ $tooltipSuffix }}';
        const format = '{{ $format }}'; // دریافت فرمت از پارامتر

        // راه‌اندازی noUiSlider
        noUiSlider.create(slider, {
            start: start,            // مقادیر اولیه اسلایدر
            connect: true,           // اتصال دو بخش
            range: {
                'min': min,          // مقدار حداقل (بر حسب اینچ)
                'max': max           // مقدار حداکثر (بر حسب اینچ)
            },
            tooltips: showTooltip,   // نمایش tooltips
            step: decimal ? 0.1 : 1, // گام‌ها (صحیح یا اعشاری)
            format: {
                to: function(value) {
                    if (format === 'feet') {
                        // تبدیل به فرمت feet/inches
                        const feet = Math.floor(value / 12);
                        const inches = Math.round(value % 12);
                        if (isNaN(feet) || isNaN(inches)) return "0' 0\""; // اگر مقادیر اشتباه بود
                        return `${feet}' ${inches}"`;
                    }
                    return decimal ? value.toFixed(1) : Math.round(value);
                },
                from: function(value) {
                    if (format === 'feet') {
                        // بررسی فرمت ورودی feet/inches
                        const parts = value.split("'"); // جداسازی feet و inches
                        if (parts.length < 2) return 0; // اگر فرمت اشتباه باشد، مقدار پیش‌فرض صفر باز می‌گرداند
                        const feet = parseInt(parts[0]);
                        const inches = parseInt(parts[1].replace('"', '').trim());
                        return feet * 12 + inches; // تبدیل به اینچ
                    }
                    return decimal ? parseFloat(value) : parseInt(value);
                }
            }
        });

        // بروزرسانی مقادیر اسلایدر
        slider.noUiSlider.on('update', function (values) {
            const formattedValues = values.map(function(value) {
                let formattedValue = value;
                if (format === 'feet') {
                    // تبدیل به فرمت feet/inches
                    const feet = Math.floor(value / 12);
                    const inches = Math.round(value % 12);
                    if (isNaN(feet) || isNaN(inches)) {
                        formattedValue = "Invalid value"; // اگر مقادیر نادرست باشد
                    } else {
                        formattedValue = `${feet}' ${inches}"`;
                    }
                } else {
                    formattedValue = `${parseFloat(value)}${tooltipSuffix}`;
                }
                return formattedValue;
            }).join(' - ');

            // بروزرسانی فیلد مخفی
            hiddenInput.value = values.join(','); // ذخیره مقادیر اسلایدر در فیلد مخفی

            // نمایش مقادیر در عنصر
            if (rangeValuesDisplay) {
                rangeValuesDisplay.innerText = formattedValues; // نمایش مقادیر در زیر اسلایدر
            }
        });
    });
</script>
