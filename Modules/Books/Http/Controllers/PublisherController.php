<?php

namespace Modules\Books\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Books\Entities\Publisher;
use Illuminate\Support\Facades\DB;
use Hekmatinasser\Verta\Verta;

use Auth;
use Session;

class PublisherController extends Controller
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

        $query = Publisher::select('*');
        if (!empty($request->s_name)) {
            $query->where('name', 'like', '%' . $request->s_name . '%');
        }

        if (!empty($request->s_status)) {
            $query->where('status', '=', $request->s_status);
        }
        if (!empty($request->s_user_id)) {
            $query->where('user_id', '=', $request->s_user_id);
        }


        $publishers = $query->orderBy('porder', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
        $users = User::get();

        return view('books::publisher.index', ['publishers' => $publishers, 'users' => $users]);
        //return view('books::publisher.index',['publishers', $publishers]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books::publisher.create');
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
            'porder' => 'numeric|min:1',
            'status' => ['required', Rule::in('E', 'D')],
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);

        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('/public/images/publishers/'), $filename);
        }

        $data = $request->only('name', 'description', 'porder', 'status');

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $porder = $data['porder'];
        $data['user_id'] = Auth::user()->id;
        if (empty($filename)) {
            $data['avatar'] = '';
        } else {
            $data['avatar'] = $filename;
        }

        try {
            $publisher = Publisher::create($data);
            $allPublishers = Publisher::where('porder', '>=', $porder)->where('id', '!=', $publisher->id)->orderBy('porder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allPublishers->count() > 0) {

                foreach ($allPublishers as $key => $value) {
                    $porder = $porder + 1;
                    $value->porder = $porder;
                    $value->save();
                }

            }
            //if(is_Array($allPublishers))
            $message = 'ناشر با موفقیت ایجاد شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        //Redirect to the users.index view and display message
        return redirect()->route('publisher.create')
            ->with($flash, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publisher $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publisher $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publisher = Publisher::findOrFail($id); //Get user with specified id

        return view('books::publisher.edit', compact('publisher')); //pass publisher data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Publisher $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //required_without:image_old


        $publisher = Publisher::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $request->validate([
            'name' => 'required|max:255',
            'porder' => 'numeric|min:1',
            'status' => ['required', Rule::in('E', 'D')],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);


        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('public/images/publishers/'), $filename);

        } elseif ($publisher['avatar'] == '' || !file_exists(public_path('/images/publishers/' . $publisher['avatar']))) {

            return back()->withInput($request->input())
                ->with('flash_message',
                    'لطفا تصویری برای آواتار انتخاب نمایید');
        }


        $backParams = $request->only('page', 's_status', 's_user_id', 's_name');

        $data = $request->only('name', 'description', 'porder', 'status');

        $porder = $data['porder'];
        if (!empty($filename)) {
            $data['avatar'] = $filename;
            if ($publisher['avatar'] != '' && file_exists(public_path('/images/publishers/' . $publisher['avatar']))) {
                unlink(public_path('/images/publishers/' . $publisher['avatar']));
            }
        }

        try {
            $publisher->fill($data)->save();
            $allPublishers = Publisher::where('porder', '>=', $porder)->where('id', '!=', $id)->orderBy('porder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allPublishers->count() > 0) {
                foreach ($allPublishers as $key => $value) {
                    $porder = $porder + 1;
                    $value->porder = $porder;
                    $value->save();
                }
            }
            //if(is_Array($allPublishers))
            $message = 'ناشر با موفقیت ویرایش شد';
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
            'publisher' => $publisher
        );

        return redirect()->route('publisher.edit', $params)
            ->with($flash,
                $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publisher $publisher
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
        $user = Publisher::findOrFail($id);
        $user->delete();

        return redirect()->route('publisher.list', $params)
            ->with('flash_message',
                'ناشر با موفقیت حذف شد');
    }
}
