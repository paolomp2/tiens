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

use tiens\Document;
use tiens\Notification;
use tiens\Gallery;
use tiens\Gallery_category;
use tiens\User;
use tiens\Country;
use tiens\sessionsMath;
use Session;
use Redirect;
use File;
use Zipper;
use Image;

class galleryController extends Controller
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
                $galleries = Gallery::withTrashed()->orderBy('created_at', 'desc')->get();
                break;
            case 2:
                $galleries = Gallery::withTrashed()->whereHas('Countries',function($q){
                    $q->where('id',Auth::user()->country_id);
                })->orderBy('created_at', 'desc')->get();
                break;
            default:
                # code...
                break;
        }
        
        foreach ($galleries as $gallery) {
            //loading author
            $Created_by=$gallery->User;
            $gallery['Created_by']=$Created_by;
            //loading category
            $category=$gallery->Category;
            $gallery['Category']=$category;
            //loading category
            $countries=$gallery->Countries;
            $gallery['countries']=$countries;
            //loading documents
            $document=$gallery->Documents;
            $gallery['documents']=$document;
        }
        return view('gallery.index',compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $categories = Gallery_category::get();

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

        $model = 1;
        $edit_flag = 0;
        return view('gallery.create', compact('options_selected','options_countries','rol','sessionMath','model','edit_flag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        set_time_limit(600);
        /*Validator section*/
         $validator = Validator::make($request->all(),$this->getValidations(true));

        if ($validator->fails()) {
            return redirect('gallery/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        /*Creating Gallery*/
        $gallery = new Gallery;
        $gallery->name = $request->title;
        $gallery->description = $request->content;
            //Recuperando la ID de la categor'ia
            $categories = Gallery_category::get();
        $gallery->category_id = $categories[$request->category]->id;
        $gallery->sessionMath = $request->sessionMath;
        $gallery->country_id = Auth::user()->country_id;
        
        $gallery->save();

        $user = User::find(Auth::user()->id);
        $user->Gallery()->save($gallery);

        if(!is_null($request->file('imagen'))){
            /*store Image*/
            $imageName = 'gallery_'.$gallery->id.'.'.$request->file('imagen')->getClientOriginalExtension();

            $request->file('imagen')->move(
                base_path() . '/public/images/gallery/', $imageName
            );
            $gallery->extension = $request->file('imagen')->getClientOriginalExtension();
            $gallery->save();
        }else{            
        }
        

        /*Adding Countries*/

        switch (Auth::user()->rol_id) {
            case 1:
                foreach ($request->countries as $countries_id_less1) {
                    $country = Country::find($countries_id_less1+1);
                    $gallery->Countries()->save($country);
                    $not = new Notification;
                    $not->message = "Nueva galería: ".$gallery->name;
                    $not->model_type = "gallery";
                    $not->model_id = $gallery->id;
                    $not->country_id = $country->id;                    
                    $not->save();

                    $not = new Notification;
                    $not->message = "Video editado: ".$gallery->name;
                    $not->model_type = "gallery";
                    $not->model_id = $gallery->id;
                    $not->country_id = $country->country_id;                    
                    $not->save();     
                }
                break;

            case 2:
                $country = Country::find(Auth::user()->country_id);
                $gallery->Countries()->save($country);
                $not = new Notification;
                $not->message = "Nueva galería: ".$gallery->name;
                $not->model_type = "gallery";
                $not->model_id = $gallery->id;
                $not->country_id = $country->id;                    
                $not->save();

                $not = new Notification;
                $not->message = "Video editado: ".$gallery->name;
                $not->model_type = "gallery";
                $not->model_id = $gallery->id;
                $not->country_id = $country->country_id;                    
                $not->save();  
                break;
            
            default:
                # code...
                break;
        }

        /*Addin documents*/
        $documents = Document::where('sessionMath',$request->sessionMath)->get();

        $array_files_to_zip = array();
        foreach ($documents as $document) {
            $name = base_path() . '/public/documentos/'.$document->id.'.'.$document->extension;
            
            if (file_exists($name)) {
                array_push($array_files_to_zip,'documentos/'.$document->id.'.'.$document->extension);    
                $gallery->Documents()->save($document);                    
            }else{
                echo "this file don't exist";
                $document->delete();
            }
                
        }
        //Zipping Files
        Zipper::make('documentos/'.$gallery->id.'.zip')->folder('')->add($array_files_to_zip);//Creating zip file using array files
        //File::move($gallery->id.'.zip', $newfile)//Moving zip file to documentos folder


        return Redirect::to('/gallery');
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
        $gallery = Gallery::find($id);

        $categories = Gallery_category::get();
        $i=0;
        foreach ($categories as $category) {
            $options_category[$i]=$category->name;
            if($gallery->Category->id==$category->id)
                $category_index_selected=$i;
            $i++;
        }
        //loading documents
        $num_docs_total = Document::withTrashed()->where('father_id',$id)->where('model_type',1)->get();
        //echo dd($num_docs_total);
        $num_docs=0;
        foreach ($num_docs_total as $docs) {
            $num_docs++;
        }
        

        $documents=Document::where('father_id',$id)->where('model_type',1)->get();
        //echo dd($documents);
        $gallery['documents_selected']=$documents;

        $categories = Gallery_category::get();

        $rol = Auth::user()->rol_id;
        if ($rol==1) {
            //Carga de pa'ises del Gallery
            $Countries_selected=$gallery->Countries()->get();
            $gallery['countries_selected'] = $Countries_selected;
            //Carga de todos los paises
            $Countries = Country::All();
            $i=0;
            foreach ($Countries as $Country) {
                $options_countries[$i++] = $Country['name'];
            }
        }
        //SessionMath
        $sessionMath = $gallery->sesionMath;
        $model = 1;
        $edit_flag = 1;
        return view('gallery.update', compact('gallery','category_index_selected','options_countries','options_category','rol','sessionMath','num_docs','model','documents','edit_flag'));
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
            return redirect('gallery/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        /*Gallery*/
        $gallery = Gallery::find($id);
        $gallery->name = $request->title;
        $gallery->description = $request->content;
        
            //Recuperando la ID de la categor'ia
            $categories = Gallery_category::get();
        $gallery->category_id = $categories[$request->category]->id;
        if(!is_null($request->file('imagen')))
        {
            $gallery->extension = $request->file('imagen')->getClientOriginalExtension();
            $gallery->sessionMath = $request->sessionMath;
            /*store Image*/
            $imageName = 'gallery_'.$gallery->id.'.'.$request->file('imagen')->getClientOriginalExtension();

            $request->file('imagen')->move(
                base_path() . '/public/images/gallery/', $imageName
            );   
        }
        
        $gallery->save();

        

        /*Adding Countries*/

        switch (Auth::user()->rol_id) {
            case 1:
                $gallery->Countries()->detach();
                foreach ($request->countries as $countries_id_less1) {
                    $country = Country::find($countries_id_less1+1);
                    $gallery->Countries()->save($country);

                    $not = new Notification;
                    $not->message = "Galería editada: ".$gallery->name;
                    $not->model_type = "gallery";
                    $not->model_id = $gallery->id;
                    $not->country_id = $country->id;                    
                    $not->save();  
                }
                break;            
            default:
                $not = new Notification;
                $not->message = "Galería editada: ".$gallery->name;
                $not->model_type = "gallery";
                $not->model_id = $gallery->id;
                $not->country_id = Auth::user()->country_id;                    
                $not->save();  
                break;
        }
        
        $documents = Document::where('sessionMath',$request->sessionMath)->where('deleted_at',null)->where('model_type',1)->get();

        $array_files_to_zip = array();
        foreach ($documents as $document) {
            array_push($array_files_to_zip,'documentos/'.$document->id.'.'.$document->extension);    
            $gallery->Documents()->save($document);                  
        }
        //Zipping Files
        Zipper::make('documentos/'.$gallery->id.'.zip')->folder('')->add($array_files_to_zip);//Creating zip file using array files

        
        return Redirect::to('/gallery');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sessionMath,$id)
    {
        $gallery = Gallery::find($id)->delete();
        return Redirect::to('/gallery');
    }

    public function inactive($id)
    {
        $gallery = Gallery::find($id);

        $not = new Notification;
        $not->message = "Gallería desactivada: ".$gallery->name;
        $not->model_type = "gallery";
        $not->model_id = $gallery->id;                  
        $not->save();

        $gallery->delete();

        return Redirect::to('/gallery');
    }
    
    public function untrashed($id)
    {

        Gallery::onlyTrashed()->find($id)->restore();
        $gallery = Gallery::find($id);
        $not = new Notification;
        $not->message = "Gallería reactivada: ".$gallery->name;
        $not->model_type = "gallery";
        $not->model_id = $gallery->id;                   
        $not->save();
        return Redirect::to('/gallery');
    }

    private function getValidations($insert)
    {
        $validations = array(
            'title' => 'required|max:255',
            'category' => 'required'
            );

        if ($insert) {
            $validations['imagen'] = 'image|mimes:jpeg,jpg,bmp,png,gif|max:6000';            
        }
        

        if(Auth::user()->rol_id==1)
        {
            $validations['countries'] = 'required';
        }

        return $validations;
    }
}
