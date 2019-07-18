@extends('layouts.admin')

@section('title', '| Edit User')

@section('content')

    <div class='col-lg-4 col-lg-offset-4'>

        <h4><i class='fa fa-user-plus'></i> ویرایش</h4>
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
        {{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with user data --}}

        <div class="form-group">
            {{ Form::label('name', 'نام') }}
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('email', 'پست الکترونیک') }}
            {{ Form::email('email', null, array('class' => 'form-control')) }}
        </div>

{{--        <h5><b>Give Role</b></h5>

        <div class='form-group'>
            @foreach ($roles as $role)
                {{ Form::checkbox('roles[]',  $role->id, $user->roles ) }}
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

        {{ Form::submit('ویرایش', array('class' => 'btn btn-primary')) }}
        <a class="btn btn-secondary" href="{{ route('user.list') }}" role="button">بازگشت</a>

        {{ Form::close() }}

    </div>

@endsection