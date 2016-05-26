<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Console;
use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;
use Hash;
use Crypt;
use tiens\Notification;
use tiens\Document;
use tiens\Training;
use tiens\Training_category;
use tiens\User;
use tiens\Country;
use tiens\sessionsMath;
use Session;
use Redirect;
use File;

class trainingController extends Controller
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
                $trainings = Training::withTrashed()->orderBy('created_at', 'desc')->get();               
                break;
            case 2:
                $trainings = Training::withTrashed()->whereHas('Countries',function($q){
                    $q->where('id',Auth::user()->country_id);
                })->orderBy('created_at', 'desc')->get();
                break;
            default:
                # code...
                break;
        }
        
        foreach ($trainings as $training) {
            //loading author
            $Created_by=$training->User;
            $training['Created_by']=$Created_by;
            //loading category
            $category=$training->Category;
            $training['Category']=$category;
            //loading documents
            $document=$training->Documents;
            $training['documents']=$document;
        }

        //echo dd($trainings);

        return view('training.index',compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $categories = Training_category::get();

        $i=0;
        foreach ($categories as $category) {
            $options_selected[$i++]=$category->name;
        }

        $rol = Auth::user()->rol_id;
        if($rol==1)
        {
            $Countries = Country::All();
            $i=0;
            foreach ($Countries as $Country) {
                $options_countries[$i++] = $Country['name'];
            }
        }
        //SessionMath
        $sessionsMath = new sessionsMath;
        $sessionsMath->save();
        $sessionsMath->md5 = Crypt::encrypt($sessionsMath->id);
        $sessionsMath->save();
        $sessionMath = $sessionsMath->md5;

        $model = 2;
        return view('training.create', compact('options_selected','options_countries','rol','sessionMath','model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*Validator section*/
         $validator = Validator::make($request->all(),$this->getValidations(true));

        if ($validator->fails()) {
            return redirect('training/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        /*Creating Training*/
        $training = new Training;
        $training->name = $request->title;
        $training->description = $request->content;
            //Recuperando la ID de la categor'ia
            $categories = Training_category::get();
        $training->category_id = $categories[$request->category]->id;  
        $training->extension = $request->file('imagen')->getClientOriginalExtension();
        $training->sessionMath = $request->sessionMath;
        $training->save();

        $user = User::find(Auth::user()->id);
        $user->Training()->save($training);

        /*store Image*/
        $imageName = 'training_'.$training->id.'.'.$request->file('imagen')->getClientOriginalExtension();

        $request->file('imagen')->move(
            base_path() . '/public/images/training/', $imageName
        );

        /*Adding Countries*/

        switch (Auth::user()->rol_id) {
            case 1:
                foreach ($request->countries as $countries_id_less1) {
                    $country = Country::find($countries_id_less1+1);
                    $training->Countries()->save($country);
                    $not = new Notification;
                    $not->message = "Capacitación agregada: ".$training->name;
                    $not->model_type = "training";
                    $not->model_id = $training->id;
                    $not->country_id = $country->id;                    
                    $not->save();  
                }
                break;

            case 2:
                $country = Country::find(Auth::user()->country_id);
                $training->Countries()->save($country);
                $not->message = "Capacitación agregada: ".$training->name;
                $not->model_type = "training";
                $not->model_id = $training->id;
                $not->country_id = $country->id;                    
                $not->save();  
                break;
            
            default:
                # code...
                break;
        }

        /*Addin documents*/
        $documents = Document::where('sessionMath',$request->sessionMath)->get();

        foreach ($documents as $document) {
            $training->Documents()->save($document);
        }

        
        return Redirect::to('/training');
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
        $training = Training::find($id);

        $categories = Training_category::get();
        $i=0;
        foreach ($categories as $category) {
            $options_category[$i]=$category->name;
            if($training->Category->id==$category->id)
                $category_index_selected=$i;
            $i++;
        }
        //loading documents
        $num_docs_total = Document::withTrashed()->where('father_id',$id)->where('model_type',2)->get();
        //echo dd($num_docs_total);
        $num_docs=0;
        foreach ($num_docs_total as $docs) {
            $num_docs++;
        }
        

        $document=$training->Documents;
        $training['documents_selected']=$document;

        $categories = Training_category::get();

        $rol = Auth::user()->rol_id;
        if ($rol==1) {
            //Carga de pa'ises del Training
            $Countries_selected=$training->Countries()->get();
            $training['countries_selected'] = $Countries_selected;
            //Carga de todos los paises
            $Countries = Country::All();
            $i=0;
            foreach ($Countries as $Country) {
                $options_countries[$i++] = $Country['name'];
            }
        }
        //SessionMath
        $sessionMath = $training->sesionMath;
        $model = 2;

        return view('training.update', compact('training','category_index_selected','options_countries','options_category','rol','sessionMath','num_docs','model'));
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
        
        /*Validator section*/
         $validator = Validator::make($request->all(),$this->getValidations(false));

        if ($validator->fails()) {
            return redirect('training/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        /*Training*/
        $training = Training::find($id);
        $training->name = $request->title;
        $training->description = $request->content;
        
            //Recuperando la ID de la categor'ia
            $categories = Training_category::get();
        $training->category_id = $categories[$request->category]->id;
        if(!is_null($request->file('imagen')))
        {
            $training->extension = $request->file('imagen')->getClientOriginalExtension();
            $training->sessionMath = $request->sessionMath;
            /*store Image*/
            $imageName = 'training_'.$training->id.'.'.$request->file('imagen')->getClientOriginalExtension();

            $request->file('imagen')->move(
                base_path() . '/public/images/training/', $imageName
            );   
        }
        
        $training->save();

        

        /*Adding Countries*/
        $not = new Notification;
        switch (Auth::user()->rol_id) {
            case 1:
                $training->Countries()->detach();
                foreach ($request->countries as $countries_id_less1) {
                    $country = Country::find($countries_id_less1+1);
                    $training->Countries()->save($country);
                    $not->message = "Capacitación editada: ".$training->name;
                    $not->model_type = "training";
                    $not->model_id = $training->id;
                    $not->country_id = $country->id;                    
                    $not->save();  
                }
                break;            
            default:
                $not->message = "Capacitación agregada: ".$training->name;
                $not->model_type = "training";
                $not->model_id = $training->id;
                $not->country_id = Auth::user()->country_id;                    
                $not->save();  
                break;
        }
        
        $documents = Document::where('sessionMath',$request->sessionMath)->where('deleted_at',null)->get();

        foreach ($documents as $document) {
            $training->Documents()->save($document);
        }

        
        return Redirect::to('/training');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sessionMath,$id)
    {
        $training = Training::find($id)->delete();
        return Redirect::to('/training');
    }

    public function inactive($id)
    {
        $training = Training::find($id);

        $not = new Notification;
        $not->message = "Capacitación desactivada: ".$training->name;
        $not->model_type = "training";
        $not->model_id = $training->id;                  
        $not->save();

        $training->delete();

        return Redirect::to('/training');
    }
    
    public function untrashed($id)
    {

        Training::onlyTrashed()->find($id)->restore();
        $training = Training::find($id);
        $not = new Notification;
        $not->message = "Capacitación reactivada: ".$training->name;
        $not->model_type = "training";
        $not->model_id = $training->id;                   
        $not->save();
        return Redirect::to('/training');
    }

    private function getValidations($insert)
    {
        $validations = array(
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required'
            );

        if ($insert) {
            $validations['imagen'] = 'required|image|mimes:jpeg,jpg,bmp,png,gif|max:6000';            
        }
        

        if(Auth::user()->rol_id==1)
        {
            $validations['countries'] = 'required';
        }

        return $validations;
    }
}
