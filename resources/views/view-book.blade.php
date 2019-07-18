
@extends('layouts.main')

@section('content')

<section class="product-sec">
    <div class="container">
        <h1>معرفی {{$book->title}} ؛ نوشته {{$book->author->name}}</h1>
        <div class="row">
            <div class="col-md-6 slider-sec">
                <!-- main slider carousel -->
                <div id="myCarousel" class="carousel slide">
                    <!-- main slider carousel items -->
                    <div class="carousel-inner">
                        @if($book->avatar != '')
                        <div class="active item carousel-item" data-slide-number="0">
                            <img src="/images/books/{{$book->avatar}}" class="img-fluid">
                        </div>
                        @endif

                         @if($book->image1 != '')
                        <div class="item carousel-item" data-slide-number="1">
                            <img src="/images/books/{{$book->image1}}" class="img-fluid">
                        </div>
                        @endif

                         @if($book->image2 != '')
                        <div class="item carousel-item" data-slide-number="2">
                            <img src="/images/books/{{$book->image2}}" class="img-fluid">
                        </div>
                         @endif
                    </div>
                    <!-- main slider carousel nav controls -->
                    <ul class="carousel-indicators list-inline">
                        @if($book->avatar != '')
                        <li class="list-inline-item active">
                            <a id="carousel-selector-0" class="selected" data-slide-to="0" data-target="#myCarousel">
                                <img src="/images/books/{{$book->avatar}}" class="img-fluid">
                            </a>
                        </li>
                        @endif

                        @if($book->image1 != '')
                        <li class="list-inline-item">
                            <a id="carousel-selector-1" data-slide-to="1" data-target="#myCarousel">
                                <img src="/images/books/{{$book->image1}}" class="img-fluid">
                            </a>
                        </li>
                            @endif

                            @if($book->image2 != '')
                        <li class="list-inline-item">
                            <a id="carousel-selector-2" data-slide-to="2" data-target="#myCarousel">
                                <img src="/images/books/{{$book->image2}}" class="img-fluid">
                            </a>
                        </li>
                                @endif
                    </ul>
                </div>
                <!--/main slider carousel-->
            </div>
            <div class="col-md-6 slider-content">
                <?php echo htmlspecialchars_decode(stripslashes($book->description));  ?>

            </div>
        </div>
    </div>
</section>

@if($books->count() > 0)
<section class="related-books">
    <div class="container">
        <h2>کتاب های مرتبط</h2>
        <div class="recomended-sec">
            <div class="row">
                @foreach($books as $key=>$value)
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <img src="/images/books/{{$value->avatar}}" alt="img">
                        <h3>{{$value->title}}</h3>
                        <h6>
                            <span class="price">{{$value->author->name}} </span>
                        </h6>
                        <div class="hover">
                            <a href="{{Route('site.book' , $value->id)}}">
                                <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                    @endforeach


            </div>
        </div>
    </div>
</section>
 @endif
@endsection