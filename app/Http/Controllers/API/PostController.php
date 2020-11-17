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
     public function update(Request $request)
     {
         $post = Post::find($request->id);
         // now check if the user is editing their own post
         if(Auth::user()->id != $post->user_id)
         {
             return response()->json(
                 [
                     'success'=>false,
                     'message'=>'Unautorized access'
                 ]
             );
         }
         $post->desc =$request->desc;
         $post->update();
         return response(
             [
                 'success'=>true,
                 'message'=>'Post updated'
             ]
         );

     }
     public function delete(Request $request)
     {
        $post = Post::find($request->id);
        // check if user is editing his own post
        if(Auth::user()->id !=$post->user_id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        
        //check if post has photo to delete
        if($post->photo != ''){
            Storage::delete('public/posts/'.$post->photo);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'post deleted'
        ]);

     }
     public function posts()
     {
        $posts = Post::orderBy('id','desc')->get();
        foreach($posts as $post){
            //get user of post
            $post->user;
            //comments count
            $post['commentsCount'] = count($post->comments);
            //likes count
            $post['likesCount'] = count($post->likes);
            //check if users liked his own post
            $post['selfLike'] = false;
            foreach($post->likes as $like){
                if($like->user_id == Auth::user()->id){
                    $post['selfLike'] = true;
                }
            }

        }

        return response()->json([
            'success' => true,
            'posts' => $posts
        ]);

     }
     public function myPosts(){
        $posts = Post::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'posts' => $posts,
            'user' => $user
        ]);
    }
}
