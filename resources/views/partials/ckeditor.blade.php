{{--
    CKEditor 5 untuk textarea #editor.

    Dulu dimuat pada layout mentor, sehingga setiap halaman mentor menarik
    bundel editor dari CDN meskipun hanya dua form yang memakainya.
    Sertakan partial ini pada halaman yang benar-benar butuh.
--}}
@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
@endpush

@push('scripts')
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.0.0/"
            }
        }
    </script>
    <script type="module">
        import {
            ClassicEditor, Essentials, Paragraph, Bold, Italic, Link, List, Heading, BlockQuote
        } from 'ckeditor5';

        const target = document.querySelector('#editor');

        if (target) {
            ClassicEditor
                .create(target, {
                    plugins: [Essentials, Paragraph, Bold, Italic, Link, List, Heading, BlockQuote],
                    // 'fontSize' was listed in the toolbar without its plugin
                    // being loaded, which made CKEditor refuse to start.
                    toolbar: ['heading', '|', 'bold', 'italic', 'link',
                        '|', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
                })
                .catch((error) => console.error(error));
        }
    </script>
@endpush
