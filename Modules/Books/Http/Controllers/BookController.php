<?php

namespace Modules\Books\Http\Controllers;

use Modules\Books\Entities\Book;
use Modules\Books\Entities\Category;
use Modules\Books\Entities\Translator;
use Modules\Books\Entities\Publisher;
use Modules\Books\Entities\Author;
use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Hekmatinasser\Verta\Verta;

use Auth;
use Session;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'/*, 'isAdmin'*/]); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$books = Book::all()->sortBy('border');
        // $books = DB::table('books')->simplePaginate(2);
        // $books = Book::orderBy('border','asc')->paginate(2);
        $query = Book::select('*');
        if (!empty($request->s_title)) {
            $query->where('title', 'like', '%' . $request->s_title . '%');
        }
        if (!empty($request->s_status)) {
            $query->where('status', '=', $request->s_status);
        }
        if (!empty($request->s_user_id)) {
            $query->where('user_id', '=', $request->s_user_id);
        }
        if (!empty($request->s_author_id)) {
            $query->where('author_id', '=', $request->s_author_id);
        }
        if (!empty($request->s_publisher_id)) {
            $query->where('publisher_id', '=', $request->s_publisher_id);
        }
        if (!empty($request->s_translator_id)) {
            $query->where('translator_id', '=', $request->s_translator_id);
        }
        if (!empty($request->s_category_id)) {
            $query->where('category_id', '=', $request->s_category_id);
        }

      //   dd($query);
        $books = $query->orderBy('border', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
        $users = User::get();
        $authors = Author::orderBy('aorder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $categories = Category::orderBy('corder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $publishers = Publisher::orderBy('porder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $translators = Translator::orderBy('torder', 'ASC')->orderBy('created_at', 'DESC')->get();

        return view('books::book.index', ['books' => $books, 'users' => $users , 'authors' => $authors , 'categories' => $categories , 'publishers' => $publishers , 'translators' => $translators]);
        //return view('books::book.index',['books', $books]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::where('status', 'E')->orderBy('aorder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $categories = Category::where('status', 'E')->orderBy('corder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $publishers = Publisher::where('status', 'E')->orderBy('porder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $translators = Translator::where('status', 'E')->orderBy('torder', 'ASC')->orderBy('created_at', 'DESC')->get();

        return view('books::book.create',[ 'authors' => $authors , 'categories' => $categories , 'publishers' => $publishers , 'translators' => $translators]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'summary' => 'max:3000',
            'border' => 'numeric|min:1',
            'author_id' => 'exists:authors,id',
            'publisher_id' => 'exists:publishers,id',
            'category_id' => 'exists:categories,id',
            'status' => ['required', Rule::in('E', 'D')],
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
            'image1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
            'image2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);


        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('public/images/books/'), $filename);
        }


        if ($request->hasFile('image1')) {
            $filename1 = '1'.time() . '.' . $request->file('image1')->getClientOriginalExtension();
            $request->file('image1')->move(base_path('public/images/books/'), $filename1);
        }


        if ($request->hasFile('image2')) {
            $filename2 = '2'.time() . '.' . $request->file('image2')->getClientOriginalExtension();
            $request->file('image2')->move(base_path('public/images/books/'), $filename2);
        }



        $data = $request->only('title', 'summary', 'description', 'border', 'status' ,'author_id','publisher_id','category_id','translator_id' );

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $border = $data['border'];
        $data['user_id'] = Auth::user()->id;
        if (empty($filename)) {
            $data['avatar'] = '';
        } else {
            $data['avatar'] = $filename;
        }

        if (empty($filename1)) {
            $data['image1'] = '';
        } else {
            $data['image1'] = $filename1;
        }

        if (empty($filename2)) {
            $data['image2'] = '';
        } else {
            $data['image2'] = $filename2;
        }
        try {
            $book = Book::create($data);
            $allBooks = Book::where('border', '>=', $border)->where('id', '!=', $book->id)->orderBy('border', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allBooks->count() > 0) {

                foreach ($allBooks as $key => $value) {
                    $border = $border + 1;
                    $value->border = $border;
                    $value->save();
                }

            }
            //if(is_Array($allBooks))
            $message = 'کتاب با موفقیت ایجاد شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        //Redirect to the users.index view and display message
        return redirect()->route('book.create')
            ->with($flash, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author $book
     * @return \Illuminate\Http\Response
     */
    public function show(Author $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id); //Get user with specified id
        $authors = Author::where('status', 'E')->orderBy('aorder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $categories = Category::where('status', 'E')->orderBy('corder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $publishers = Publisher::where('status', 'E')->orderBy('porder', 'ASC')->orderBy('created_at', 'DESC')->get();
        $translators = Translator::where('status', 'E')->orderBy('torder', 'ASC')->orderBy('created_at', 'DESC')->get();

        return view('books::book.edit', compact('book' ,'authors','categories','publishers','translators')); //pass book data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Author $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //required_without:image_old


        $book = Book::findOrFail($id); //Get role specified by id

        $request->validate([
            'title' => 'required|max:255',
            'summary' => 'max:3000',
            'border' => 'numeric|min:1',
            'author_id' => 'exists:authors,id',
            'publisher_id' => 'exists:publishers,id',
            'category_id' => 'exists:categories,id',
            'status' => ['required', Rule::in('E', 'D')],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
            'image1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
            'image2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);
        


        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('public/images/books/'), $filename);

        } elseif ($book['avatar'] == '' || !file_exists(public_path('/images/books/' . $book['avatar']))) {

            return back()->withInput($request->input())
                ->with('flash_message',
                    'لطفا تصویری برای آواتار انتخاب نمایید');
        }

        if ($request->hasFile('image1')) {
            $filename1 = '1'.time() . '.' . $request->file('image1')->getClientOriginalExtension();
            $request->file('image1')->move(base_path('public/images/books/'), $filename1);

        }
        if ($request->hasFile('image2')) {
            $filename2 = '2'.time() . '.' . $request->file('image2')->getClientOriginalExtension();
            $request->file('image2')->move(base_path('public/images/books/'), $filename2);

        }


        $backParams = $request->only('page', 's_status', 's_title', 's_user_id', 's_author_id','s_category_id','s_publisher_id','s_translator_id');

        $data = $request->only('title', 'summary', 'description', 'border', 'status' ,'author_id','publisher_id','category_id','translator_id' );

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $border = $data['border'];
        if (!empty($filename)) {
            $data['avatar'] = $filename;
            if ($book['avatar'] != '' && file_exists(public_path('/images/books/' . $book['avatar']))) {
                unlink(public_path('/images/books/' . $book['avatar']));
            }
        }

        if (!empty($filename1)) {
            $data['image1'] = $filename1;
            if ($book['image1'] != '' && file_exists(public_path('/images/books/' . $book['image1']))) {
                unlink(public_path('/images/books/' . $book['image1']));
            }
        }

        if (!empty($filename2)) {
            $data['image2'] = $filename2;
            if ($book['image2'] != '' && file_exists(public_path('/images/books/' . $book['image2']))) {
                unlink(public_path('/images/books/' . $book['image2']));
            }
        }

        try {
            $book->fill($data)->save();
            $allBooks = Book::where('border', '>=', $border)->where('id', '!=', $id)->orderBy('border', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allBooks->count() > 0) {
                foreach ($allBooks as $key => $value) {
                    $border = $border + 1;
                    $value->border = $border;
                    $value->save();
                }
            }
            //if(is_Array($allBooks))
            $message = 'کتاب با موفقیت ویرایش شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        $params = array(
            'id' => $id,
            's_status' => $backParams['s_status'],
            's_title' => $backParams['s_title'],
            's_author_id' => $backParams['s_author_id'],
            's_translator_id' => $backParams['s_translator_id'],
            's_category_id' => $backParams['s_category_id'],
            's_publisher_id' => $backParams['s_publisher_id'],
            's_user_id' => $backParams['s_user_id'],
            'page' => $backParams['page'],
            'book' => $book
        );

        return redirect()->route('book.edit', $params)
            ->with($flash,
                $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $backParams = $request->only('page', 's_status', 's_title',  's_author_id','s_category_id','s_publisher_id','s_translator_id');

        if (empty($backParams['page'])) {
            $backParams['page'] = 1;
        }

        $params = array(
            's_status' => $backParams['s_status'],
            's_title' => $backParams['s_title'],
            's_author_id' => $backParams['s_author_id'],
            's_translator_id' => $backParams['s_translator_id'],
            's_category_id' => $backParams['s_category_id'],
            's_publisher_id' => $backParams['s_publisher_id'],
            'page' => $backParams['page'],
        );

        //Find a user with a given id and delete
        $user = Book::findOrFail($id);
        $user->delete();

        return redirect()->route('book.list', $params)
            ->with('flash_message',
                'کتاب با موفقیت حذف شد');
    }

    public function deleteImage(Request $request, $id , $file,$image)
    {

        $backParams = $request->only('page', 's_status', 's_title',  's_author_id','s_category_id','s_publisher_id','s_translator_id');

        if (empty($backParams['page'])) {
            $backParams['page'] = 1;
        }

        $params = array(
            's_status' => $backParams['s_status'],
            's_title' => $backParams['s_title'],
            's_author_id' => $backParams['s_author_id'],
            's_translator_id' => $backParams['s_translator_id'],
            's_category_id' => $backParams['s_category_id'],
            's_publisher_id' => $backParams['s_publisher_id'],
            'page' => $backParams['page'],
        );

        //Find a user with a given id and delete
        $book = Book::findOrFail($id);
        $filename2 = $book[$file];
        $data[$file] = '';
        $book->fill($data)->save();

        if (!empty($filename2)) {
            if ($filename2 != '' && file_exists(public_path('/images/books/' . $filename2))) {
                unlink(public_path('/images/books/' . $filename2));
            }
        }


        return redirect()->route('book.images',$id)
            ->with('flash_message',
                'تصویر با موفقیت حذف شد');
    }
    
    public function images($id) {
        $book = Book::findOrFail($id); //Get role specified by id
        return view('books::book.images', compact('book'));
    }
}