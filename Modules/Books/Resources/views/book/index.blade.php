@extends('layouts.admin')

{{--use Morilog\Jalali\Jalalian;--}}
@section('title', '| Authors')

@section('content')

    <div class="col-lg-11 col-lg-offset-1">
        <h5>
            <i class="fa fa-users"></i> لیست کتاب ها
         {{--   <a href="{{ route('role.list') }}" class="btn btn-default pull-right">Roles</a>
            <a href="{{ route('permission.list') }}" class="btn btn-default pull-right">Permissions</a>--}}
        </h5>
        <hr>
        <div class="table-responsive">
            <div class="fixed-table-toolbar" style="padding: 5px;margin-bottom: 3px; border-radius: 2px ;border: 1px solid #dee2e6">
                <table class="toolbar_search">
                    <thead>
                    <tr>
                        <th scope="col">عنوان </th>
                        <th scope="col">موضوع</th>
                        <th scope="col"> نویسنده</th>
                        <th scope="col">ناشر</th>
                        <th scope="col">مترجم</th>
                        <th scope="col">وضعیت</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>

                    <tbody>

                <form method="GET" action="{{route('book.list')}}">


                        <tr>
                            <td scope="col">
                                <input class="form-control" placeholder="نام" type="text" name="s_title" value="{{ request()->get('s_title') }}">
                            </td>

                            <td scope="col">
                            <select name="s_category_id">
                                <option value="">همه</option>
                                @foreach ($categories as $key=>$cat)
                                    <option value="{{$cat->id}}" @if(request()->get('s_category_id') == $cat->id) selected @endif>{{$cat->name}}</option>
                                @endforeach
                            </select>
                            </td>

                            <td scope="col">
                            <select name="s_author_id">
                                <option value="">همه</option>
                                @foreach ($authors as $key=>$author)
                                    <option value="{{$author->id}}" @if(request()->get('s_author_id') == $author->id) selected @endif>{{$author->name}}</option>
                                @endforeach
                            </select>
                            </td>

                            <td scope="col">
                            <select name="s_publisher_id">
                                <option value="">همه</option>
                                @foreach ($publishers as $key=>$publisher)
                                    <option value="{{$publisher->id}}" @if(request()->get('s_publisher_id') == $publisher->id) selected @endif>{{$publisher->name}}</option>
                                @endforeach
                            </select>
                            </td>

                            <td scope="col">
                            <select name="s_translator_id">
                                <option value="">همه</option>
                                @foreach ($translators as $key=>$translator)
                                    <option value="{{$translator->id}}" @if(request()->get('s_translator_id') == $translator->id) selected @endif>{{$translator->name}}</option>
                                @endforeach
                            </select>
                            </td>


                            <td scope="col">
                                <select name="s_status">
                                    <option value="">همه</option>
                                    <option value="E"  @if(request()->get('s_status') == 'E') selected @endif>فعال</option>
                                    <option value="D"  @if(request()->get('s_status') == 'D') selected @endif>غیر فعال</option>
                                </select>
                            </td>


                            <th scope="col"><input class="form-control btn-success"  type="submit" value="نمایش"></th>
                        </tr>
                </form>
                        </tbody>

                    </table>


            </div>
            <table class="table table-bordered table-striped list-table">

                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">عنوان </th>
                    <th scope="col">تصویر</th>
                    <th scope="col">موضوع</th>
                    <th scope="col"> نویسنده</th>
                    <th scope="col">ناشر</th>
                    <th scope="col">مترجم</th>
                    <th scope="col">وضعیت</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
                @foreach ($books as $key=>$book)
                    <tr>
                        <?php $k =( $key + 1 )+((request()->get('page' , 1) - 1)*2);?>
                        <th scope="row">{{ $k }}</th>
                        <td >{{ $book->title }}</td>
                        <td><img src="{{ asset('/images/books/' . $book->avatar) }}" width="100" /></td>
                        <td>{{ $book->category->name }}</td>
                        <td>{{ $book->author->name }}</td>
                        <td>{{ $book->publisher->name }}</td>

                        <td>
                            @if ( $book->translator_id  != 0 )
                                {{$book->translator->name}}
                            @else
                              -
                            @endif
                        </td>
                        <td>
                            @if ($book->status == "E")
                                <i class='fa fa-check-circle status_enable'></i>
                            @else
                                <i class='fa fa-times-circle status_disable'></i>
                            @endif


                        <td>
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 3px;">
                                    <a href="{{ route('book.edit', $book->id) }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_title={{request()->get('s_title')}}&s_category_id={{request()->get('s_category_id')}}&s_author_id={{request()->get('s_author_id')}}&s_publisher_id={{request()->get('s_publisher_id')}}&s_translator_id={{request()->get('s_translator_id')}}" class="btn btn-info pull-right btn-width">ویرایش</a>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12"  style="margin-bottom: 3px;">

                                {!! Form::open(['method' => 'DELETE', 'route' => ['book.destroy', $book->id] ]) !!}

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
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('book.images', $book->id) }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_title={{request()->get('s_title')}}&s_category_id={{request()->get('s_category_id')}}&s_author_id={{request()->get('s_author_id')}}&s_publisher_id={{request()->get('s_publisher_id')}}&s_translator_id={{request()->get('s_translator_id')}}" class="btn btn-success pull-right btn-width">تصاویر</a>

                                </div>

                            </div>


                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{ $books->appends(['s_status' => request()->get('s_status') , 's_author_id' => request()->get('s_author_id') , 's_title' => request()->get('s_title') , 's_user_id' => request()->get('s_user_id') , 's_category_id' => request()->get('s_category_id') , 's_publisher_id' => request()->get('s_publisher_id'), 's_translator_id' => request()->get('s_translator_id')])->links()  }}
        </div>

        <a href="{{ route('book.create') }}?page={{request()->get('page',1)}}&s_status={{request()->get('s_status')}}&s_user_id={{request()->get('s_user_id')}}&s_title={{request()->get('s_title')}}&s_category_id={{request()->get('s_category_id')}}&s_author_id={{request()->get('s_author_id')}}&s_publisher_id={{request()->get('s_publisher_id')}}&s_translator_id={{request()->get('s_translator_id')}}" class="btn btn-success">کتاب جدید</a>

    </div>

@endsection