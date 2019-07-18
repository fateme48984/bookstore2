@extends('layouts.admin')

{{--use Morilog\Jalali\Jalalian;--}}
@section('title', '| Publisher')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h5>
            <i class="fa fa-newspaper-o"></i> لیست ناشران
         {{--   <a href="{{ route('role.list') }}" class="btn btn-default pull-right">Roles</a>
            <a href="{{ route('permission.list') }}" class="btn btn-default pull-right">Permissions</a>--}}
        </h5>
        <hr>
        <div class="table-responsive">
            <div class="fixed-table-toolbar" style="padding: 5px;margin-bottom: 3px; border-radius: 2px ;border: 1px solid #dee2e6">
                <form method="GET" action="{{route('publisher.list')}}">

                    <table class="toolbar_search">
                        <thead>
                        <tr>
                            <th scope="col"><input class="form-control" placeholder="نام" type="text" name="s_name" value="{{ request()->get('s_name') }}"></th>
                            <th scope="col">
                                <select name="s_status">
                                    <option value="">همه</option>
                                    <option value="E"  @if(request()->get('s_status') == 'E') selected @endif>فعال</option>
                                    <option value="D"  @if(request()->get('s_status') == 'D') selected @endif>غیر فعال</option>
                                </select>
                            </th>

                            <th scope="col">
                                <select name="s_user_id">
                                    <option value="">همه</option>
                                    @foreach ($users as $key=>$user)
                                        <option value="{{$user->id}}" @if(request()->get('s_user_id') == $user->id) selected @endif>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </th>

                            <th scope="col"><input class="form-control btn-success"  type="submit" value="نمایش"></th>
                        </tr>
                        </thead>
                    </table>
                </form>

            </div>
            <table class="table table-bordered table-striped list-table">

                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">نام </th>
                    <th scope="col">تصویر</th>
                    <th scope="col">تاریخ ایجاد</th>
                    <th scope="col">ایجاد توسط</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($publishers as $key=>$publisher)
                    <tr>
                        <?php $k =( $key + 1 )+((request()->get('page' , 1) - 1)*2);?>
                        <th scope="row">{{ $k }}</th>
                        <td >{{ $publisher->name }}</td>
                        <td><img src="{{ asset('images/publishers/' . $publisher->avatar) }}" width="100" /></td>
                            <?php $v = new Verta($publisher->created_at); ?>
                        <td>{{ $v->format(' H:i:s Y/n/j') }}</td>
                        <td>{{ $publisher->user->name }}</td>
                        <td>
                            @if ($publisher->status === "E")
                                <i class='fa fa-check-circle status_enable'></i>
                            @else
                                <i class='fa fa-times-circle status_disable'></i>
                            @endif


                        <td>
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 3px;">
                                    <a href="{{ route('publisher.edit', $publisher->id) }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_name={{request()->get('s_name')}}&s_nationality={{request()->get('s_nationality')}}" class="btn btn-info pull-right btn-width">ویرایش</a>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">

                                {!! Form::open(['method' => 'DELETE', 'route' => ['publisher.destroy', $publisher->id] ]) !!}

                                    {!! Form::hidden('page', request()->get('page' , 1)) !!}
                                    {!! Form::hidden('s_status', request()->get('s_status')) !!}
                                    {!! Form::hidden('s_name', request()->get('s_name')) !!}
                                    {!! Form::hidden('s_user_id', request()->get('s_user_id')) !!}
                                    {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-width']) !!}
                                {!! Form::close() !!}
                                    </div>
                            </div>


                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{ $publishers->appends(['s_status' => request()->get('s_status')  , 's_name' => request()->get('s_name') , 's_user_id' => request()->get('s_user_id')])->links() }}
        </div>

        <a href="{{ route('publisher.create') }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_name={{request()->get('s_name')}}" class="btn btn-success">ناشر جدید</a>

    </div>

@endsection