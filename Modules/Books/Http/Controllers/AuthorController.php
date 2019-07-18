<?php

namespace Modules\Books\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Books\Entities\Author;
use Illuminate\Support\Facades\DB;
use Hekmatinasser\Verta\Verta;

use Auth;
use Session;

class AuthorController extends Controller
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
        //$authors = Author::all()->sortBy('aorder');
        // $authors = DB::table('authors')->simplePaginate(2);
        // $authors = Author::orderBy('aorder','asc')->paginate(2);
        $query = Author::select('*');
        if (!empty($request->s_name)) {
            $query->where('name', 'like', '%' . $request->s_name . '%');
        }
        if (!empty($request->s_nationality)) {
            $query->where('nationality', 'like', '%' . $request->s_nationality . '%');
        }
        if (!empty($request->s_status)) {
            $query->where('status', '=', $request->s_status);
        }
        if (!empty($request->s_user_id)) {
            $query->where('user_id', '=', $request->s_user_id);
        }

        // dd($query);
        $authors = $query->orderBy('aorder', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
        $users = User::get();

        return view('books::author.index', ['authors' => $authors, 'users' => $users]);
        //return view('books::author.index',['authors', $authors]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('books::author.create');
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
            'name' => 'required|max:255',
            'nationality' => 'max:255',
            //  'birthdate'=>'regex:/^\d{4}\/\d{2}\/\d{2}$/',
            'birthdate' => 'min:4|max:4',
            'aorder' => 'numeric|min:1',
            'nationality' => 'max:255',
            'status' => ['required', Rule::in('E', 'D')],
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);

        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('public/images/authors/'), $filename);
        }

        $data = $request->only('name', 'nationality', 'birthdate', 'description', 'aorder', 'status');

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $aorder = $data['aorder'];
        $data['user_id'] = Auth::user()->id;
        if (empty($filename)) {
            $data['avatar'] = '';
        } else {
            $data['avatar'] = $filename;
        }

        try {
            $author = Author::create($data);
            $allAuthors = Author::where('aorder', '>=', $aorder)->where('id', '!=', $author->id)->orderBy('aorder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allAuthors->count() > 0) {

                foreach ($allAuthors as $key => $value) {
                    $aorder = $aorder + 1;
                    $value->aorder = $aorder;
                    $value->save();
                }

            }
            //if(is_Array($allAuthors))
            $message = 'نویسنده با موفقیت ایجاد شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        //Redirect to the users.index view and display message
        return redirect()->route('author.create')
            ->with($flash, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author $author
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $author = Author::findOrFail($id); //Get user with specified id

        return view('books::author.edit', compact('author')); //pass author data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Author $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //required_without:image_old


        $author = Author::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $request->validate([
            'name' => 'required|max:255',
            'nationality' => 'max:255',
            //  'birthdate'=>'regex:/^\d{4}\/\d{2}\/\d{2}$/',
            'birthdate' => 'min:4|max:4',
            'aorder' => 'numeric|min:1',
            'nationality' => 'max:255',

            'status' => ['required',
                Rule::in('E', 'D')],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);


        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('public/images/authors/'), $filename);

        } elseif ($author['avatar'] == '' || !file_exists(public_path('/images/authors/' . $author['avatar']))) {

            return back()->withInput($request->input())
                ->with('flash_message',
                    'لطفا تصویری برای آواتار انتخاب نمایید');
        }


        $backParams = $request->only('page', 's_status', 's_nationality', 's_user_id', 's_name');

        $data = $request->only('name', 'nationality', 'birthdate', 'description', 'aorder', 'status');

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $aorder = $data['aorder'];
        if (!empty($filename)) {
            $data['avatar'] = $filename;
            if ($author['avatar'] != '' && file_exists(public_path('/images/authors/' . $author['avatar']))) {
                unlink(public_path('/images/authors/' . $author['avatar']));
            }
        }

        try {
            $author->fill($data)->save();
            $allAuthors = Author::where('aorder', '>=', $aorder)->where('id', '!=', $id)->orderBy('aorder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allAuthors->count() > 0) {
                foreach ($allAuthors as $key => $value) {
                    $aorder = $aorder + 1;
                    $value->aorder = $aorder;
                    $value->save();
                }
            }
            //if(is_Array($allAuthors))
            $message = 'نویسنده با موفقیت ویرایش شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        $params = array(
            'id' => $id,
            's_status' => $backParams['s_status'],
            's_name' => $backParams['s_name'],
            's_nationality' => $backParams['s_nationality'],
            's_user_id' => $backParams['s_user_id'],
            'page' => $backParams['page'],
            'author' => $author
        );

        return redirect()->route('author.edit', $params)
            ->with($flash,
                $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $backParams = $request->only('page', 's_status', 's_nationality', 's_user_id', 's_name');

        if (empty($backParams['page'])) {
            $backParams['page'] = 1;
        }

        $params = array('s_status' => $backParams['s_status'],
            's_name' => $backParams['s_name'],
            's_nationality' => $backParams['s_nationality'],
            's_user_id' => $backParams['s_user_id'],
            'page' => $backParams['page']
        );

        //Find a user with a given id and delete
        $user = Author::findOrFail($id);
        $user->delete();

        return redirect()->route('author.list', $params)
            ->with('flash_message',
                'کاربر با موفقیت حذف شد');
    }
}
