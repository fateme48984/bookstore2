@extends('layouts.admin')

@section('title', '| Edit slider')

@section('content')

    <div class='col-lg-7 col-lg-offset-4'>

        <h4><i class='fa fa-stack-exchange'></i> ویرایش</h4>
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
            {{ Form::model($slider, array('route' => array('slider.update', $slider->id), 'method' => 'PUT', 'files'=>true)) }}{{-- Form model binding to automatically populate our fields with user data --}}



        <div class="form-group">
            {{ Form::label('sec_id', 'قسمت') }}
            {{ Form::select('sec_id', array(1 => 'اسلایدر تصویری', 2 => 'اسلایدر متنی'),$slider->sec_id, array('class' => 'form-control')) }}
        </div>

                @if($slider->sec_id == 1 && $slider->avatar != '' && file_exists(public_path().'/images/sliders/'.$slider->avatar))
                    <div class="col-lg-5">
                        <div style="margin-top: 8px;margin-bottom: 5px;">
                            <img src="{{ asset('/images/sliders/' . $slider->avatar) }}" style="width: 100%"  />
                            </div>
                        </div>

                @endif


        <div class="form-group">
            {{ Form::label('text', 'متن') }}
            {{ Form::textarea('text', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('sorder', 'ترتیب') }}
            {{ Form::text('sorder', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('status', 'وضعیت') }}
            {{ Form::select('status', array('E' => 'فعال', 'D' => 'غیرفعال'),$slider->status, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('avatar', 'تصویر') }}
            {{ Form::file('avatar') }}
        </div>


            {!! Form::hidden('page', request()->get('page')) !!}
            {!! Form::hidden('s_sec_id', request()->get('s_sec_id')) !!}
            {!! Form::hidden('s_status', request()->get('s_status')) !!}

            {{ Form::submit('ویرایش', array('class' => 'btn btn-primary')) }}
            <a class="btn btn-secondary" href="{{ route('slider.list') }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_sec_id={{request()->get('s_sec_id')}}" role="button">بازگشت</a>
            {{ Form::close() }}
    </div>

@endsection