@extends('layouts.admin')

@section('title', '| Add User')

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h4><i class='fa fa-user-plus'></i> ایجاد کاربر</h4>
        <hr>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{ Form::open(array('url' => 'user')) }}

        <div class="form-group">
            {{ Form::label('name', 'نام') }}
            {{ Form::text('name', '', array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('email', 'پست الکترونیک') }}
            {{ Form::email('email', '', array('class' => 'form-control')) }}
        </div>

     {{--   <div class='form-group'>
            @foreach ($roles as $role)
                {{ Form::checkbox('roles[]',  $role->id ) }}
                {{ Form::label($role->name, ucfirst($role->name)) }}<br>

            @endforeach
        </div>--}}

        <div class="form-group">
            {{ Form::label('password', 'رمز عبور') }}<br>
            {{ Form::password('password', array('class' => 'form-control')) }}

        </div>

        <div class="form-group">
            {{ Form::label('password', 'تکرار رمز عبور') }}<br>
            {{ Form::password('password_confirmation', array('class' => 'form-control')) }}

        </div>

        {{ Form::submit('ایجاد', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>

@endsection