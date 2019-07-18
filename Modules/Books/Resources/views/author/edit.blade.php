@extends('layouts.admin')

@section('title', '| Edit author')
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
  /*      images_upload_url: '../../public/images/authors/upload',*/
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

        <h4><i class='fa fa-user-plus'></i> ویرایش</h4>
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
            {{ Form::model($author, array('route' => array('author.update', $author->id), 'method' => 'PUT', 'files'=>true)) }}{{-- Form model binding to automatically populate our fields with user data --}}
            <div class="row" >
                <div class="col-lg-6 col-lg-offset-1">
                    <div class="form-group">
                        {{ Form::label('name', 'نام') }}
                        {{ Form::text('name', null, array('class' => 'form-control')) }}
                    </div>


                    <div class="form-group">
                        {{ Form::label('nationality', 'ملیت') }}
                        {{ Form::text('nationality', null, array('class' => 'form-control')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('birthdate', 'تاریخ تولد') }}
                        {{ Form::text('birthdate', null, array('class' => 'form-control')) }}
                    </div>
                </div>
                <div class="col-lg-5">
                        <div style="margin-top: 8px;margin-bottom: 5px;">
                            @if($author->avatar != '' && file_exists(public_path().'/images/authors/'.$author->avatar))
                                <img src="{{ asset('/images/authors/' . $author->avatar) }}" style="width: 100%"  />
                            @else
                                <img src="{{ asset('/images/authors/avatar.png') }}" style="width: 100%"  />
                            @endif
                        </div>

                </div>
            </div>


            <div class="form-group">
                {{ Form::label('description', 'توضیحات') }}
                {{ Form::textarea('description', null, array()) }}
            </div>

            <div class="form-group">
                {{ Form::label('aorder', 'ترتیب') }}
                {{ Form::text('aorder', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('status', 'وضعیت') }}
                {{ Form::select('status', array('E' => 'فعال', 'D' => 'غیرفعال'),$author->status, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('avatar', 'تصویر') }}
                {{ Form::file('avatar') }}
            </div>


            {!! Form::hidden('page', request()->get('page')) !!}
            {!! Form::hidden('s_user_id', request()->get('s_user_id')) !!}
            {!! Form::hidden('s_name', request()->get('s_name')) !!}
            {!! Form::hidden('s_status', request()->get('s_status')) !!}
            {!! Form::hidden('s_nationality', request()->get('s_nationality')) !!}

            {{ Form::submit('ویرایش', array('class' => 'btn btn-primary')) }}
            <a class="btn btn-secondary" href="{{ route('author.list') }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_name={{request()->get('s_name')}}&s_nationality={{request()->get('s_nationality')}}" role="button">بازگشت</a>
            {{ Form::close() }}
    </div>

@endsection