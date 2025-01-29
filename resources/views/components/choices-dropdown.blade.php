@push('styles')
    @once
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    @endonce
@endpush

{{-- @dd($receiverUser->profile_image) --}}
<div class="form-group" style="{{ $styles }}">
    <select id="{{ $id }}" name="{{ $name }}" class="form-control">
        <option value="" selected disabled>{{ $placeholder }}</option>
        @if ($receiverUser)
            <option value="{{ $receiverUser->id }}" selected>
                <img src="{{ asset('storage') }}/{{ $receiverUser->profile_image }}" alt="Profile Image" style="width: 24px; height: 24px; border-radius: 50%; margin-right: 8px;">
                {{ $receiverUser->display_name }}
            </option>
        @endif
    </select>
</div>

@push('scripts')
    @once
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    @endonce
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectElement = document.querySelector('#{{ $id }}');

            const choices = new Choices(selectElement, {
                placeholder: {{ $searchEnabled ? 'true' : 'false' }},
                searchEnabled: {{ $searchEnabled ? 'true' : 'false' }},
                searchPlaceholderValue: '{{ $searchPlaceholderValue }}',
                noResultsText: '{{ $noResultsText }}',
                shouldSort: {{ $shouldSort ? 'true' : 'false' }},
                removeItemButton: {{ $removeItemButton ? 'true' : 'false' }},
                itemSelectText: '',
                allowHTML: true,
            });

            let debounceTimeout;

            selectElement.addEventListener('search', (event) => {
                const searchValue = event.detail.value;

                if (searchValue.length < 3) return; // حداقل ۳ کاراکتر برای جستجو

                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    fetchOptions(searchValue, choices);
                }, 300); // Debounce 300ms
            });

            function fetchOptions(query, choices) {
                fetch('{{ $searchUrl }}?query=' + encodeURIComponent(query), {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        choices.clearChoices(); // پاک کردن گزینه‌های قبلی

                        if (data.length) {
                            const options = data.map(item => ({
                                value: item.id,
                                //label: `<img src="${user.profile_photo_url}" alt="Profile Photo" style="width:30px;height:30px;border-radius:50%;"> ${item.profile_image}`,
                                label: `<img src="{{ asset('storage') }}/${item.profile_image}" alt="Profile Image" style="width: 24px; height: 24px; border-radius: 50%; margin-right: 8px;"> ${item.display_name}`, // Add image and name
                                selected: false,
                            }));
                            choices.setChoices(options);
                        } else {
                            choices.setChoices([{
                                value: '',
                                label: '{{ $noResultsText }}',
                                disabled: true
                            }]);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching options:', error);
                        choices.setChoices([{
                            value: '',
                            label: 'Error loading data',
                            disabled: true
                        }]);
                    });
            }
        });
    </script>
@endpush
