<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Console;
use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;
use tiens\Notification;
use tiens\Lion;
use tiens\User;
use tiens\Country;
use Session;
use Redirect;
use File;

class lionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch (Auth::user()->rol_id) {
            case 1:
                //Carga de los datos a la sesion

                $lions = Lion::withTrashed()->get();               
                break;
            case 2:
                $lions = Lion::withTrashed()->where('country_id',Auth::user()->country_id)->get();
                break;
            default:
                # code...
                break;
        }

        foreach ($lions as $lion) {
            //loading author
            $Created_by=$lion->User;
            $lion['Created_by']=$Created_by;
        }

        return view('lion.index',compact('lions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'content' => 'required',
            'imagen' => 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:6000'
        ]);

        if ($validator->fails()) {
            return redirect('lion/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $lion = new Lion;
        $lion->name = $request->name;
        $lion->description = $request->content;
        $lion->extension = $request->file('imagen')->getClientOriginalExtension();
        $lion->save();

        $user = User::find(Auth::user()->id);
        $user->Lions()->save($lion);

        $country = Country::find(Auth::user()->country_id);
        $country->Lions()->save($lion);

        /*store Image*/
        $imageName = 'lion_'.$lion->id.'.'.$request->file('imagen')->getClientOriginalExtension();

        $request->file('imagen')->move(
            base_path(). '/public/images/lion/', $imageName
        );

        $not = new Notification;
        $not->message = "León agregado: ".$lion->name;
        $not->model_type = "lion";
        $not->model_id = $lion->id;
        $not->country_id = 0;                    
        $not->save();  

        return Redirect::to('/lion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lion = Lion::find($id);
        return view('lion.update',compact('lion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect("lion/".$id."/edit")
                        ->withErrors($validator)
                        ->withInput();
        }

        $lion = Lion::find($id);
        $lion->name = $request->name;
        $lion->description = $request->content;
        $lion->save();

        /*store Image*/

        if (!is_null($request->file('imagen'))) {
            /*Deleting old image*/
            $imageName_old = 'lion_'.$lion->id.'.'.$lion->extension;            
            File::delete('/public/images/lion/'.$imageName_old);
            /*Store new image*/
            $imageName = 'lion_'.$lion->id.'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(
                base_path() . '/public/images/lion/', $imageName
            );
            $lion->extension = $request->file('imagen')->getClientOriginalExtension();
            $lion->save();
        }

        $not = new Notification;
        $not->message = "León actualizado: ".$lion->name;
        $not->model_type = "lion";
        $not->model_id = $lion->id;
        $not->country_id = 0;                    
        $not->save();  

        Session::flash('msg_edit_ok','León editado correctamente');
        return Redirect::to('/lion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inactive($id)
    {
        $lion = Lion::find($id);

        $not = new Notification;
        $not->message = "León desactivado: ".$lion->name;
        $not->model_type = "lion";
        $not->model_id = $lion->id;                  
        $not->save();

        $lion->delete();

        return Redirect::to('/lion');
    }
    
    public function untrashed($id)
    {

        Lion::onlyTrashed()->find($id)->restore();
        $lion = Lion::find($id);
        $not = new Notification;
        $not->message = "León reactivado: ".$lion->name;
        $not->model_type = "lion";
        $not->model_id = $lion->id;                   
        $not->save();
        return Redirect::to('/lion');
    }
}
