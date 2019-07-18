<?php

namespace Modules\Books\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Books\Entities\Translator;
use Illuminate\Support\Facades\DB;
use Hekmatinasser\Verta\Verta;

use Auth;
use Session;

class TranslatorController extends Controller
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

        $query = Translator::select('*');
        if (!empty($request->s_name)) {
            $query->where('name', 'like', '%' . $request->s_name . '%');
        }
        if (!empty($request->s_status)) {
            $query->where('status', '=', $request->s_status);
        }
        if (!empty($request->s_user_id)) {
            $query->where('user_id', '=', $request->s_user_id);
        }

        // dd($query);
        $translators = $query->orderBy('torder', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);
        $users = User::get();

        return view('books::translator.index', ['translators' => $translators, 'users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('books::translator.create');
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
            'torder' => 'numeric|min:1',
            'status' => ['required', Rule::in('E', 'D')],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);

        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('/public/images/translators/'), $filename);
        }

        $data = $request->only('name', 'description', 'torder', 'status');

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $torder = $data['torder'];
        $data['user_id'] = Auth::user()->id;
        if (empty($filename)) {
            $data['avatar'] = '';
        } else {
            $data['avatar'] = $filename;
        }

        try {
            $translator = Translator::create($data);
            $allTranslators = Translator::where('torder', '>=', $torder)->where('id', '!=', $translator->id)->orderBy('torder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allTranslators->count() > 0) {

                foreach ($allTranslators as $key => $value) {
                    $torder = $torder + 1;
                    $value->torder = $torder;
                    $value->save();
                }

            }
            //if(is_Array($allTranslators))
            $message = 'مترجم با موفقیت ایجاد شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        //Redirect to the users.index view and display message
        return redirect()->route('translator.create')
            ->with($flash, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Translator $translator
     * @return \Illuminate\Http\Response
     */
    public function show(Translator $translator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Translator $translator
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $translator = Translator::findOrFail($id); //Get user with specified id

        return view('books::translator.edit', compact('translator')); //pass translator data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Translator $translator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //required_without:image_old


        $translator = Translator::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $request->validate([
            'name' => 'required|max:255',
            'torder' => 'numeric|min:1',
            'status' => ['required', Rule::in('E', 'D')],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);


        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('public/images/translators/'), $filename);

        }


        $backParams = $request->only('page', 's_status', 's_user_id', 's_name');

        $data = $request->only('name', 'description', 'torder', 'status');

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $torder = $data['torder'];
        if (!empty($filename)) {
            $data['avatar'] = $filename;
            if ($translator['avatar'] != '' && file_exists(public_path('/images/translators/' . $translator['avatar']))) {
                unlink(public_path('/images/translators/' . $translator['avatar']));
            }
        }

        try {
            $translator->fill($data)->save();
            $allTranslators = Translator::where('torder', '>=', $torder)->where('id', '!=', $id)->orderBy('torder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allTranslators->count() > 0) {
                foreach ($allTranslators as $key => $value) {
                    $torder = $torder + 1;
                    $value->torder = $torder;
                    $value->save();
                }
            }
            //if(is_Array($allTranslators))
            $message = 'مترجم با موفقیت ویرایش شد';
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
            'translator' => $translator
        );

        return redirect()->route('translator.edit', $params)
            ->with($flash,
                $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Translator $translator
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
        $user = Translator::findOrFail($id);
        $user->delete();

        return redirect()->route('translator.list', $params)
            ->with('flash_message',
                'کاربر با موفقیت حذف شد');
    }
}
