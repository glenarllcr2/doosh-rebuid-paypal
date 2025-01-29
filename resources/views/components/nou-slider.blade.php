{{-- 
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/nouislider/distribute/nouislider.min.css" rel="stylesheet">
@endpush

<div id="{{ $id }}_container" class="{{ $class }}" style="{{ $style }}"></div>
<input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ json_encode($options['start']) }}">

@push('scripts')
    @once
        <!-- noUiSlider JS -->
        <script src="https://cdn.jsdelivr.net/npm/nouislider/distribute/nouislider.min.js" defer></script>
    @endonce
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('init');
            
            const slider = document.getElementById('{{ $id }}_container');
            const hiddenInput = document.getElementById('{{ $id }}');
            const options = {!! json_encode($options) !!};

            const tooltip = {!! json_encode($tooltipFormat) !!};
            console.log(tooltip)
            
            // تنظیم tooltips با توابع جاوا اسکریپت
            options.tooltips = [
                {
                    to: function(value) { return value.toFixed(1) + " ft"; }
                },
                {
                    to: function(value) { return value.toFixed(1) + " ft"; }
                }
            ];

            noUiSlider.create(slider, options);

            // همگام‌سازی مقدار با hidden input
            slider.noUiSlider.on('update', (values) => {
                hiddenInput.value = JSON.stringify(values);
            });
        });
    </script>
@endpush --}}
