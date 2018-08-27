<?php 
/*
* Token structure : user_id,renew_token,create_time,ttl
* renew_token user_id,create_time
*/



namespace App\HelpClass;

use Exception;
use RuntimeException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;



class TokenClass extends BaseEncrypter  {



    public static function token_encrypt($key,$plaintext){

        $cipher = 'AES-128-CBC';

        $iv = random_bytes(openssl_cipher_iv_length($cipher));

        $plaintext = \openssl_encrypt(
            $plaintext,
            $cipher, $key, 0, $iv
        );

        if ($plaintext === false) {
            throw new EncryptException('Could not encrypt the data.');
        }

        //$mac = hash_hmac('sha256', $iv.$plaintext, $key);
        $iv = base64_encode($iv);



        $json = json_encode(compact('iv', 'plaintext'));


        return base64_encode($json);
    



    }

    public static function token_decrypt($key,$content_base64){

        $payload = json_decode(base64_decode($content_base64), true);

        $cipher = 'AES-128-CBC';

        $content = $payload['plaintext'];

        $iv = base64_decode($payload['iv']);



        $decrypted = \openssl_decrypt(
            $content, $cipher, $key, 0, $iv
        );

        //decrypt 失敗的話　decrypt=false 就直接噴json error給user

        return $decrypted;

    }


    public static function get_token_info($key,$token){

        
        $token_raw = self::token_decrypt(env('AES_KEY'),$token);
        if(!$token_raw){ //無法decrypt
        
            return [false,0];
        }
        $token = explode(',',$token_raw);
        $ttl = $token[3];
        $refer = $token[2];
        $user_id = $token[0];
        if( ($ttl+$refer) > time()  ){ //還沒到期
            return  [true,$ttl+$refer,$user_id];
        }else{
            return  [false,$ttl+$refer,$user_id];
        }


    }



} 

