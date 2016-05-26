<?php

namespace tiens\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use tiens\User;
use tiens\Profile;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(count(explode('/',$this->auth->getSession()->previousUrl()))>3)
            $country = explode('/',$this->auth->getSession()->previousUrl())[3];
        else{
            if($this->auth->guest())
                return redirect()->guest('/seleccione_pais');
            else                
                return $next($request);
        }

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {

                switch ($country) {
                    case 'peru':
                        return redirect()->guest('/peru');
                        break;
                    
                    case 'chile':
                        return redirect()->guest('/chile');
                        break;

                    case 'ecuador':
                        return redirect()->guest('/ecuador');
                        break;

                    case 'bolivia':
                        return redirect()->guest('/bolivia');
                        break;

                    case 'colombia':
                        return redirect()->guest('/colombia');
                        break;

                    case 'mexico':
                        return redirect()->guest('/mexico');
                        break;

                    case 'venezuela':
                        return redirect()->guest('/venezuela');
                        break;

                    default:
                        return redirect()->guest('/seleccione_pais');
                        break;
                }                
            }
        }
        //Carga a la sesi'on activa los datos del usuario
        //
        $country = explode('/',$this->auth->getSession()->previousUrl())[3];
        $user = $this->auth->user();

        switch ($country) {
            case 'peru':
                $user->country_id = 1;
                $user->save();
                break;
            
            case 'chile':
                $user->country_id = 2;
                $user->save();
                break;

            case 'ecuador':
                $user->country_id = 3;
                $user->save();
                break;

            case 'bolivia':
                $user->country_id = 4;
                $user->save();
                break;

            case 'colombia':
                $user->country_id = 5;
                $user->save();
                break;

            case 'mexico':
                $user->country_id = 6;
                $user->save();
                break;

            case 'venezuela':
                $user->country_id = 7;
                $user->save();
                break;

            default:
                # code...
                break;
        }

        return $next($request);
    }
}
