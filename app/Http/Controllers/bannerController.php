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
use tiens\Country;
use tiens\Banner;
use tiens\User;
use Session;
use Redirect;
use File;
use Image;

class bannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        

        switch (Auth::user()->rol_id) {
            case 1:
                //Carga de los datos a la sesion
                $banners = Banner::withTrashed()->orderBy('created_at', 'desc')->get();                
                break;
            case 2:                
                $banners = Banner::withTrashed()->whereHas('Countries',function($q){
                    $q->where('id',Auth::user()->country_id);
                })->orderBy('created_at', 'desc')->get();
                break;
            default:
                # code...
                break;
        }

        foreach ($banners as $banner) {
            $Countries=$banner->Countries()->get();
            $banner['countries']=$Countries;
            
            $Created_by = $banner->User;
            $banner['Created_by']=$Created_by;
        }
        
        //echo dd($banners);
        return view('banner.index',compact('banners'));
        break;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rol = Auth::user()->rol_id;
        if($rol==1)
        {
            $Countries = Country::All();
            $i=0;
            foreach ($Countries as $Country) {
                $options[$i++] = $Country['name'];
            }
        }

        
        return view('banner.create',compact('options','rol'));
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
            return redirect('banner/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        /*Creating Banner*/
        $banner = new Banner;
        $banner->name = $request->banner_name;
        $banner->description = $request['banner_content'];        
        $banner->extension = $request->file('imagen')->getClientOriginalExtension();
        $banner->save();

        $user = User::find(Auth::user()->id);
        $user->Banners()->save($banner);

        /*store Image*/
        $imageName = 'banner_'.$banner->id.'.'.$request->file('imagen')->getClientOriginalExtension();

        $request->file('imagen')->move(
            base_path() . '/public/images/banner/', $imageName
        );

        Image::make(base_path() . '/public/images/banner/'.$imageName)->resize(1170, 491)->save(base_path() . '/public/images/banner/'.$imageName);

        /*Adding Countries*/

        switch (Auth::user()->rol_id) {
            case 1:
                foreach ($request->countries as $countries_id_less1) {
                    $country = Country::find($countries_id_less1+1);
                    $banner->Countries()->save($country);

                    $not = new Notification;
                    $not->message = "Nuevo Banner: ".$banner->name;
                    $not->model_type = "banner";
                    $not->model_id = $banner->id;
                    $not->country_id = $country->id;                    
                    $not->save();
                }
                break;

            case 2:
                $country = Country::find(Auth::user()->country_id);
                $banner->Countries()->save($country);
                $not = new Notification;
                $not->message = "Nuevo Banner: ".$banner->name;
                $not->model_type = "banner";
                $not->model_id = $banner->id;
                $not->country_id = $country->id;                    
                $not->save();
                break;
            
            default:
                # code...
                break;
        }

        

        return Redirect::to('/banner');
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
        $banner = Banner::find($id);
        $rol = Auth::user()->rol_id;
        if ($rol==1) {
            //Carga de pa'ises del Banner
            $Countries_selected=$banner->Countries()->get();
            $banner['countries_selected'] = $Countries_selected;
            //Carga de todos los paises
            $Countries = Country::All();
            $i=0;
            foreach ($Countries as $Country) {
                $options[$i++] = $Country['name'];
            }
        }
        return view('banner.update',compact('options', 'banner','rol'));
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
            return redirect("banner/".$id."/edit")
                        ->withErrors($validator)
                        ->withInput();
        }

        $banner = Banner::find($id);

        /*store Image*/

        if (!is_null($request->file('imagen'))) {
            /*Deleting old image*/
            $imageName_old = 'banner_'.$banner->id.'.'.$banner->extension;            
            File::delete('/public/images/banner/'.$imageName_old);
            /*Store new image*/
            $imageName = 'banner_'.$banner->id.'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(
                base_path() . '/public/images/banner/', $imageName
            );
            $banner->extension = $request->file('imagen')->getClientOriginalExtension();
            $banner->save();
        }

        $banner->name = $request->banner_name;
        $banner->description = $request->banner_content;
        $banner->save();


        //Este es el caso en que es un Administrador de regi'on y actualiza todos
        //los pa'ises de la regi'on
        if(Auth::user()->rol_id==1)
        {
            $banner->Countries()->detach();
            foreach ($request->countries as $countries_id_less1) {
                $country = Country::find($countries_id_less1+1);
                $banner->Countries()->save($country);
                $not = new Notification;
                $not->message = "Banner editado: ".$banner->name;
                $not->model_type = "banner";
                $not->model_id = $banner->id;
                $not->country_id = $country->id;                    
                $not->save();
            }
        }else
        {
            $not = new Notification;
            $not->message = "Banner editado: ".$banner->name;
            $not->model_type = "banner";
            $not->model_id = $banner->id;
            $not->country_id = Auth::user()->rol_id;                    
            $not->save();
        }

        
        
        Session::flash('msg_edit_ok','Banner editado correctamente');
        return Redirect::to('/banner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id)->delete();
        return Redirect::to('/banner');
    }

    public function inactive($id)
    {
        $banner = Banner::find($id);

        $not = new Notification;
        $not->message = "Banner desactivado: ".$banner->name;
        $not->model_type = "banner";
        $not->model_id = $banner->id;                  
        $not->save();

        $banner->delete();

        return Redirect::to('/banner');
    }
    
    public function untrashed($id)
    {

        Banner::onlyTrashed()->find($id)->restore();
        $banner = Banner::find($id);
        $not = new Notification;
        $not->message = "Banner reactivado: ".$banner->name;
        $not->model_type = "banner";
        $not->model_id = $banner->id;                   
        $not->save();
        return Redirect::to('/banner');
    }

    private function getValidations($insert)
    {
        $validations = array(
            'banner_name' => 'required|max:255',
            'banner_content' => 'required'
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
