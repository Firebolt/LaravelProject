<textarea {{ $disabled ?? ''}} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) !!}>
    {{ $value ?? '' }}
</textarea>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('.autoexpand');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', autoExpand);
            });

            function autoExpand(e) {
                e.target.style.height = 'inherit';
                const computed = window.getComputedStyle(e.target);
                const height = parseInt(computed.getPropertyValue('border-top-width'), 10)
                                + parseInt(computed.getPropertyValue('padding-top'), 10)
                                + e.target.scrollHeight
                                + parseInt(computed.getPropertyValue('padding-bottom'), 10)
                                + parseInt(computed.getPropertyValue('border-bottom-width'), 10);

                e.target.style.height = height + 'px';
            }
        });
    </script>
@endpush