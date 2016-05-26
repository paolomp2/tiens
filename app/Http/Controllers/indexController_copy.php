<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;

use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Vinkla\Hashids\Facades\Hashids;
use DB;
use Auth;
use Session;
use tiens\Notification;
use tiens\Content;
use tiens\Banner;
use tiens\News;
use tiens\Event;
use tiens\Trainer;
use tiens\Lion;
use tiens\Training;
use tiens\Document;
use tiens\Training_category;
use Carbon\Carbon;
use tiens\Gallery;
use tiens\Video;
use tiens\Searcher;
use tiens\Video_category;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class indexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $numBanners = 4;
        $numNews = 5;
        $numEvents = 4;
        $numtrainers = 5;
        $numtrainings = 5;
        $numGalleries = 8;

        //Caso en que es administrador regional
        if(Auth::user()->rol_id==1){
            $banners = Banner::orderBy('created_at', 'desc')->take($numBanners)->get();
            $newspaper = News::orderBy('created_at', 'desc')->take($numNews)->get();
            $events = Event::where('date_celebration','>=',Carbon::now())->orderBy('created_at', 'desc')->take($numEvents)->get();
            $trainers = Trainer::orderBy('created_at', 'desc')->take($numtrainers)->get();
            $trainings = Training::orderBy('created_at', 'desc')->take($numtrainings)->get();
            $galleries = Gallery::orderBy('created_at', 'desc')->take($numGalleries)->get();
            $movies = Video::whereNotNull('name')->orderBy('created_at', 'desc')->take($numGalleries)->get();
        }else{
            $banners = Banner::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->take($numBanners)
                            ->get();

            $newspaper = News::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->take($numNews)
                            ->get();

            $events = Event::where('date_celebration','>=',Carbon::now())->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($numEvents)->get();
            $trainers = Trainer::where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($numtrainers)->get();

            $trainings = Training::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->take($numtrainings)
                            ->get();

            $galleries = Gallery::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->take($numGalleries)
                            ->get();

            $movies = Video::whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($numtrainers)->get();
        }


        foreach ($trainings as $training) {
            $training['date']=Carbon::createFromFormat('Y-m-d H:i:s', $training->created_at)->format('Y-m-d');
        }
        foreach ($newspaper as $news) {
            $news['id_encode'] = Hashids::encode($news->id);
        }

        foreach ($galleries as $gallery) {
            $gallery['id_encode'] = Hashids::encode($gallery->id);
        }

        foreach ($movies as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'banners' => $banners,
            'newspaper'=>$newspaper,
            'events'=>$events,
            'trainers'=>$trainers,
            'trainings'=>$trainings,
            'galleries'=>$galleries,
            'movies'=>$movies,
            ];

        return view('index',compact('data'));
    }

    public function news()
    {
        $numNews = 3;
        if(Auth::user()->rol_id==1){
            $newspaper = News::orderBy('created_at', 'desc')->paginate($numNews);
        }else{
            $newspaper = News::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->paginate($numNews);
        }

        foreach ($newspaper as $news) {
            $news['id_encode'] = Hashids::encode($news->id);
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'newspaper'=>$newspaper,
            ];

        return view('index.news',compact('data'));
    }

    public function events()
    {
        $numEvents = 6;
        if(Auth::user()->rol_id==1){
            $events = Event::orderBy('created_at', 'desc')->paginate($numEvents);
        }else{
            $events = Event::where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->paginate($numEvents);
        }

        foreach ($events as $key => $event) {
            $event->Category();
            $event['id_encode'] = Hashids::encode($event->id);
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'events'=>$events,
            ];

        return view('index.events',compact('data'));
    }

    public function eventShow($id){

        $id = Hashids::decode($id);
        $event_show = Event::find($id[0]);

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'event_show'=>$event_show,
            ];

        return view('index.event_show',compact('data'));
    }

    public function lions_trainers()
    {
        $num_Lions_Trainers = 8;
        if(Auth::user()->rol_id==1){
            $lions = Lion::orderBy('created_at', 'desc')->take($num_Lions_Trainers)->get();
            $trainers = Trainer::orderBy('created_at', 'desc')->take($num_Lions_Trainers)->get();
        }else{
            $lions = Lion::where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($num_Lions_Trainers)->get();
            $trainers = Trainer::where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($num_Lions_Trainers)->get();
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'lions'=>$lions,
            'trainers'=>$trainers,
            ];

        return view('index.lions_trainers',compact('data'));
    }

    public function trainings()
    {
        $num_trainings = 6;
        $trainings_categories = Training_category::orderBy('created_at', 'desc')->get();
        if(Auth::user()->rol_id==1){            
            $trainings = Training::orderBy('created_at', 'desc')->paginate($num_trainings);
        }else{
            $trainings = Training::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->paginate($num_trainings);
        }
        foreach ($trainings_categories as $key => $training_category) {
            $training_category['id_encode'] = Hashids::encode($training_category->id);
        }

        foreach ($trainings as $key => $training) {
            $training['id_encode'] = Hashids::encode($training->id);
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'trainings'=>$trainings,
            'trainings_categories'=>$trainings_categories,
            ];

        return view('index.trainings',compact('data'));
    }

    public function trainingsCat($id)
    {

        $id = Hashids::decode($id);
        $num_trainings = 6;
        $trainings_categories = Training_category::orderBy('created_at', 'desc')->get();
        if(Auth::user()->rol_id==1){            
            $trainings = Training::where('category_id',$id)->orderBy('created_at', 'desc')->paginate($num_trainings);
        }else{
            $trainings = Training::where('category_id',$id)->whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->paginate($num_trainings);
        }

        foreach ($trainings_categories as $key => $training_category) {
            $training_category['id_encode'] = Hashids::encode($training_category->id);
        }

        foreach ($trainings as $key => $training) {
            $training['id_encode'] = Hashids::encode($training->id);
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'trainings'=>$trainings,
            'trainings_categories'=>$trainings_categories,
            ];

        return view('index.trainings',compact('data'));
    }


    public function trainingsShow($id)
    {
        $id = Hashids::decode($id);
        $training_show = Training::find($id[0]);
        $training_category_show = Training_category::find($training_show->category_id);
        
        $num_trainings = 6;
        if(Auth::user()->rol_id==1){            
            $trainings = Training::orderBy('created_at', 'desc')->take($num_trainings)->get();
            //Training of the category of trainging to show
            $trainings_category = Training::where('category_id',$training_show->category_id)->orderBy('created_at', 'desc')->take($num_trainings)->get();
        }else{
            $trainings = Training::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->take($num_trainings)
                            ->get();;

            $trainings_category = Training::where('category_id',$training_show->category_id)->whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->take($num_trainings)
                            ->get();;
        }

        foreach ($trainings as $key => $training) {
            $training['id_encode'] = Hashids::encode($training->id);
        }

        foreach ($trainings_category as $key => $training_category) {
            $training_category['id_encode'] = Hashids::encode($training_category->id);
        }

        //Documents
        $documents = Document::where('father_id',$id)->where('model_type',2)->get();
        
        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'trainings'=>$trainings,
            'trainings_category'=>$trainings_category,
            'training_show'=>$training_show,
            'training_category_show'=>$training_category_show,
            'documents'=>$documents,
            ];

        return view('index.training_show',compact('data'));
    }

    public function newsShow($id)
    {
        $id = Hashids::decode($id);
        $news_show = News::find($id[0]);

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'news_show'=>$news_show,
            ];

        return view('index.news_show',compact('data'));
    }

    public function gallery()
    {

        $num_last_galleries = 5;
        $num_galleries_event = 9;
        $num_galleries_other = 5;

        if(Auth::user()->rol_id==1){            
            $last_galleries = Gallery::orderBy('created_at', 'desc')->take($num_last_galleries)->get();
            $galleries_event = Gallery::where('category_id',1)->orderBy('created_at', 'desc')->paginate($num_galleries_event);
            $galleries_other = Gallery::where('category_id','<>',1)->orderBy('created_at', 'desc')->paginate($num_galleries_other);
        }else{
            $last_galleries = Gallery::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->take($num_last_galleries)
                            ->get();
            $galleries_event = Gallery::where('category_id',1)->whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->paginate($num_galleries_event);
            $galleries_other = Gallery::where('category_id','<>',1)->whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->paginate($num_galleries_other);
        }

        foreach ($last_galleries as $gallery) {
            $gallery['id_encode'] = Hashids::encode($gallery->id);
        }

        foreach ($galleries_event as $gallery) {
            $gallery['id_encode'] = Hashids::encode($gallery->id);
        }

        foreach ($galleries_other as $gallery) {
            $gallery['id_encode'] = Hashids::encode($gallery->id);
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'last_galleries' => $last_galleries,
            'galleries_event' => $galleries_event,
            'galleries_other' => $galleries_other,
            ];

        return view('index.gallery',compact('data'));
    }

    public function galleryShow($id)
    {   
        $num_images_per_page=40;
        $id = Hashids::decode($id);
        $training_show = Gallery::find($id[0]);

        $images =  Document::where('father_id',$id)->where('model_type',1)->paginate($num_images_per_page);

        if(Auth::user()->rol_id==1){            
            $last_galleries = Gallery::orderBy('created_at', 'desc')->get();            
        }else{
            $last_galleries = Gallery::whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->get();
        }

        foreach ($last_galleries as $gallery) {
            $gallery['id_encode'] = Hashids::encode($gallery->id);
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'images' => $images,
            'last_galleries' => $last_galleries,
            'training_show' => $training_show,
            ];

        return view('index.gallery_show',compact('data'));
    }

    public function movie()
    {

        $num_video_to_show = 2;
        $num_most_seen = 6;
        $num_last_videos = 9;

        $categories= Video_category::get();
        if(Auth::user()->rol_id==1){
            $movies_to_Show = Video::whereNotNull('name')->orderBy('created_at', 'desc')->take($num_video_to_show)->get();
            $last_movies = Video::whereNotNull('name')->orderBy('created_at', 'desc')->take($num_last_videos)->get();
            $most_seen= Video::whereNotNull('name')->orderBy('see_num', 'desc')->take($num_most_seen)->get();
            foreach ($categories as $category) {
                $category['count'] = Video::whereNotNull('name')->where('category_id',$category->id)->count();
                if ($category['count']>0) {
                    $category['last_video'] = Video::where('category_id',$category->id)->whereNotNull('name')->orderBy('created_at', 'desc')->take(1)->get();
                    $category['last_video'][0]['id_encode'] = Hashids::encode($category['last_video'][0]->id);
                    $category['id_encode'] = Hashids::encode($category->id);
                }
            }
        }else{
            $movies_to_Show = Video::whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($num_video_to_show)->get();
            $last_movies = Video::whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($num_last_videos)->get();
            $most_seen = Video::whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('see_num', 'desc')->take($num_most_seen)->get();
               foreach ($categories as $category) {                
                $category['count'] = Video::where('category_id',$category->id)->whereNotNull('name')->where('category_id',$category->id)->where('country_id',Auth::user()->country_id)->count();
                if ($category['count']>0) {
                    $category['last_video'] = Video::where('country_id',Auth::user()->country_id)->where('category_id',$category->id)->whereNotNull('name')->orderBy('created_at', 'desc')->take(1)->get();
                    $category['last_video'][0]['id_encode'] = Hashids::encode($category['last_video'][0]->id);
                    $category['id_encode'] = Hashids::encode($category->id);
                }
            }
        }

        //echo dd($categories);

        foreach ($last_movies as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        foreach ($most_seen as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        $type_data = "general";

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'movies_to_Show' => $movies_to_Show,
            'last_movies' => $last_movies,
            'most_seen' => $most_seen,
            'categories' => $categories,
            'type_data' => $type_data,
            ];

        return view('index.movie',compact('data'));
    }

    public function movieCat($id)
    {

        $id = Hashids::decode($id)[0];
        $category_to_show = Video_category::find($id);

        $num_video_to_show = 2;
        $num_most_seen = 6;
        $num_last_videos = 9;

        $categories= Video_category::get();
        if(Auth::user()->rol_id==1){
            $movies_to_Show = Video::where('category_id',$id)->whereNotNull('name')->orderBy('created_at', 'desc')->get();
            $last_movies = Video::whereNotNull('name')->orderBy('created_at', 'desc')->take($num_last_videos)->get();
            $most_seen= Video::whereNotNull('name')->orderBy('see_num', 'desc')->take($num_most_seen)->get();
            foreach ($categories as $category) {
                $category['count'] = Video::whereNotNull('name')->where('category_id',$category->id)->count();
                if ($category['count']>0) {                    
                    $category['id_encode'] = Hashids::encode($category->id);
                }
            }
            $movies_category = Video::where('category_id',$id)->whereNotNull('name')->orderBy('created_at', 'desc')->get();
        }else{
            $movies_to_Show = Video::where('category_id',$id)->whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->get();
            $last_movies = Video::whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($num_last_videos)->get();
            $most_seen = Video::whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('see_num', 'desc')->take($num_most_seen)->get();
               foreach ($categories as $category) {                
                $category['count'] = Video::where('category_id',$category->id)->whereNotNull('name')->where('category_id',$category->id)->where('country_id',Auth::user()->country_id)->count();
                if ($category['count']>0) {
                    $category['id_encode'] = Hashids::encode($category->id);
                }
            }
            $movies_category = Video::where('category_id',$id)->whereNotNull('name')->orderBy('created_at', 'desc')->where('country_id',Auth::user()->country_id)->get();
        }

        //echo dd($movies_to_Show);

        foreach ($last_movies as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        foreach ($most_seen as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        foreach ($movies_category as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        $type_data = "category";
        $name_category = "Categoría ".$category_to_show->name;

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'movies_to_Show' => $movies_to_Show,
            'last_movies' => $last_movies,
            'most_seen' => $most_seen,
            'categories' => $categories,
            'type_data' => $type_data,
            'name_category' => $name_category,
            'movies_category' => $movies_category,
            ];

        return view('index.movie',compact('data'));
    }

    public function movieShow($id)
    {

        $id = Hashids::decode($id)[0];

        $movies_to_Show[0] = Video::find($id);
        $movies_to_Show[0]->see_num = $movies_to_Show[0]->see_num + 1;
        $movies_to_Show[0]->last_time_see = $now = Carbon::now();
        $movies_to_Show[0]->save();

        $category_to_show = Video_category::find($movies_to_Show[0]->category_id);        
        $num_most_seen = 6;
        $num_last_videos = 9;

        $categories= Video_category::get();
        if(Auth::user()->rol_id==1){            
            $last_movies = Video::whereNotNull('name')->orderBy('created_at', 'desc')->take($num_last_videos)->get();
            $most_seen= Video::whereNotNull('name')->orderBy('see_num', 'desc')->take($num_most_seen)->get();
            foreach ($categories as $category) {
                $category['count'] = Video::whereNotNull('name')->where('category_id',$category->id)->count();
                if ($category['count']>0) {                    
                    $category['id_encode'] = Hashids::encode($category->id);
                }
            }
            $movies_category = Video::where('category_id',$category_to_show->id)->whereNotNull('name')->orderBy('created_at', 'desc')->get();
        }else{            
            $last_movies = Video::whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($num_last_videos)->get();
            $most_seen = Video::whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('see_num', 'desc')->take($num_most_seen)->get();
               foreach ($categories as $category) {                
                $category['count'] = Video::where('category_id',$category->id)->whereNotNull('name')->where('category_id',$category->id)->where('country_id',Auth::user()->country_id)->count();
                if ($category['count']>0) {
                    $category['id_encode'] = Hashids::encode($category->id);
                }
            }
            $movies_category = Video::where('category_id',$category_to_show->id)->whereNotNull('name')->orderBy('created_at', 'desc')->where('country_id',Auth::user()->country_id)->get();
        }

        //echo dd($movies_category);

        foreach ($last_movies as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        foreach ($most_seen as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        foreach ($movies_category as $movie) {
            $movie['id_encode'] = Hashids::encode($movie->id);
        }

        $type_data = "category";
        $name_category = "Categoría ".$category_to_show->name;

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'movies_to_Show' => $movies_to_Show,
            'last_movies' => $last_movies,
            'most_seen' => $most_seen,
            'categories' => $categories,
            'type_data' => $type_data,
            'name_category' => $name_category,
            'movies_category' => $movies_category,
            ];

        return view('index.movie',compact('data'));
    }

    public function notification()
    {

        $numNotificactions = 15;
        if(Auth::user()->rol_id==1){
            $notifications = Notification::orderBy('created_at', 'desc')->paginate($numNotificactions);
        }else{
            $notifications = Notification::where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->paginate($numNotificactions);
        }

        foreach ($notifications as $notification) {
            $notification['id_encode'] = Hashids::encode($notification->id);
        }

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'notifications' => $notifications,
            ];

        return view('index.notification',compact('data'));   
    }

    public function find(Request $request)
    {   
        echo "string";
        return redirect()->route('buscar',[$request->name]);
        
    }

    public function buscar($name){

        if(Auth::user()->rol_id==1){
            $newspaper = News::where('name','like',"%".$name."%")->orderBy('created_at', 'desc')->get();
            $events = Event::where('name','like',"%".$name."%")->orderBy('created_at', 'desc')->get();
            $lions = Lion::where('name','like',"%".$name."%")->orderBy('created_at', 'desc')->get();
            $trainers = Trainer::where('name','like',"%".$name."%")->orderBy('created_at', 'desc')->get();
            $trainings = Training::where('name','like',"%".$name."%")->orderBy('created_at', 'desc')->get();
            $galleries = Gallery::where('name','like',"%".$name."%")->orderBy('created_at', 'desc')->get();
            $movies = Video::where('name','like',"%".$name."%")->orderBy('created_at', 'desc')->get();
        }else{

            $newspaper = News::where('name','like',"%".$name."%")->whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->get();

            $events = Event::where('name','like',"%".$name."%")->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->get();
            $lions = Lion::where('name','like',"%".$name."%")->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->get();
            $trainers = Trainer::where('name','like',"%".$name."%")->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->get();

            $trainings = Training::where('name','like',"%".$name."%")->whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->get();

            $galleries = Gallery::where('name','like',"%".$name."%")->whereHas('Countries',function($q){
                                $q->where('id',Auth::user()->country_id);
                            })->orderBy('created_at', 'desc')
                            ->get();

            $movies = Video::where('name','like',"%".$name."%")->whereNotNull('name')->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->get();
        }

         $results = array();

        foreach ($newspaper as $element) {

            $resoult['created'] = $element->created_at;
            $resoult['type'] = 'Noticia';
            $resoult['id_encode'] = Hashids::encode($element->id);
            $resoult['name'] = $element->name;
            array_push($results, $resoult);
        }

        foreach ($events as $element) {
            $resoult['created'] = $element->created_at;
            $resoult['type'] = 'Evento';
            $resoult['id_encode'] = Hashids::encode($element->id);
            $resoult['name'] = $element->name;
            array_push($results, $resoult);
        }

        foreach ($lions as $element) {
            $resoult['created'] = $element->created_at;
            $resoult['type'] = 'León';
            $resoult['id_encode'] = Hashids::encode($element->id);
            $resoult['name'] = $element->name;
            array_push($results, $resoult);
        }

        foreach ($trainers as $element) {
            $resoult['created'] = $element->created_at;
            $resoult['type'] = 'Capacitador';
            $resoult['id_encode'] = Hashids::encode($element->id);
            $resoult['name'] = $element->name;
            array_push($results, $resoult);
        }

        foreach ($trainings as $element) {
            $resoult['created'] = $element->created_at;
            $resoult['type'] = 'Capacitación';
            $resoult['id_encode'] = Hashids::encode($element->id);
            $resoult['name'] = $element->name;
            array_push($results, $resoult);
        }

        foreach ($galleries as $element) {
            $resoult['created'] = $element->created_at;
            $resoult['type'] = 'Galería';
            $resoult['id_encode'] = Hashids::encode($element->id);
            $resoult['name'] = $element->name;
            array_push($results, $resoult);
        }

        foreach ($movies as $element) {
            $resoult['created'] = $element->created_at;
            $resoult['type'] = 'Video';
            $resoult['id_encode'] = Hashids::encode($element->id);
            $resoult['name'] = $element->name;
            array_push($results, $resoult);
        }

        $results = array_values(array_sort($results, function ($value) {
            return $value['created'];
        }));

        //Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        //Create a new Laravel collection from the array data
        $collection = new Collection($results);
        //Define how many items we want to be visible in each page
        $per_page = 15;
        //Slice the collection to get the items to display in current page
        $currentPageResults = $collection->slice(($currentPage-1) * $per_page, $per_page)->all();
        //Create our paginator and add it to the data array
        $paginatedSearchResults = new LengthAwarePaginator($currentPageResults, count($collection), $per_page);

        //Set base url for pagination links to follow e.g custom/url?page=6
        $paginatedSearchResults->setPath('');
        //echo dd($results);
        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'results' => $paginatedSearchResults,
            ];

        return view('index.search',compact('data'));  
    }

    
    public function not_dif_betwen_timezone(Request $request)
    {
        if ($request->ajax()) {
            $time_serv = Carbon::now();
            $time_pc = Carbon::parse($request->time_pc);

            $dif_min=$time_serv->diffInMinutes($time_pc);

            return response()->json([
                "dif_min" => $dif_min
            ]);    
        }
        
    }

    public function notification_popup(Request $request)
    {
        if ($request->ajax()) {

            $time = Carbon::now()->subSeconds(5);

            $numNotificactions = 10;
            if(Auth::user()->rol_id==1){
                $notifications = Notification::where('created_at','>',$time)->orderBy('created_at', 'desc')->take($numNotificactions)->get();
            }else{
                $notifications = Notification::where('created_at','>',$time)->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->take($numNotificactions)->get();
            }

            return response()->json([
                "not" => $notifications
            ]);    
        }
    }

    public function institution()
    {


        $mision = Content::find(1);
        $vision = Content::find(2);
        $values = Content::find(3);
        $hwa = Content::find(4);

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            'mision' => $mision,
            'vision' => $vision,
            'values' => $values,
            'hwa' => $hwa,
            ];

        return view('index.content',compact('data')); 
    }

    public function help()
    {

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            ];

        return view('index.faq',compact('data')); 
    }

    public function eight_step()
    {

        $data=[
            'username'=> Auth::user()->name,
            'rol'=> Auth::user()->rol_id,
            ];

        return view('index.8step',compact('data')); 
    }

    public function peru_auth()
    {
        $data=[
            'country_id'=> 1,
            'error' => false,
            ];
        return view('auth.login',compact('data'));
    }

    public function chile_auth()
    {
        $data=[
            'country_id'=> 2,
            'error' => false,
            ];
        return view('auth.login',compact('data'));
    }

    public function ecuador_auth()
    {
        $data=[
            'country_id'=> 3,
            'error' => false,
            ];
        return view('auth.login',compact('data'));
    }

    public function bolivia_auth()
    {
        $data=[
            'country_id'=> 4,
            'error' => false,
            ];
        return view('auth.login',compact('data'));
    }

    public function colombia_auth()
    {
        $data=[
            'country_id'=> 5,
            'error' => false,
            ];
        return view('auth.login',compact('data'));
    }

    public function mexico_auth()
    {
        $data=[
            'country_id'=> 6,
            'error' => false,
            ];
        return view('auth.login',compact('data'));
    }

    public function venezuela_auth()
    {
        $data=[
            'country_id'=> 7,
            'error' => false,
            ];
        return view('auth.login',compact('data'));
    }

    public function select_country(){
        return view('auth.select_country');   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logout()
    {
        switch (Auth::user()->country_id) {
            case 1:
                $route="/peru";
                break;
            
            case 2:
                $route="/chile";
                break;

            case 3:
                $route="/ecuador";
                break;

            case 4:
                $route="/bolivia";
                break;

            case 5:
                $route="/colombia";
                break;

            case 6:
                $route="/mexico";
                break;

            case 7:
                $route="/venezuela";
                break;

            default:
                # code...
                break;
        }

        Auth::logout();

        return redirect()->guest($route);

    }
}
