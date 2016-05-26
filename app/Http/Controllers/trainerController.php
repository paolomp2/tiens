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
use tiens\Trainer;
use tiens\User;
use tiens\Country;
use Session;
use Redirect;
use File;

class trainerController extends Controller
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

                $trainers = Trainer::withTrashed()->get();               
                break;
            case 2:
                $trainers = Trainer::withTrashed()->where('country_id',Auth::user()->country_id)->get();
                break;
            default:
                # code...
                break;
        }

        foreach ($trainers as $trainer) {
            //loading author
            $Created_by=$trainer->User;
            $trainer['Created_by']=$Created_by;
        }

        return view('trainer.index',compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trainer.create');
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
            return redirect('trainer/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $trainer = new Trainer;
        $trainer->name = $request->name;
        $trainer->description = $request->content;
        $trainer->extension = $request->file('imagen')->getClientOriginalExtension();
        $trainer->save();

        $user = User::find(Auth::user()->id);
        $user->Trainers()->save($trainer);

        $country = Country::find(Auth::user()->country_id);
        $country->Trainers()->save($trainer);

        /*store Image*/
        $imageName = 'trainer_'.$trainer->id.'.'.$request->file('imagen')->getClientOriginalExtension();

        $request->file('imagen')->move(
            base_path(). '/public/images/trainer/', $imageName
        );

        $not = new Notification;
        $not->message = "Capacitador agregado: ".$trainer->name;
        $not->model_type = "trainer";
        $not->model_id = $trainer->id;
        $not->country_id = 0;                    
        $not->save();  

        return Redirect::to('/trainer');
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
        $trainer = Trainer::find($id);
        return view('trainer.update',compact('trainer'));
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
            return redirect("trainer/".$id."/edit")
                        ->withErrors($validator)
                        ->withInput();
        }

        $trainer = Trainer::find($id);
        $trainer->name = $request->name;
        $trainer->description = $request->content;
        $trainer->save();

        /*store Image*/

        if (!is_null($request->file('imagen'))) {
            /*Deleting old image*/
            $imageName_old = 'trainer_'.$trainer->id.'.'.$trainer->extension;            
            File::delete('/public/images/trainer/'.$imageName_old);
            /*Store new image*/
            $imageName = 'trainer_'.$trainer->id.'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(
                base_path() . '/public/images/trainer/', $imageName
            );
            $trainer->extension = $request->file('imagen')->getClientOriginalExtension();
            $trainer->save();
        }

        $not = new Notification;
        $not->message = "Capacitador actualizado: ".$trainer->name;
        $not->model_type = "trainer";
        $not->model_id = $trainer->id;
        $not->country_id = 0;                    
        $not->save();  

        Session::flash('msg_edit_ok','León editado correctamente');
        return Redirect::to('/trainer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trainer = Trainer::find($id)->delete();
        return Redirect::to('/trainer');
    }

    public function inactive($id)
    {
        $trainer = Trainer::find($id);

        $not = new Notification;
        $not->message = "León desactivado: ".$trainer->name;
        $not->model_type = "trainer";
        $not->model_id = $trainer->id;                  
        $not->save();

        $trainer->delete();

        return Redirect::to('/trainer');
    }
    
    public function untrashed($id)
    {

        Trainer::onlyTrashed()->find($id)->restore();
        $trainer = Trainer::find($id);
        $not = new Notification;
        $not->message = "León reactivado: ".$trainer->name;
        $not->model_type = "trainer";
        $not->model_id = $trainer->id;                   
        $not->save();
        return Redirect::to('/trainer');
    }
}
