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
use tiens\Video;
use tiens\Video_category;
use tiens\User;
use tiens\Country;
use tiens\routes;
use Session;
use Redirect;
use File;
use Image;

class movieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $movies_to_destroy = Video::where('name',null)->get();

        foreach ($movies_to_destroy as $movie_to_destroy) {
            $movie_to_destroy->forceDelete();
        }

        switch (Auth::user()->rol_id) {
            case 1:
                //Carga de los datos a la sesion
                $movies = Video::withTrashed()->orderBy('created_at', 'desc')->get();
                break;
            case 2:
                $movies = Video::withTrashed()->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->get();
                break;
            default:
                # code...
                break;
        }
        
        foreach ($movies as $movie) {
            //loading author
            $Created_by=$movie->User;
            $movie['Created_by']=$Created_by;
            //loading category
            $category=$movie->Category;
            $movie['Category']=$category;
            //loading category
            $country=$movie->Countries;
            $movie['country']=$country;
        }        

        //echo dd($movie);
        $rol=Auth::user()->rol_id;
        return view('movie.index',compact('movies','rol'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $categories = Video_category::get();

        $i=0;
        foreach ($categories as $category) {
            $categories_option[$i++]=$category->name;
        }

        $rol = Auth::user()->rol_id;

        $url = routes::find(1)->route;
        $movie_folder = routes::find(2)->route;

        $i=0;
        foreach (Country::get() as $country) {
            $countries_options[$i++] = $country->name;
        }

        return view('movie.create', compact('categories_option','options_countries','rol','sessionMath','model','url','movie_folder','countries_options'));
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
            return redirect('movie/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        /*Creating Video*/
        if($request->Video==-1){
            $movie = new Video;
            $movie->save();
        }
        else    
            $movie = Video::find($request->Video);

        if($request->youtube_link!="")
        {
            $movie->youtube_link = $request->id_youtube;
            $movie->flag_youtube = 1;
        }

        $movie->name = $request->title;
        $movie->description = $request->content;
            //Recuperando la ID de la categor'ia
            $categories = Video_category::get();
        $movie->category_id = $categories[$request->category]->id;
        //    
        $movie->save();

        /*Adding Countries*/
        if(Auth::user()->rol_id==1)
        {
            $country = Country::find($request->country+1);
        }else{
            $country = Country::find(Auth::user()->country_id);               
        }
        $country->Videos()->save($movie); 

        $user = User::find(Auth::user()->id);
        $user->Videos()->save($movie);

        if (!is_null($request->file('imagen'))) {
            /*store Image*/
            $imageName = 'movies_'.$movie->id.'.'.$request->file('imagen')->getClientOriginalExtension();

            $request->file('imagen')->move(
                base_path() . '/public/images/movie/', $imageName
            );
            $movie->extension_img = $request->file('imagen')->getClientOriginalExtension();
            $movie->save();
        }else{
            /*Deleting old image*/
            $imageName_old = 'movies_'.$movie->id.'.'.$movie->extension;            
            File::delete('/public/images/movie/'.$imageName_old);
            /*Store new image*/

            Image::make(base_path() . '/public/images/movie/default.png')->resize(850, 450)->save(base_path() . '/public/images/movie/movies_'.$movie->id.'.png');

            $movie->extension_img = 'png';
            $movie->save();
        }

        $not = new Notification;
        $not->message = "Nuevo video: ".$movie->name;
        $not->model_type = "movie";
        $not->model_id = $movie->id;
        $not->country_id = $country->id;                    
        $not->save();
                
        return Redirect::to('/movie');
    }

    public function store_movie(Request $request)
    {
        
        if ($request->ajax()) {

            if($request->id==-1)
                $movie = new Video;
            else
                $movie = Video::find($request->id);

            if($request->type==1)
            {
                $name_video = "movie_l_";
                $movie->flag_low_quality = 1;
            }
                

            if($request->type==2)
            {
                $name_video = "movie_h_";
                $movie->flag_hight_quality = 1;
            }
                

            $movie->extension = $request->file('movie_file')->getClientOriginalExtension();
            $movie->size = $request->size;
            $movie->save();

            if(!is_null($request->file('movie_file'))){

                /*store Image*/
                $movieName = $name_video.$movie->id.'.'.$request->file('movie_file')->getClientOriginalExtension();                

                $request->file('movie_file')->move(
                    base_path() . '/public/video/', $movieName
                );

                return response()->json([
                    "id" => $movie->id,
                    "extension" => $request->file('movie_file')->getClientOriginalExtension()
                    ]);    
            }

        }else{
              return Redirect::to('/movie');  
        }
        
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
        $movie = Video::find($id);

        $categories = Video_category::get();
        $i=0;
        foreach ($categories as $category) {
            $categories_option[$i]=$category->name;
            if($movie->Category->id==$category->id)
                $category_index_selected=$i;
            $i++;
        }

        $categories = Video_category::get();

        $url = routes::find(1)->route;
        $movie_folder = routes::find(2)->route;
        $rol = Auth::user()->rol_id;



        return view('movie.update', compact('movie','category_index_selected','categories_option','rol','url','movie_folder'));
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
            return redirect('movie/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        /*Video*/
        $movie = Video::find($id);
        $movie->name = $request->title;
        $movie->description = $request->content;
        
            //Recuperando la ID de la categor'ia
            $categories = Video_category::get();
        $movie->category_id = $categories[$request->category]->id;
        if($request->youtube_link!="")
        {
            $movie->youtube_link = $request->id_youtube;
            $movie->flag_youtube = 1;
        }
        $movie->save();

        if (!is_null($request->file('imagen'))) {
            /*Deleting old image*/
            $imageName_old = 'movies_'.$movie->id.'.'.$movie->extension_img;            
            File::delete('/public/images/movie/'.$imageName_old);
            /*Store new image*/
            $imageName = 'movies_'.$movie->id.'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(
                base_path() . '/public/images/movie/', $imageName
            );
            $movie->extension_img = $request->file('imagen')->getClientOriginalExtension();
            $movie->save();
        }

        /*Adding Countries*/

        switch (Auth::user()->rol_id) {
            case 1:
                $movie->country_id = $request->country - 1;
            default:
                break;
        }

        $not = new Notification;
        $not->message = "Video editado: ".$movie->name;
        $not->model_type = "movie";
        $not->model_id = $movie->id;
        $not->country_id = Auth::user()->country_id;                    
        $not->save();        
        return Redirect::to('/movie');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sessionMath,$id)
    {
        $movie = Video::find($id)->delete();
        return Redirect::to('/movie');
    }

    public function inactive($id)
    {
        $video = Video::find($id);

        $not = new Notification;
        $not->message = "Video desactivado: ".$video->name;
        $not->model_type = "movie";
        $not->model_id = $video->id;                  
        $not->save();

        $video->delete();

        return Redirect::to('/movie');
    }
    
    public function untrashed($id)
    {

        Video::onlyTrashed()->find($id)->restore();
        $video = Video::find($id);
        $not = new Notification;
        $not->message = "Video reactivado: ".$video->name;
        $not->model_type = "movie";
        $not->model_id = $video->id;                   
        $not->save();
        return Redirect::to('/movie');
    }

    private function getValidations($insert)
    {
        $validations = array(
            'title' => 'required|max:255',
            'category' => 'required'
            );
       if($insert)
       {
            $validations['imagen'] = 'image|mimes:jpeg,jpg,bmp,png,gif|max:6000';
            $validations['Video'] = 'required';
       }

        if(Auth::user()->rol_id==1 && $insert)
        {
            $validations['country'] = 'required';
        }

        return $validations;
    }
}
