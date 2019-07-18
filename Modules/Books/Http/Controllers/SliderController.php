<?php

namespace Modules\Books\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Books\Entities\Slider;
use Illuminate\Support\Facades\DB;
use Hekmatinasser\Verta\Verta;

use Auth;
use Session;

class SliderController extends Controller
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
        //$sliders = Slider::all()->sortBy('sorder');
        // $sliders = DB::table('sliders')->simplePaginate(2);
        // $sliders = Slider::orderBy('sorder','asc')->paginate(2);
        $query = Slider::select('*');


        if (!empty($request->s_status)) {
            $query->where('status', '=', $request->s_status);
        }
        if (!empty($request->s_sec_id)) {
            $query->where('sec_id', '=', $request->s_sec_id);
        }

        // dd($query);
        $sliders = $query->orderBy('sorder', 'ASC')->orderBy('created_at', 'DESC')->paginate(10);

        $users = User::get();

        return view('books::slider.index', ['sliders' => $sliders, 'users' => $users]);
        //return view('books::slider.index',['sliders', $sliders]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('books::slider.create');
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
            'text' => 'required',
            'sorder' => 'numeric|min:1',
            'status' => ['required', Rule::in('E', 'D')],
            'sec_id' => ['required', Rule::in(1 , 2)], //1 = img_slider , 2 = text-slider
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',//172*230
        ]);

        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('public/images/sliders/'), $filename);
        }

        $data = $request->only('sec_id', 'text', 'sorder', 'status');

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $sorder = $data['sorder'];
        $data['user_id'] = Auth::user()->id;
        if (empty($filename)) {
            $data['avatar'] = '';
        } else {
            $data['avatar'] = $filename;
        }

        try {
            $slider = Slider::create($data);
            $allSliders = Slider::where('sorder', '>=', $sorder)->where('id', '!=', $slider->id)->orderBy('sorder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allSliders->count() > 0) {

                foreach ($allSliders as $key => $value) {
                    $sorder = $sorder + 1;
                    $value->sorder = $sorder;
                    $value->save();
                }

            }
            //if(is_Array($allSliders))
            $message = 'اسلایدر با موفقیت ایجاد شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        //Redirect to the users.index view and display message
        return redirect()->route('slider.create')
            ->with($flash, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id); //Get user with specified id

        return view('books::slider.edit', compact('slider')); //pass slider data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Slider $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //required_without:image_old


        $slider = Slider::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $request->validate([
            'text' => 'required|',
            'sorder' => 'numeric|min:1',
            'sec_id' => ['required', Rule::in(1, 2)], // 1 = img_slider , 2=txt_slider
            'status' => ['required', Rule::in('E', 'D')],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',//172*230
        ]);


        if ($request->hasFile('avatar')) {
            $filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(base_path('public/images/sliders/'), $filename);

        }


        $backParams = $request->only('page', 's_status', 's_sec_id');

        $data = $request->only('text', 'sec_id', 'sorder', 'status');

        /*if(!empty($data['birthdate'])) {
            $data['birthdate'] = str_replace('/','',$data['birthdate']);
        }*/
        $sorder = $data['sorder'];
        if (!empty($filename)) {
            $data['avatar'] = $filename;
            if ($slider['avatar'] != '' && file_exists(public_path('/images/sliders/' . $slider['avatar']))) {
                unlink(public_path('/images/sliders/' . $slider['avatar']));
            }
        }

        try {
            $slider->fill($data)->save();
            $allSliders = Slider::where('sorder', '>=', $sorder)->where('id', '!=', $id)->orderBy('sorder', 'asc')->orderBy('created_at', 'desc')->get();
            if ($allSliders->count() > 0) {
                foreach ($allSliders as $key => $value) {
                    $sorder = $sorder + 1;
                    $value->sorder = $sorder;
                    $value->save();
                }
            }
            //if(is_Array($allSliders))
            $message = 'اسلایدر با موفقیت ویرایش شد';
            $flash = 'flash_success';

        } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }


        $params = array(
            'id' => $id,
            's_status' => $backParams['s_status'],
            's_sec_id' => $backParams['s_sec_id'],
            'page' => $backParams['page'],
            'slider' => $slider
        );

        return redirect()->route('slider.edit', $params)
            ->with($flash,
                $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $backParams = $request->only('page', 's_status', 's_sec_id');

        if (empty($backParams['page'])) {
            $backParams['page'] = 1;
        }

        $params = array('s_status' => $backParams['s_status'],

            's_sec_id' => $backParams['s_sec_id'],
            'page' => $backParams['page']
        );

        //Find a user with a given id and delete
        $user = Slider::findOrFail($id);
        $user->delete();

        return redirect()->route('slider.list', $params)
            ->with('flash_message',
                'کاربر با موفقیت حذف شد');
    }
}
