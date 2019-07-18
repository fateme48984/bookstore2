@extends('layouts.admin')
{{--use Morilog\Jalali\Jalalian;--}}
@section('title', '| Users')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h3>
            <i class="fa fa-users"></i> لیست کاربران
         {{--   <a href="{{ route('role.list') }}" class="btn btn-default pull-right">Roles</a>
            <a href="{{ route('permission.list') }}" class="btn btn-default pull-right">Permissions</a>--}}
        </h3>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">

                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">نام کاربری</th>
                    <th scope="col">پست الکترونیک</th>
                    <th scope="col">تاریخ ایجاد</th>
                   {{-- <th  scope="col">User Roles</th>--}}
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($users as $key=>$user)
                    <tr>
                        <?php $k = $key + 1;?>
                        <th scope="row">{{ $k }}</th>
                        <td >{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
{{--
                        <td>{{ $user->roles()->pluck('name')->implode(' ') }}</td>--}}
{{-- Retrieve array of roles associated to a user and convert to string --}}

                        <td>
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 3px;">
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info pull-right btn-width">ویرایش</a>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                {!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id] ]) !!}
                                {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-width']) !!}
                                {!! Form::close() !!}
                                    </div>
                            </div>


                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <a href="{{ route('user.create') }}" class="btn btn-success">کاربر جدید</a>

    </div>

@endsection