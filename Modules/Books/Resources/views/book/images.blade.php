@extends('layouts.admin')

@section('title', '| Edit Book')

@section('content')

    <div class='col-lg-9 col-lg-offset-3'>
        <h4><i class='fa fa-user-plus'></i> تصاویر</h4>
        <hr>
        <div class="row">
            @if($book->image1 != '')
            <div class="col-lg-6" style="margin-bottom: 7px;">
                <div style="padding: 3px; border: 1px solid #1b4b72;margin-bottom: 3px;">
                    <img src="/images/books/{{$book->image1}}" style="width: 100%">
                </div>
                {!! Form::open(['method' => 'DELETE', 'route' => ['book.deleteImage',$book->id,'image1', $book->image1] ]) !!}

                {!! Form::hidden('page', request()->get('page' , 1)) !!}
                {!! Form::hidden('s_status', request()->get('s_status')) !!}
                {!! Form::hidden('s_title', request()->get('s_title')) !!}
                {!! Form::hidden('s_author_id', request()->get('s_author_id')) !!}
                {!! Form::hidden('s_category_id', request()->get('s_category_id')) !!}
                {!! Form::hidden('s_publisher_id', request()->get('s_publisher_id')) !!}
                {!! Form::hidden('s_translator_id', request()->get('s_translator_id')) !!}
                {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-width']) !!}
                {!! Form::close() !!}
            </div>
            @endif

                @if($book->image2 != '')
                    <div class="col-lg-6" >
                        <div style="padding: 3px; border: 1px solid #1b4b72;margin-bottom: 3px;">
                            <img src="/images/books/{{$book->image2}}" style="width: 100%">
                        </div>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['book.deleteImage',$book->id, 'image2', $book->image2] ]) !!}

                        {!! Form::hidden('page', request()->get('page' , 1)) !!}
                        {!! Form::hidden('s_status', request()->get('s_status')) !!}
                        {!! Form::hidden('s_title', request()->get('s_title')) !!}
                        {!! Form::hidden('s_author_id', request()->get('s_author_id')) !!}
                        {!! Form::hidden('s_category_id', request()->get('s_category_id')) !!}
                        {!! Form::hidden('s_publisher_id', request()->get('s_publisher_id')) !!}
                        {!! Form::hidden('s_translator_id', request()->get('s_translator_id')) !!}
                        {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-width']) !!}
                        {!! Form::close() !!}
                    </div>
                @endif
        </div>

        <a class="btn btn-secondary" href="{{ route('book.list') }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_title={{request()->get('s_title')}}&s_category_id={{request()->get('s_category_id')}}&s_author_id={{request()->get('s_author_id')}}&s_publisher_id={{request()->get('s_publisher_id')}}&s_translator_id={{request()->get('s_translator_id')}}" role="button">بازگشت</a>

    </div>
@endsection