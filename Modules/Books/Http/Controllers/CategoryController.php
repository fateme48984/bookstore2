<?php

namespace Modules\Books\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Books\Entities\Category;
use Illuminate\Support\Facades\DB;
use Hekmatinasser\Verta\Verta;

use Auth;
use Session;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'/*, 'isAdmin'*/]); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {

        $query = Category::select('*');
        if (!empty($request->s_name)) {
            $query->where('name', 'like', '%' . $request->s_name . '%');
        }

        if (!empty($request->s_status)) {
            $query->where('status', '=', $request->s_status);
        }
        if (!empty($request->s_user_id)) {
            $query->where('user_id', '=', $request->s_user_id);
        }


        $categories = $query->orderBy('corder', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
        $users = User::get();

        return view('books::category.index', ['categories' => $categories, 'users' => $users]);
        //return view('books::category.index',['categories', $categories]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books::category.create');
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
            'corder' => 'numeric|min:1',
            'status' => ['required', Rule::in('E', 'D')],
        ]);


        $data = $request->only('name', 'corder', 'status');

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $corder = $data['corder'];
        $data['user_id'] = Auth::user()->id;

        try {
            $category = Category::create($data);
            $allPublishers = Category::where('corder', '>=', $corder)->where('id', '!=', $category->id)->orderBy('corder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allPublishers->count() > 0) {

                foreach ($allPublishers as $key => $value) {
                    $corder = $corder + 1;
                    $value->corder = $corder;
                    $value->save();
                }

            }
            //if(is_Array($allPublishers))
            $message = 'موضوع با موفقیت ایجاد شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        //Redirect to the users.index view and display message
        return redirect()->route('category.create')
            ->with($flash, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publisher $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id); //Get user with specified id

        return view('books::category.edit', compact('category')); //pass publisher data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Publisher $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //required_without:image_old


        $category = Category::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $request->validate([
            'name' => 'required|max:255',
            'corder' => 'numeric|min:1',
            'status' => ['required', Rule::in('E', 'D')],
        ]);


        $backParams = $request->only('page', 's_status', 's_user_id', 's_name');
        $data = $request->only('name', 'description', 'corder', 'status');
        $corder = $data['corder'];

        try {
            $category->fill($data)->save();
            $allPublishers = Category::where('corder', '>=', $corder)->where('id', '!=', $id)->orderBy('corder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allPublishers->count() > 0) {
                foreach ($allPublishers as $key => $value) {
                    $corder = $corder + 1;
                    $value->corder = $corder;
                    $value->save();
                }
            }
            //if(is_Array($allPublishers))
            $message = 'موضوع با موفقیت ویرایش شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        $params = array(
            'id' => $id,
            's_status' => $backParams['s_status'],
            's_name' => $backParams['s_name'],
            's_user_id' => $backParams['s_user_id'],
            'page' => $backParams['page'],
            'category' => $category
        );

        return redirect()->route('category.edit', $params)
            ->with($flash,
                $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publisher $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $backParams = $request->only('page', 's_status', 's_user_id', 's_name');

        if (empty($backParams['page'])) {
            $backParams['page'] = 1;
        }

        $params = array('s_status' => $backParams['s_status'],
            's_name' => $backParams['s_name'],
            's_user_id' => $backParams['s_user_id'],
            'page' => $backParams['page']
        );

        //Find a user with a given id and delete
        $user = Category::findOrFail($id);
        $user->delete();

        return redirect()->route('category.list', $params)
            ->with('flash_message',
                'موضوع با موفقیت حذف شد');
    }
}
