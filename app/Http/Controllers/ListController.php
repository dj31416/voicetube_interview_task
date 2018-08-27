<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
//for http request
use Illuminate\Http\Request;

//model
use App\LaTodo;


class ListController extends BaseController{


    /**
    * 初始化 檢查token
    */

    public function __construct(){


        //var_dump($_GET);exit;
        $this->middleware('api.token',['only'=>['create','update','delete']]);

    }


    public function index(){

        
        $todo = LaTodo::all();

        var_dump(json_encode($todo)); 
        exit;
        foreach($todo as $key => $row){

            var_dump(json_encode($row));exit;
        }

        return 'index';

    }

    /*
    * 建立一條 list
    */
    public function create($token, Request $request){


        $todo = new LaTodo;
        $todo->user_id = $request->get('user_id');
        $todo->title = $request->title;
        $todo->content = $request->content;
        
        try{

            $todo->save();
            return response()->json( [
                                'success' => 1,
                                'message' =>'ok',
                            ], 200 );
        }
        catch(\Exception $e){
            return response()->json( [
                                'success' => 0,
                                'message' =>$e->getMessage(),
                            ], 200 );
        }
        


    }

    /*
    * 取得 list
    */
    public function show($id=NULL){

        if($id){

            $todo = LaTodo::find($id);
        }else{

            $todo = LaTodo::all();
        }

            return response()->json( [
                                'success' => 1,
                                'message' =>$todo,
                            ], 200 );

    }

    /*
    * update list
    */
    public function update($id , Request $request){

        /*  refer : https://laravel.io/forum/02-13-2014-i-can-not-get-inputs-from-a-putpatch-request
            Laravel cheats because html forms only support GET and POST, but it does understand a real PUT/PATCH request.
            The problem looks like lies in Symfony it can't parse the data if it's multipart/form-data, as an alternative try using x-www-form-urlencoded content disposition.
        */
        $todo = LaTodo::find($id);
        if(!$todo){
            return response()->json( [
                                'success' => 0,
                                'message' =>'this data could not be found in database',
                            ], 200 );


        }

        foreach($request->request as $key => $row){

            $todo->$key = $row;            

        }

        try{

            $todo->save();
            return response()->json( [
                                'success' => 1,
                                'message' =>'ok',
                            ], 200 );
        }
        catch(\Exception $e){
            return response()->json( [
                                'success' => 0,
                                'message' =>$e->getMessage(),
                            ], 200 );
        }
        

    }

    /*
    * delete specific list
    */
    public function delete($id){

        



        $todo = LaTodo::find($id);
        if(!$todo){
            return response()->json( [
                                'success' => 0,
                                'message' =>'this data could not be found in database',
                            ], 200 );

        }
        try{

            $todo->delete();
            return response()->json( [
                                'success' => 1,
                                'message' =>'ok',
                            ], 200 );
        }
        catch(\Exception $e){
            return response()->json( [
                                'success' => 0,
                                'message' =>$e->getMessage(),
                            ], 200 );
        }
        
        


    }
    /*
    * delete all list
    */
    public function deleteAll($id){


        $todo = LaTodo::all();

        foreach($todo as $key => $row){

            $model = LaTodo::find($row->id);
            $model->delete();
        }

        return response()->json( [
                            'success' => 1,
                            'message' =>'ok',
                        ], 200 );
        
        


    }
}

