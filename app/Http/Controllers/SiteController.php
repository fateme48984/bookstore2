<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Books\Entities\Book;
use Modules\Books\Entities\Author;
use Modules\Books\Entities\Setting;
use Modules\Books\Entities\Slider;




class SiteController extends Controller
{
    function index() {
        $imgSlider = $this->renderSlider(1);
        $txtSlider = $this->renderSlider(2);
        $authors = $this->renderAuthors();
        $books = $this->renderLatestBooks();
        $book = $this->renderLastBook();
        //$imgSliderView = \View::make($imgSlider)->render();
      ////  $txtSlider = $this->renderSlider(2);
        return view('index',['imgSlider' => $imgSlider ,'txtSlider' => $txtSlider ,
            'authors' => $authors,'books' => $books,'book' => $book]);
    }
    
    function renderSlider($secID) {
        $sliders = Slider::where('sec_id' ,'=' ,$secID)
            ->where('status' ,'=' ,'E')
            ->orderBy('sorder', 'asc')->take(4)->get();
    
        return $sliders;
    }


    function renderLastBook() {
        $book = Book::where('status' ,'=' ,'E')
            ->orderBy('border', 'asc')->take(1)->get();

        return $book;
    }

    function book($id) {
        $book = Book::where('id' ,'=', $id)->where('status' ,'=','E')->firstOrFail(); //Get user with specified id

        $books = Book::where('author_id','=' ,$book->author_id)->where('id','!=' ,$id)->where('status' ,'=','E')->orderBy('border','asc')->take(4)->get();
        return view('view-book', compact('book','books' )); //pass book data to view

    }
    function author($id) {
        $author = Author::where('id' ,'=', $id)->where('status' ,'=','E')->where('status' ,'=','E')->firstOrFail(); //Get user with specified id
        $books = Book::where('author_id','=' ,$id)->orderBy('border','asc')->get();

        return view('view-author', compact('author' ,'books')); //pass book data to view

    }

    function about() {
        $setting = Setting::findOrFail(1); //Get user with specified id
        return view('about', compact('setting' )); //pass book data to view

    }

    function contact() {
        $setting = Setting::findOrFail(2); //Get user with specified id
        return view('about', compact('setting' )); //pass book data to view

    }

    function renderLatestBooks() {
        $books = Book::where('status' ,'=' ,'E')
            ->orderBy('border', 'asc')->take(4)->get();

        return $books;
    }

    function renderAuthors() {
        $authors = Author::where('status' ,'=' ,'E')
            ->orderBy('aorder', 'asc')->take(5)->get();

        return $authors;
    }
}
