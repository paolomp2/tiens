<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Session\Console;
use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;

use tiens\Event_category;
use tiens\Notification;
use tiens\Event;
use tiens\User;
use tiens\Country;
use Session;
use Redirect;
use File;
use Carbon\Carbon;
use Image;

class eventController extends Controller
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

                $events = Event::withTrashed()->orderBy('created_at', 'desc')->get();               
                break;
            case 2:
                $events = Event::withTrashed()->where('country_id',Auth::user()->country_id)->orderBy('created_at', 'desc')->get();
                break;
            default:
                # code...
                break;
        }
        
        foreach ($events as $event) {
            //loading author
            $Created_by=$event->User;
            $event['Created_by']=$Created_by;
            //loading category
            $category=$event->Category;
            $event['Category']=$category;
        }

    //echo dd($events);

        return view('event.index',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Event_category::get();
        $i=0;
        foreach ($categories as $category) {
            $options_selected[$i++]=$category->name;
        }

        $rol= Auth::user()->rol_id;

        $i=0;
        foreach (Country::get() as $country) {
            $countries_options[$i++] = $country->name;
        }

        return view('event.create', compact('options_selected','countries_options','rol'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //echo dd($request);
        /*Validator section*/
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'imagen' => 'image|mimes:jpeg,jpg,bmp,png,gif|max:6000',
            'category' => 'required',
            'date' => 'required|date',
            'hour' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('event/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        /*Creating event*/
        $event = new Event;
        $event->name = $request->title;
        $event->description = $request->content;
            //Recuperando la ID de la categor'ia
            $categories = Event_category::get();
        $event->category_id = $categories[$request->category]->id;
        $event->site = $request->site;
        $event->date_celebration = $request->date;
        $event->hour_celebration = $request->hour;

        $aux_time = Carbon::createFromFormat('Y-m-d', $request->date); 
        $day_name = $aux_time->formatLocalized('%A');
        switch ($day_name) {
            case 'Monday':
                $day_name = "Lunes";
                break;
            case 'Tuesday':
                $day_name = "Martes";
                break;
            case 'Wednesday':
                $day_name = "Miércoles";
                break;
            case 'Thursday':
                $day_name = "Jueves";
                break;
            case 'Friday':
                $day_name = "Viernes";
                break;
            case 'Saturday':
                $day_name = "Sábado";
                break;
            case 'Sunday':
                $day_name = "Domingo";
                break;
            default:
                $day_name = "Error CD08";
                break;
        }
        $day_num = $aux_time->formatLocalized('%d');
        $month_name = $aux_time->formatLocalized('%B');

        switch ($month_name) {
            case 'January':
                $month_name = "Enero";
                break;
            case 'February':
                $month_name = "Febrero";
                break;
            case 'March':
                $month_name = "Marzo";
                break;
            case 'April':
                $month_name = "Abril";
                break;
            case 'May':
                $month_name = "Mayo";
                break;
            case 'January':
                $month_name = "Junio";
                break;
            case 'July':
                $month_name = "Julio";
                break;
            case 'August':
                $month_name = "Agosto";
                break;
            case 'September':
                $month_name = "Septiembre";
                break;
            case 'October':
                $month_name = "Octubre";
                break;
            case 'November':
                $month_name = "Noviembre";
                break;
            case 'December':
                $month_name = "Diciembre";
                break;
            default:
                # code...
                break;
        }

        $event->date_format = $day_name.", ".$day_num." de ".$month_name;

        $event->save();

        $user = User::find(Auth::user()->id);
        $user->Events()->save($event);

        /*Adding Countries*/
        if(Auth::user()->rol_id==1)
        {
            $country = Country::find($request->country+1);
        }else{
            $country = Country::find(Auth::user()->country_id);               
        }
        $country->Events()->save($event);

        if (!is_null($request->file('imagen'))) {

            /*Store new image*/
            $imageName = 'event_'.$event->id.'.'.$request->file('imagen')->getClientOriginalExtension();

            $request->file('imagen')->move(
                base_path() . '/public/images/event/', $imageName
            );

            $event->extension = $request->file('imagen')->getClientOriginalExtension();
            $event->save();
        }else{
            Image::make(base_path() . '/public/images/event/default.png')->save(base_path() . '/public/images/event/event_'.$event->id.'.png');

            $event->extension = 'png';
            $event->save();
        }

        //File::copy(base_path().'/public/images/event/'.$imageName , base_path().'/public/images/gallery/1/'.$imageGallery);
        
        $not = new Notification;
        $not->message = "Nuevo evento: ".$event->name;
        $not->model_type = "event";
        $not->model_id = $event->id;
        $not->country_id = $country->id;                    
        $not->save();
        
        return Redirect::to('/event');
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
        $event = Event::find($id);
        //Carga de todos los paises
        $categories = Event_category::get();
        $i=0;
        foreach ($categories as $category) {
            $options_category[$i]=$category->name;
            if($event->Category->id==$category->id)
                $option_selected=$i;
            $i++;
        }



        return view('event.update',compact('options_category', 'event','option_selected'));
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
        //echo dd($request);
        /*Validator section*/
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category' => 'required',
            'date' => 'required|date',
            'hour' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect("event/".$id."/edit")
                        ->withErrors($validator)
                        ->withInput();
        }

        $event = Event::find($id);
        $event->name = $request->title;
        $event->description = $request->content;
            //Recuperando la ID de la categor'ia
            $categories = Event_category::get();
        $event->category_id = $categories[$request->category]->id;
        $event->site = $request->site;
        $event->date_celebration = $request->date;
        $event->hour_celebration = $request->hour;
        $aux_time = Carbon::createFromFormat('Y-m-d', $request->date); 
        $day_name = $aux_time->formatLocalized('%A');
        switch ($day_name) {
            case 'Monday':
                $day_name = "Lunes";
                break;
            case 'Tuesday':
                $day_name = "Martes";
                break;
            case 'Wednesday':
                $day_name = "Miércoles";
                break;
            case 'Thursday':
                $day_name = "Jueves";
                break;
            case 'Friday':
                $day_name = "Viernes";
                break;
            case 'Saturday':
                $day_name = "Viernes";
                break;
            case 'Sunday':
                $day_name = "Viernes";
                break;
            default:
                $day_name = "Error CD08 ".$day_name;
                break;
        }
        $day_num = $aux_time->formatLocalized('%d');
        $month_name = $aux_time->formatLocalized('%B');

        switch ($month_name) {
            case 'January':
                $month_name = "Enero";
                break;
            case 'February':
                $month_name = "Febrero";
                break;
            case 'March':
                $month_name = "Marzo";
                break;
            case 'April':
                $month_name = "Abril";
                break;
            case 'May':
                $month_name = "Mayo";
                break;
            case 'January':
                $month_name = "Junio";
                break;
            case 'July':
                $month_name = "Julio";
                break;
            case 'August':
                $month_name = "Agosto";
                break;
            case 'September':
                $month_name = "Septiembre";
                break;
            case 'October':
                $month_name = "Octubre";
                break;
            case 'November':
                $month_name = "Noviembre";
                break;
            case 'December':
                $month_name = "Diciembre";
                break;
            default:
                # code...
                break;
        }

        $event->date_format = $day_name.", ".$day_num." de ".$month_name;
        $event->save();

        /*store Image*/

        if (!is_null($request->file('imagen'))) {
            /*Deleting old image*/
            $imageName_old = 'event_'.$event->id.'.'.$event->extension;            
            File::delete('/public/images/event/'.$imageName_old);
            /*Store new image*/
            $imageName = 'event_'.$event->id.'.'.$request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(
                base_path() . '/public/images/event/', $imageName
            );
            $event->extension = $request->file('imagen')->getClientOriginalExtension();
            $event->save();
        }

        $not = new Notification;
        $not->message = "Evento editado: ".$event->name;
        $not->model_type = "event";
        $not->model_id = $event->id;              
        $not->save();

        Session::flash('msg_edit_ok','Evento editado correctamente');
        return Redirect::to('/event');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Event::find($id)->delete();
        return Redirect::to('/event');
    }

    public function inactive($id)
    {
        $event = Event::find($id);

        $not = new Notification;
        $not->message = "Evento desactivado: ".$event->name;
        $not->model_type = "event";
        $not->model_id = $event->id;                  
        $not->save();

        $event->delete();

        return Redirect::to('/event');
    }
    
    public function untrashed($id)
    {

        Event::onlyTrashed()->find($id)->restore();
        $event = Event::find($id);
        $not = new Notification;
        $not->message = "Evento reactivado: ".$event->name;
        $not->model_type = "event";
        $not->model_id = $event->id;                   
        $not->save();
        return Redirect::to('/event');
    }
}
