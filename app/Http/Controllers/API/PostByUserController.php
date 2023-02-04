<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;

class PostByUserController extends Controller
{
    public function index(int $user_id){
        try{

            $posts = Posts::where('user_id', $user_id)->get();


           return response()->json($posts,200);

           }
           catch(\Exception $ex){

               return response()->json([
                   'message' => 'Something Went Wrong PostByUserController.index',
                   'error' => $ex->getMessage()
               ],400);
           }
    }
}
