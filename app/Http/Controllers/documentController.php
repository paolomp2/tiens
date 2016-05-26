<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;

use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;

use Flash;
use Auth;
use Validator;
use Hash;
use Image;
use tiens\Document;

class documentController extends Controller
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

        if ($request->ajax()) {


            $document = new Document;
            $document->sessionMath = $request->sessionMath;
            $document->original_name = $request->file_name;
            $document->extension = $request->file('document')->getClientOriginalExtension();
            $document->size = $request->size;
            $document->model_type = $request->model;
            $document->save();

            $request->file('document')->move(
                base_path() . '/public/documentos/',$document->id.'.'.$request->file('document')->getClientOriginalExtension()
            );

            if($document->model_type==1){//Caso en que sea una imagen
                $name = base_path() . '/public/documentos/'.$document->id.'.'.$document->extension;
                //Imagen de resolución optimizada para el viewer
                $name_rs   = base_path() . '/public/documentos/940x650_'.$document->id.'.'.$document->extension;
                //Imagen de resolución optimizada para miniatura
                $name_rs_s = base_path() . '/public/documentos/150x150_'.$document->id.'.'.$document->extension;
                
                if (file_exists($name)) {
                    $dimension=getimagesize($name);
                    if($dimension[0]>$dimension[1])//100x75
                    {
                        $width_s = 150;
                        $height_s = 150;

                        $width = 940;
                        $height = 650;
                    }else{

                        $width_s = 150;
                        $height_s = 150;

                        $width = (650*($dimension[0]))/$dimension[1];
                        $height = 650;
                    }

                    Image::make($name)->resize($width, $height)->save($name_rs);
                    Image::make($name)->resize($width_s, $height_s)->save($name_rs_s);
                    
                }else{
                    
                    $document->delete();
                }
            }

            return response()->json([
                "id" => $document->id,
                "extension" => $document->extension,
                "index" => $request->index,
                "size" => $document->size,
                ]);
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

    public function delete($id)
    {
        $document = Document::find($id)->delete();
    }
}
