<?php

namespace tiens\Http\Controllers;

use Illuminate\Http\Request;

use tiens\Http\Requests;
use tiens\Http\Controllers\Controller;
use tiens\User;
use Auth;
use Input;
use Hash;
use Redirect;

class authController extends Controller
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

    public function login(Request $request)
    {
        //Verificacion de que se esta autenticando en Prestashop
        $ps_connecter = new PrestashopConnecter;//prestashop connecter

        $rs = $ps_connecter->auth_ps($request->email,$request->password,1);

        

        if(!$rs['exist?'])
        {
            $rs = $ps_connecter->auth_ps($request->email,$request->password,2);            
            if (!$rs['exist?']) {
                $data['msg']="El usuario no se ha encontrado";
                $data['country_id'] = $request->country_id;
                $data['error'] = true;
                return view('auth.login',compact('data'));
            }
        }else{

        }


        //Verificaci'on de existencia en la plataforma
        echo "verificando...<br>";
        $user = User::where('email',$request->email)->get()->first();
        if(count($user)>0)//Caso en que exista el usuario
        {
            $user->country_id = $request->country_id;
            $user->name = $rs['lastname'].", ".$rs['firstname'];
            $user->save();
        }else//Caso en que no exista, se procede a su registro en la plataforma
        {
            echo "registrando...<br>";
            $credentials = Input::only('email', 'password','name','rol_id','country_id');
            $credentials['password'] = Hash::make($request->password);
            $credentials['email'] = $request->email;
            $credentials['name'] = $rs['lastname'].", ".$rs['firstname'];
            $credentials['rol_id'] = 3;
            $credentials['country_id'] = $request->country_id;
            $user = User::create($credentials);            
        }


        Auth::login($user);
        //redireccionamiento a la p'agina
        return Redirect::to('/');
    }
}
