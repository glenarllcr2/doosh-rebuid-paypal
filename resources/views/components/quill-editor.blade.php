@push('styles')
    @once
        <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill-emoji/dist/quill-emoji.css">
    @endonce
@endpush

<div id="{{ $id }}" style="{{ $style }}"></div>
<textarea id="{{ $id }}_hidden" name="{{ $name }}" hidden></textarea>

@push('scripts')
    @once
        <!-- Quill JS -->
        <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
        <!-- Emoji Plugin -->
        <script src="https://cdn.jsdelivr.net/npm/quill-emoji/dist/quill-emoji.min.js"></script>
    @endonce

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Quill Editor
            const editor = new Quill('#{{ $id }}', {
                theme: 'snow',
                placeholder: 'Start writing here...',
                modules: {
                    toolbar: {
                        container: [
                            ['bold', 'italic', 'underline'], // Styling buttons
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }], // Lists
                            ['link', 'image', 'video'], // Insert options
                            ['emoji'], // Emoji button
                            ['clean'] // Remove formatting
                        ],
                        handlers: {
                            'emoji': function() {} // Enable emoji handler
                        }
                    },
                    'emoji-toolbar': true, // Enable emoji toolbar
                    'emoji-textarea': false, // Disable emoji textarea
                    'emoji-shortname': true // Enable emoji autocomplete with shortnames
                }
            });

            // Update hidden textarea before form submission
            const hiddenField = document.querySelector('#{{ $id }}_hidden');
            const form = hiddenField.closest('form');
            if (form) {
                form.addEventListener('submit', function() {
                    hiddenField.value = editor.root.innerHTML; // Copy content to hidden field
                });
            }
        });
    </script>
@endpush
