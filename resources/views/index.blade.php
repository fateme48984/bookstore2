@extends('layouts.main')

@section('content')

    @if($imgSlider->count()> 0)
    <section class="slider">
        <div class="container">
            <div id="owl-demo" class="owl-carousel owl-theme">
                @foreach($imgSlider as $key=>$value)
                    <div class="item">
                        <div class="slide">
                            <img src="/images/sliders/{{$value->avatar}}" alt="معرفی کتاب">
                            <div class="content">
                                <div class="title">
                                    <h3>
                                        {{$value->text}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


    @if($books->count()> 0)
    <section class="recomended-sec">
        <div class="container">
            <div class="title">
                <h2>تازه ترین کتاب ها</h2>
                <hr>
            </div>
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
                            <a href="{{route('site.book' , $value->id)}}">
                                <span><i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($book->count() == 1)
        @foreach($book as $key=>$value)
            <section class="about-sec ">
                <div class="about-img">
                    <figure style="background:url('images/books/{{$value->avatar}}')no-repeat;"></figure>
                </div>
                <div class="about-content ">
                    <h2>{{$value->title}}</h2>
                    {{$value->summary}}
                    <div class="btn-sec">
                        <a href="{{route('site.book',$value->id)}}" class="btn black">ادامه</a>
                    </div>
                </div>
            </section>
        @endforeach
    @endif

    @if($authors->count()> 0)
    <section class="recent-book-sec">
        <div class="container">
            <div class="title">
                <h2>معرفی نویسنده</h2>
                <hr>
            </div>
            <div class="row">
                @foreach($authors as $key=>$value)
                <div class="col-lg-2 col-md-3 col-sm-4">
                    <div class="item">
                        <img src="/images/authors/{{$value->avatar}}" alt="img">
                        <h3><a href="{{route('site.author' , $value->id)}}">{{$value->name}}</a></h3>
                        <h6>
                            <a href="{{route('site.author', $value->id)}}">آثار</a>
                        </h6>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </section>
    @endif

    @if($txtSlider->count()> 0)
        <section class="testimonial-sec">
        <div class="container">
            <div id="testimonal" class="owl-carousel owl-theme">
                @foreach($txtSlider as $key=>$value)

                <div class="item">
                    <h3>
                        {{$value->text}}
                    </h3>

                </div>
                @endforeach
            </div>
        </div>
        <div class="left-quote">
            <img src="{{asset('images/left-quote.png')}}" alt="quote">
        </div>
        <div class="right-quote">
            <img src="{{asset('images/right-quote.png')}}" alt="quote">
        </div>
    </section>
    @endif
@endsection