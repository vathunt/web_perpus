@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('coba/css/imgareaselect-default.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<!-- Froala Editor -->
<link href="{{ asset('assets/vendors/froala-editor/froala_editor.pkgd.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success">{{session('success')}}</div>
@endif

<div class="container mt-5">
    <form action="{{ url('image') }}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleInputImage">Image:</label>
            <input type="file" name="profile_image" id="exampleInputImage" class="image" required>
            <input type="hidden" name="x1" value="" />
            <input type="hidden" name="y1" value="" />
            <input type="hidden" name="w" value="" />
            <input type="hidden" name="h" value="" />
        </div>
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
    <div class="row mt-5">
        <p><img id="previewimage" style="display:none;" /></p>
        @if(session('path'))
        <img src="{{ session('path') }}" />
        @endif
    </div>
</div>

<div class="container mt-5">
    <div class="form-group">
        <label for="exampleInputImage">Isi Berita:</label>
        <textarea name="detailPengumuman" id="detailPengumuman" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</div>
@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('coba/scripts/jquery.imgareaselect.dev.js') }}"></script>
<script>
jQuery(function($) {
    var p = $("#previewimage");

    $("body").on("change", ".image", function() {
        var imageReader = new FileReader();
        imageReader.readAsDataURL(document.querySelector(".image").files[0]);

        imageReader.onload = function(oFREvent) {
            p.attr('src', oFREvent.target.result).fadeIn();
        };
    });

    $('#previewimage').imgAreaSelect({
        maxWidth: '1600', // this value is in pixels
        maxHeight: '800',
        onSelectEnd: function(img, selection) {
            $('input[name="x1"]').val(selection.x1);
            $('input[name="y1"]').val(selection.y1);
            $('input[name="w"]').val(selection.width);
            $('input[name="h"]').val(selection.height);
        }
    });
});
</script>

<!-- Froala Editor -->
<script type="text/javascript" src="{{ asset('assets/vendors/froala-editor/froala_editor.pkgd.min.js') }}"></script>

<script>
new FroalaEditor('#detailPengumuman', {
    "charCounterCount": true,
    "toolbarButtons": [
        'undo', 'redo', 'clearFormatting', '|',
        'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'paragraphStyle',
        'lineHeight', '|',
        'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|',
        'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-',
        'insertLink',
        'insertImage', 'insertTable', '|',
        'specialCharacters', 'insertHR', 'selectAll', '|',
        'spellChecker', 'help', 'html', '|',
    ],
    "tabSpaces": 4,
    "fontFamilyDefaultSelection": "Arial",
    "fontFamilySelection": true,
    "fontSizeSelection": true,
    "fontSizeDefaultSelection": "12",
    "fontSizeUnit": "px",
    "autofocus": true,
    "attribution": false,
    "linkAlwaysBlank": true,
    "paragraphDefaultSelection": "Normal",
    "paragraphFormatSelection": true,
    "quickInsertButtons": ['table', 'ol', 'ul', 'hr'],
    "language": "id",
    "imageEditButtons": ['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen',
        'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageStyle', 'imageAlt', 'imageSize'
    ],

    // Set the image upload parameter.
    "imageUploadParam": 'image_param',

    // Set the image upload URL.
    "imageUploadURL": "{{ route('upload_gambar') }}",

    // Additional upload params.
    "imageUploadParams": {
        "froala": 'true',
        "_token": "{{ csrf_token() }}"
    },

    // Set request type.
    "imageUploadMethod": 'POST',

    // Set max image size to 5MB.
    "imageMaxSize": 5 * 1024 * 1024,

    // Allow to upload PNG and JPG.
    "imageAllowedTypes": ['jpeg', 'jpg', 'png', 'gif']
});
</script>
@endsection