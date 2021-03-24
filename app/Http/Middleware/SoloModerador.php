<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloModerador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        switch(auth::user()->tipo){
            case ('1'):
                return redirect('dashboard');//si es administrador redirige al HOME
            break;
			case('2'):
                return redirect('user');/// si es un usuario normal redirige a la ruta USER
			break;	
            case ('3'):
                return $next($request);//si es moderador continua a su ruta moderador
            break;
        }
    }
}
