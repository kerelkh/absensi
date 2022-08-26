<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$filters)
    {
        if(!in_array(Auth::user()->role->id, $filters)){
            if(Auth::user()->role->id == 1) {
                return redirect('/opd');
            }
            if(Auth::user()->role->id == 2){
                return redirect('/admin/kepegawaian');
            }

            if(Auth::user()->role->id == 3){
                return redirect('/admin/dinas');
            }

            if(Auth::user()->role->id == 6){
                return redirect('/')->with('success', 'Selamat Datang.');
            }
        }
        return $next($request);
    }
}
