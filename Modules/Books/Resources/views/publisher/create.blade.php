@extends('layouts.admin')

@section('title', '| Add Publisher')
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
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
        /*      images_upload_url: '../../public/images/publishers/upload',*/
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

        <h5><i class='fa fa-newspaper-o'></i> ناشر جدید </h5>
        <hr>
        @if (\Session::has('flash_success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('flash_success') !!}</li>
                </ul>
            </div>
            <a class="btn btn-secondary" href="{{ route('publisher.list') }}" role="button">لیست ناشران</a>
        @elseif (\Session::has('flash_error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('flash_error') !!}</li>
                </ul>
            </div>
            <a class="btn btn-secondary" href="{{ route('publisher.list') }}" role="button">لیست ناشران</a>
        @else
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            @endif

            {{ Form::open(array('url' => 'publisher','method'=>'POST', 'files'=>true)) }}

            <div class="form-group">
                {{ Form::label('name', 'نام') }}
                {{ Form::text('name', '', array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('description', 'توضیحات') }}
                {{ Form::textarea('description', '', array('class' => 'form-control my-editor')) }}
            </div>

            <div class="form-group">
                {{ Form::label('porder', 'ترتیب') }}
                {{ Form::text('porder', '', array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('status', 'وضعیت') }}
                {{ Form::select('status', array('E' => 'فعال', 'D' => 'غیرفعال'), array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('avatar', 'تصویر') }}
                {{ Form::file('avatar') }}
            </div>

            {!! Form::hidden('page', request()->get('page' , 1)) !!}



            {{ Form::submit('ایجاد', array('class' => 'btn btn-primary')) }}
            <a class="btn btn-secondary" href="{{ route('publisher.list') }}?page={{ request()->get('page' , 1) }}" role="button">بازگشت</a>

            {{ Form::close() }}
    @endif
    </div>

@endsection