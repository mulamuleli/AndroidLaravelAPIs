<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Auth;



class PostController extends Controller
{
    public function create(Request $request)
    {
        $post= new Post;
       
        $post->user_id= Auth::user()->id;
        $post->desc = $request->desc;


        // checking if the Post has got a photo in it
        if($request->photo !=''){
            //choose a unique name of the photo
            $photo= time().'jpg';
            FILE_PUT_CONTNENT('storage/posts/'.$photo,base64_decode($request->photo));
            $post->photo= $photo;
            
        }
        $post->save();
        $post->user;

        return response()->json(
            [
                'success'=>true,
                'message'=>'Post success',
                'Post'=> $post
            ]
        );

    }
}
