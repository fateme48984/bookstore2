@extends('layouts.admin')

@section('title', '| Add Slider')

@section('content')

    <div class='col-lg-7 col-lg-offset-4'>

        <h5><i class='fa fa-stack-exchange'></i> اسلایدر جدید</h5>
        <hr>
        @if (\Session::has('flash_success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('flash_success') !!}</li>
                </ul>
            </div>
            <a class="btn btn-secondary" href="{{ route('slider.list') }}" role="button">لیست اسلایدرها</a>
        @elseif (\Session::has('flash_error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('flash_error') !!}</li>
                </ul>
            </div>
            <a class="btn btn-secondary" href="{{ route('slider.list') }}" role="button">لیست اسلایدرها</a>
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

            {{ Form::open(array('url' => 'slider','method'=>'POST', 'files'=>true)) }}

            <div class="form-group">
                {{ Form::label('sec_id', 'قسمت') }}
                {{ Form::select('sec_id', array(1 => 'اسلایدر تصویری', 2 => 'اسلایدر متنی'), array('class' => 'form-control')) }}
            </div>



            <div class="form-group">
                {{ Form::label('text', 'متن') }}
                {{ Form::textarea('text', '', array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('sorder', 'ترتیب') }}
                {{ Form::text('sorder', '', array('class' => 'form-control')) }}
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
            <a class="btn btn-secondary" href="{{ route('slider.list') }}?page={{ request()->get('page' , 1) }}" role="button">بازگشت</a>

            {{ Form::close() }}
    @endif
    </div>

@endsection