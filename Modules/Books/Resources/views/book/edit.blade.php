@extends('layouts.admin')

@section('title', '| Edit Book')
<script src="{{ asset('/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({selector:'textarea#my-editor',
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
            {{ Form::model($book, array('route' => array('book.update', $book->id), 'method' => 'PUT', 'files'=>true)) }}{{-- Form model binding to automatically populate our fields with user data --}}
            <div class="row" >
                <div class="col-lg-6 col-lg-offset-1">
                    <div class="form-group">
                        {{ Form::label('title', 'عنوان') }}
                        {{ Form::text('title', null, array('class' => 'form-control')) }}
                    </div>



                    <div class="form-group">
                        {{ Form::label('author_id', 'نویسنده', array('class' => 'col-2')) }}

                        <?php
                        foreach ($authors as $key=>$author) {
                            $authorArr[$author['id'] ]=$author['name'];
                        }

                        ?>
                        {{ Form::select('author_id', $authorArr,$book->author_id, array('class' => 'form-control col-10')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('category_id', 'موضوع', array('class' => 'col-2')) }}

                        <?php
                        foreach ($categories as $key=>$cat) {
                            $catArr[$cat['id'] ]=$cat['name'];
                        }

                        ?>
                        {{ Form::select('category_id', $catArr, $book->category_id,array('class' => 'form-control col-10')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('publisher_id', 'ناشر', array('class' => 'col-2')) }}

                        <?php
                        foreach ($publishers as $key=>$publisher) {
                            $publisherArr[$publisher['id'] ]=$publisher['name'];
                        }

                        ?>
                        {{ Form::select('publisher_id', $publisherArr,$book->publisher_id, array('class' => 'form-control col-10')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::label('translator_id', 'مترجم', array('class' => 'col-2')) }}

                        <?php
                        $translatorArr[0] = '';
                        foreach ($translators as $key=>$translator) {
                            $translatorArr[$translator['id'] ]=$translator['name'];
                        }

                        ?>
                        {{ Form::select('translator_id', $translatorArr,$book->translator_id, array('class' => 'form-control col-10')) }}
                    </div>
                </div>
                <div class="col-lg-5">
                        <div style="margin-top: 8px;margin-bottom: 5px;">
                            @if($book->avatar != '' && file_exists(public_path().'/images/books/'.$book->avatar))
                                <img src="{{ asset('/images/books/' . $book->avatar) }}" style="width: 100%"  />
                            @else
                                <img src="{{ asset('/images/books/avatar.png') }}" style="width: 100%"  />
                            @endif
                        </div>

                </div>
            </div>


        


        <div class="form-group">
            {{ Form::label('summary', 'خلاصه') }}
            {{ Form::textarea('summary',null, array('class' => 'form-control', 'rows' => 5, 'cols' => 30)) }}
        </div>

        <div class="form-group">
            {{ Form::label('description', 'توضیحات') }}
            {{ Form::textarea('description', null, array('id' => 'my-editor')) }}
        </div>

        <div class="form-group">
            {{ Form::label('border', 'ترتیب') }}
            {{ Form::text('border', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('status', 'وضعیت') }}
            {{ Form::select('status', array('E' => 'فعال', 'D' => 'غیرفعال'),$book->status, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('avatar', 'تصویر اصلی') }}
            {{ Form::file('avatar') }}
        </div>

        <div class="form-group">
            {{ Form::label('image1', 'تصویر اول') }}
            {{ Form::file('image1') }}
        </div>


        <div class="form-group">
            {{ Form::label('image2', 'تصویر دوم') }}
            {{ Form::file('image2') }}
        </div>


        {!! Form::hidden('page', request()->get('page')) !!}
            {!! Form::hidden('s_user_id', request()->get('s_user_id')) !!}
            {!! Form::hidden('s_title', request()->get('s_title')) !!}
            {!! Form::hidden('s_status', request()->get('s_status')) !!}
            {!! Form::hidden('s_author_id', request()->get('s_author_id')) !!}
            {!! Form::hidden('s_category_id', request()->get('s_category_id')) !!}
            {!! Form::hidden('s_publisher_id', request()->get('s_publisher_id')) !!}
            {!! Form::hidden('s_translator_id', request()->get('s_translator_id')) !!}

            {{ Form::submit('ویرایش', array('class' => 'btn btn-primary')) }}
            <a class="btn btn-secondary" href="{{ route('book.list') }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_title={{request()->get('s_title')}}&s_category_id={{request()->get('s_category_id')}}&s_author_id={{request()->get('s_author_id')}}&s_publisher_id={{request()->get('s_publisher_id')}}&s_translator_id={{request()->get('s_translator_id')}}" role="button">بازگشت</a>
            {{ Form::close() }}
    </div>

@endsection