@extends('layouts.admin')

{{--use Morilog\Jalali\Jalalian;--}}
@section('title', '| Sliders')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <h5>
            <i class="fa fa-stack-exchange"></i> لیست اسلایدرها
         {{--   <a href="{{ route('role.list') }}" class="btn btn-default pull-right">Roles</a>
            <a href="{{ route('permission.list') }}" class="btn btn-default pull-right">Permissions</a>--}}
        </h5>
        <hr>
        <div class="table-responsive">
            <div class="fixed-table-toolbar" style="padding: 5px;margin-bottom: 3px; border-radius: 2px ;border: 1px solid #dee2e6">
                <form method="GET" action="{{route('slider.list')}}">

                    <table class="toolbar_search">
                        <thead>
                        <tr>

                            <th scope="col">
                                <select name="s_sec_id">
                                    <option value="">همه</option>
                                    <option value="1"  @if(request()->get('s_sec_id') == 1) selected @endif>اسلایدر تصویری</option>
                                    <option value="2"  @if(request()->get('s_sec_id') == 2) selected @endif>اسلایدر متنی</option>
                                </select>
                            </th>

                            <th scope="col">
                                <select name="s_status">
                                    <option value="">همه</option>
                                    <option value="E"  @if(request()->get('s_status') == 'E') selected @endif>فعال</option>
                                    <option value="D"  @if(request()->get('s_status') == 'D') selected @endif>غیر فعال</option>
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
                    <th scope="col">قسمت </th>
                    <th scope="col">تصویر</th>
                    <th scope="col">تاریخ ایجاد</th>
                    <th scope="col">ایجاد توسط</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($sliders as $key=>$slider)
                    <tr>
                        <?php $k =( $key + 1 )+((request()->get('page' , 1) - 1)*2);?>
                        <th scope="row">{{ $k }}</th>
                        <td >
                            @if ($slider->sec_id == 1)
                                اسلایدر تصویری
                            @else
                                اسلایدر متنی
                            @endif
                        </td>
                            @if ($slider->sec_id == 1)
                                <td><img src="{{ asset('/images/sliders/' . $slider->avatar) }}" width="100" /></td>

                            @else
                                <td>-</td>
                            @endif
                            <?php $v = new Verta($slider->created_at); ?>
                        <td>{{ $v->format(' H:i:s Y/n/j') }}</td>
                        <td>{{ $slider->user->name }}</td>
                        <td>
                            @if ($slider->status === "E")
                                <i class='fa fa-check-circle status_enable'></i>
                            @else
                                <i class='fa fa-times-circle status_disable'></i>
                            @endif


                        <td>
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 3px;">
                                    <a href="{{ route('slider.edit', $slider->id) }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_sec_id={{request()->get('s_sec_id')}}" class="btn btn-info pull-right btn-width">ویرایش</a>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">

                                {!! Form::open(['method' => 'DELETE', 'route' => ['slider.destroy', $slider->id] ]) !!}

                                    {!! Form::hidden('page', request()->get('page' , 1)) !!}
                                    {!! Form::hidden('s_status', request()->get('s_status')) !!}
                                    {!! Form::hidden('s_sec_id', request()->get('s_sec_id')) !!}
                                    {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-width']) !!}
                                {!! Form::close() !!}
                                    </div>
                            </div>


                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{ $sliders->appends(['s_status' => request()->get('s_status') , 's_sec_id' => request()->get('s_sec_id') ])->links() }}
        </div>

        <a href="{{ route('slider.create') }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_sec_id={{request()->get('s_sec_id')}}" class="btn btn-success">اسلایدر جدید</a>

    </div>

@endsection