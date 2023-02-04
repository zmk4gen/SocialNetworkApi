<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Youtube;
use App\Http\Requests\YouTube\StoreYoutubeRequest;

class YoutubeController extends Controller
{
    public function store(StoreYoutubeRequest $request)
    {
        try{
            $yt=new Youtube;
            $yt->user_id= $request->get('user_id');
            $yt->title= $request->get('title');
            $yt->url= env("YT_EMBED_URL").$request->get('url')."?autoplay=0";

            $yt->save();

            return response()->json('New Youtube link saved',200);

        }catch(\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage(),
                'message' => 'Something Went Wrong YourtubeController.store'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @return \Illuminate\Http\Response
     */
    public function show(int $user_id)
    {
        try{
            $videoByUser= Youtube::where('user_id',$user_id)->get();

            return response()->json(['video_by_user'=>$videoByUser],200);

        }catch(\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage(),
                'message' => 'Something Went Wrong YourtubeController.show'
            ]);
        }
    }


    public function destroy(int $id)
    {
        try{
            $song=Youtube::findOrFail($id);

            $song->delete();

            return response()->json('Video Deleted',200);

    }
    catch(\Exception $ex){

        return response()->json([
            'message' => 'Something Went Wrong YoutubeController.destroy',
            'error' => $ex->getMessage()
        ],400);
    }
    }
}
