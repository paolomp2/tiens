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
use tiens\News;
use tiens\User;
use Session;
use Redirect;
use File;

class newsController extends Controller
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

                $newspaper = News::withTrashed()->orderBy('created_at', 'desc')->get();                
                break;
            case 2:
                
                $newspaper = News::withTrashed()->whereHas('Countries',function($q){
                    $q->where('id',Auth::user()->country_id);
                })->orderBy('created_at', 'desc')->get();
                break;
            default:
                # code...
                break;
        }
        /*echo Auth::user()->rol_id;
        echo dd($newspaper);*/

        foreach ($newspaper as $news) {
            $Countries=$news->Countries()->get();
            $news['countries']=$Countries;
            $Created_by = $news->User;
            $news['Created_by']=$Created_by;
        }
        
        //echo dd($newspaper);
        return view('news.index',compact('newspaper'));
        
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
        
        return view('news.create',compact('options','rol'));
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
            return redirect('news/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        /*Creating News*/
        $news = new News;
        $news->name = $request->news_name;
        $news->description = $request['news_content'];
        $news->extension = $request->file('imagen')->getClientOriginalExtension();
        $news->save();

        $user = User::find(Auth::user()->id);
        $user->News()->save($news);

        /*store Image*/
        $imageName = 'news_'.$news->id.'.'.$request->file('imagen')->getClientOriginalExtension();

        $request->file('imagen')->move(
            base_path() . '/public/images/news/', $imageName
        );

        /*Adding Countries*/

        switch (Auth::user()->rol_id) {
            case 1:
                foreach ($request->countries as $countries_id_less1) {
                    $country = Country::find($countries_id_less1+1);
                    $news->Countries()->save($country);
                    $not = new Notification;
                    $not->message = "Nueva Noticia: ".$news->name;
                    $not->model_type = "news";
                    $not->model_id = $news->id;
                    $not->country_id = $country->id;                    
                    $not->save();
                }
                break;

            case 2:
                $country = Country::find(Auth::user()->country_id);
                $news->Countries()->save($country);
                $not = new Notification;
                    $not->message = "Nuevo Noticia: ".$news->name;
                    $not->model_type = "news";
                    $not->model_id = $news->id;
                    $not->country_id = $country->id;                    
                    $not->save();
                break;
            
            default:
                # code...
                break;
        }
        
        return Redirect::to('/news');
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
        $news = News::find($id);
        $rol = Auth::user()->rol_id;

        if ($rol==1) {
            //Carga de pa'ises del News
            $Countries_selected=$news->Countries()->get();
            $news['countries_selected'] = $Countries_selected;
            //Carga de todos los paises
            $Countries = Country::All();
            $i=0;
            foreach ($Countries as $Country) {
                $options[$i++] = $Country['name'];
            }
        }
        return view('news.update',compact('options', 'news','rol'));
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
            return redirect("news/".$id."/edit")
                        ->withErrors($validator)
                        ->withInput();
        }

        $news = News::find($id);

        /*store Image*/

        if (!is_null($request->file('imagen'))) {
            /*Deleting old image*/
            $imageName_old = 'news_'.$news->id.'.'.$news->extension;            
            File::delete('/public/images/news/'.$imageName_old);
            /*Store new image*/
            $imageName = 'news_'.$news->id.'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(
                base_path() . '/public/images/news/', $imageName
            );
            $news->extension = $request->file('imagen')->getClientOriginalExtension();
            $news->save();
        }
        $news->name = $request->news_name;
        $news->description = $request->news_content;
        $news->save();

        //Este es el caso en que es un Administrador de regi'on y actualiza todos
        //los pa'ises de la regi'on
        if(Auth::user()->rol_id==1)
        {
            $news->Countries()->detach();
            foreach ($request->countries as $countries_id_less1) {
                $country = Country::find($countries_id_less1+1);
                $news->Countries()->save($country);
            }
            $not = new Notification;
            $not->message = "Noticia editada: ".$news->name;
            $not->model_type = "news";
            $not->model_id = $news->id;
            $not->country_id = $country->id;                    
            $not->save();
        }
        
        Session::flash('msg_edit_ok','News editado correctamente');
        return Redirect::to('/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::find($id)->delete();
        return Redirect::to('/news');
    }

    public function inactive($id)
    {
        $news = News::find($id);

        $not = new Notification;
        $not->message = "Noticia desactivada: ".$news->name;
        $not->model_type = "news";
        $not->model_id = $news->id;                  
        $not->save();

        $news->delete();

        return Redirect::to('/news');
    }
    
    public function untrashed($id)
    {

        News::onlyTrashed()->find($id)->restore();
        $news = News::find($id);
        $not = new Notification;
        $not->message = "Noticia reactivada: ".$news->name;
        $not->model_type = "news";
        $not->model_id = $news->id;                   
        $not->save();
        return Redirect::to('/news');
    }

    private function getValidations($insert)
    {
        $validations = array(
            'news_name' => 'required|max:255',
            'news_content' => 'required'
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

