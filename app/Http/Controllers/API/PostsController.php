<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Services\ImageService;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $postPerPage=5;
            $post = Posts::with('user')->orderBy('updated_at','desc')->simplePaginate($postPerPage);
            $pageCount = count(Posts::all())/$postPerPage;

            return response()->json([
                'paginate' => $post,
                'page_count' => ceil($pageCount)
            ],200);

           }
           catch(\Exception $ex){

               return response()->json([
                   'message' => 'Something Went Wrong PostsController.show',
                   'error' => $ex->getMessage()
               ],400);
           }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Posts\StorePostRequest
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        try{
            // dd($request);
            // die();
            if($request->hasFile('image')===false){
                return response()->json(['error'=>'There is no image to upload.'],400);

            }

            $post = new Posts();
            $post->title= $request->get('title');
            $post->location= $request->get('location');
            $post->description= $request->get('description');

            (new ImageService)->updateImage($post, $request, '/images/posts/', 'store');
            // dd($post);
            // die();
            $post->save();

            return response()->json('New Post Created',200);

            }
            catch(\Exception $ex){

                return response()->json([
                    'message' => 'Something Went Wrong PostsController.store',
                    'error' => $ex->getMessage()
                ],400);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try{

             $post = Posts::with('user')->findOrFail($id);


            return response()->json($post,200);

            }
            catch(\Exception $ex){

                return response()->json([
                    'message' => 'Something Went Wrong PostsController.show',
                    'error' => $ex->getMessage()
                ],400);
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Posts\UpdatePostRequest;
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, int $id)
    {
        try{
            $post =  Posts::findOrFail($id);

            if($request->hasFile('image')){
                (new ImageService)->updateImage($post, $request, '/images/posts/', 'update');
            }

            $post->title= $request->get('title');
            $post->location= $request->get('location');
            $post->description= $request->get('description');

            $post->save();

            return response()->json('Post Updated',200);

            }
            catch(\Exception $ex){

                return response()->json([
                    'message' => 'Something Went Wrong PostsController.update',
                    'error' => $ex->getMessage()
                ],400);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try{
            $post =  Posts::findOrFail($id);

            if(!empty($post ->image))
            {
               $currentImage=public_path().'/images/posts/'.$post->image;
               if(file_exists($currentImage)){
                unlink($currentImage);
               }

            }
            $post->delete();

            return response()->json('Post Deleted',200);

            }
            catch(\Exception $ex){

                return response()->json([
                    'message' => 'Something Went Wrong PostsController.destroy',
                    'error' => $ex->getMessage()
                ],400);
            }
    }
}
