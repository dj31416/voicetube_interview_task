<?php

namespace App\Http\Middleware;

use Closure;
use App\HelpClass\TokenClass;

class ApiToken
{
    //parse 合法的token之後 可以拿到user_id
    public $user_id;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $res = $this->_get_token_info($request->route('token'));

        if( ! $this->_valid( $res ) ){
            return response()->json( [
                                'success' => 0,
                                'message' => 'token is invalid or expired',
                            ], 200 );

       }
        $request->attributes->add([ 'user_id'=>$res[2] ]);        

        return $next($request);
    }

    private function _valid($res){

        return $res[0];
    

    }

    private function _get_token_info($token){


        return  TokenClass::get_token_info(env('AES_KEY'),$token);
    

    }


}
