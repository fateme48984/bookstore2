<?php

namespace Modules\Books\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Books\Entities\Setting;
use Illuminate\Support\Facades\DB;
use Hekmatinasser\Verta\Verta;

use Auth;
use Session;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'/*, 'isAdmin'*/]); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
       // return view('books::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
       // return view('books::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
       // return view('books::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id); //Get user with specified id

        return view('books::setting.edit', compact('setting')); //pass author data to view

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id); //Get user with specified id
        $data = $request->only( 'description');

       // try {
            $setting->fill($data)->save();
            
            $message = 'محتوا با موفقیت ویرایش شد';
            $flash = 'flash_success';

     /*   } catch (\Exception $e) {
            $message = 'انجام عملیات با مشکل مواجه شد';
            $flash = 'flash_error';
        }*/

        return redirect()->route('setting.edit' , $setting)
            ->with($flash,
                $message);


    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
