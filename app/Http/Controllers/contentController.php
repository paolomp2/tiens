<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;

use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;

use tiens\Content;
use tiens\User;
use Session;
use Redirect;
use File;

class contentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        if(Auth::user()->rol_id!=1)
            return Redirect::to('/index');

        $content = Content::find($id);

        return view('content.update',compact('content'));
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
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect("content/".$id."/edit")
                        ->withErrors($validator)
                        ->withInput();
        }

        $content = Content::find($id);
        $content->description = $request->content;
        $content->save();
        
        Session::flash('msg_edit_ok','León editado correctamente');
        return Redirect::to('/institucion');
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
}
