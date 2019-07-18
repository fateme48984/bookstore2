@extends('layouts.admin')

@section('title', '| Edit setting')
<script src="{{ asset('/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({selector:'textarea',
        directionality : "rtl",
        menubar:false,
        content_css : "/css/editor.css",
        font_formats :'Arial Black=arial black,avant garde;Helvetica=helvetica;Times New Roman=times new roman,times;Verdana=verdana,geneva;Tahoma=tahoma,arial,helvetica,sans-serif;IRANSans=IRANSans;nassim-bold=nassim-bold;RTNassim=RTNassim;',
        toolbar: "fullscreen | undo redo | insert | styleselect | bold italic underline strikethrough | ltr rtl | alignleft aligncenter alignright alignjustify outdent indent bullist numlist | fontselect fontsizeselect | forecolor backcolor removeformat | link unlink table | insertfile image",
        height : "480",
        plugins: "image imagetools",
        image_title: true,
        automatic_uploads: true,
  /*      images_upload_url: '../../public/images/settings/upload',*/
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        }

    });

</script>
@section('content')

    <div class='col-lg-7 col-lg-offset-4'>
        <?php
            if($setting->id == 1) {
                $val = 'درباره ما ';
            } elseif($setting->id == 2) {
                $val = 'تماس با ما';
            }
            ?>
        <h4><i class='fa fa-cog'></i> ویرایش {{$val}} </h4>
        <hr>
        @if (\Session::has('flash_success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('flash_success') !!}</li>
                </ul>
            </div>
        @elseif (\Session::has('flash_error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('flash_error') !!}</li>
                </ul>
            </div>
        @endif
            @if (\Session::has('flash_message'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{!! \Session::get('flash_message') !!}</li>
                    </ul>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{ Form::model($setting, array('route' => array('setting.update', $setting->id), 'method' => 'PUT', 'files'=>true)) }}{{-- Form model binding to automatically populate our fields with user data --}}



            <div class="form-group">
                {{ Form::label('description', 'توضیحات') }}
                {{ Form::textarea('description', null, array()) }}
            </div>




            {{ Form::submit('ویرایش', array('class' => 'btn btn-primary')) }}
            {{ Form::close() }}
    </div>

@endsection