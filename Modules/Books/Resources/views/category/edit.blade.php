@extends('layouts.admin')

@section('title', '| Edit category')
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
  /*      images_upload_url: '../../public/images/translators/upload',*/
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

        <h4><i class='fa fa-list'></i> ویرایش</h4>
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
            {{ Form::model($category, array('route' => array('category.update', $category->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with user data --}}
            <div class="form-group">
                {{ Form::label('name', 'نام') }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('corder', 'ترتیب') }}
                {{ Form::text('corder', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('status', 'وضعیت') }}
                {{ Form::select('status', array('E' => 'فعال', 'D' => 'غیرفعال'),$category->status, array('class' => 'form-control')) }}
            </div>


            {!! Form::hidden('page', request()->get('page')) !!}
            {!! Form::hidden('s_user_id', request()->get('s_user_id')) !!}
            {!! Form::hidden('s_name', request()->get('s_name')) !!}
            {!! Form::hidden('s_status', request()->get('s_status')) !!}

            {{ Form::submit('ویرایش', array('class' => 'btn btn-primary')) }}
            <a class="btn btn-secondary" href="{{ route('category.list') }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_name={{request()->get('s_name')}}" role="button">بازگشت</a>
            {{ Form::close() }}
    </div>

@endsection