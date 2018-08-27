<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HelpClass\TokenClass;
use Illuminate\Support\Facades\Crypt;

class TokenController extends Controller
{
    //


    /**
    * get a new token and a renew_token
    */
    

    public function index(){
        return response()->json( [
                            'success' => 1,
                            'message' => $this->_createToken(),
                        ], 200 );


    }

    public function renew($old_token,$renew_token){

        $old_token_raw = TokenClass::token_decrypt(env('AES_KEY'),$old_token);
        if(!$old_token_raw){ //無法decrypt
            return response()->json( [
                                'success' => 0,
                                'message' =>'invalid token[999]',
                            ], 200 );


        }
        $old_token = explode(',',$old_token_raw);
        if(trim($old_token[1])!==trim($renew_token)){ //token 和 renew_token對不上
            return response()->json( [
                                'success' => 0,
                                'message' =>'invalid token[998]',
                            ], 200 );

        }

        //檢查通過 發新的token
        return response()->json( [
                            'success' => 1,
                            'message' => $this->_createToken(),
                        ], 200 );



    }
    public function status($token){
        /*
        $token_raw = TokenClass::token_decrypt(env('AES_KEY'),$token);
        if(!$token_raw){ //無法decrypt
            return response()->json( [
                                'success' => 0,
                                'message' =>'invalid token[999]',
                            ], 200 );


        }
        $token = explode(',',$token_raw);
        $ttl = $token[3];
        $refer =$token[2];
        if( ($ttl+$refer) > time()  ){ //還沒到期
            $is_valid = true;
        }else{
            $is_valid = false;
        }
        */
        $res = TokenClass::get_token_info(env("AES_KEY"),$token);
        return response()->json( [
                            'success' => 1,
                            'message' => [
                                            'valid'=>$res[0],
                                            'valid_date'=>$res[1]==0?'':date("Y-m-d H:i:s",$res[1]),
                                        ],
                        ], 200 );




    }

    private function _createToken(){

        //---模擬user登入後　拿到的user_id
        $user_id = 521;
        //現在的時間
        $now_time=time();
        //token TTL
        $ttl = env('TOKEN_TTL');
        $renew_token_raw = "${user_id},$now_time";
        $renew_token = TokenClass::token_encrypt(env('AES_KEY'),$renew_token_raw);
        $token_raw = "${user_id},${renew_token},${now_time},$ttl";
        $token = TokenClass::token_encrypt(env('AES_KEY'),$token_raw);

        return [
                    'token'=>$token,
                    'renew_token'=>$renew_token
                ];

    }

}
