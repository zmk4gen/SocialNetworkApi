<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Song;
use App\Http\Requests\Song\StoreSongRequest;

class SongController extends Controller
{

    public function store(StoreSongRequest $request)
    {
        try{
            $file =$request->file;
            if(empty($file))
            {
                return response()->json('No song uploaded', 400);
            }
            $user= User::findOrFail($request->get('user_id'));

            $song=$file->getClientOriginalName();
            $file->move('songs/' . $user->id, $song);

            Song::create([
                'user_id'=>$request->get('user_id'),
                'title'=>$request->get('title'),
                'song'=>$song,
            ]);
            return response()->json('Song Uploaded', 200);
        }
        catch(\Exception $ex){
            return response()->json([
                'error' => $ex->getMessage(),
                'message' => 'Something Went Wrong SongController.store'
            ]);
        }



    }

    public function destroy(int $id, int $user_id)
    {

        try{
                $song=Song::findOrFail($id);
                // dd($song);
                // die();
                $currentSong = public_path(). "/songs/". $user_id ."/" .$song->song;
                if(file_exists($currentSong)){
                    unlink($currentSong);
                }

                $song->delete();

                return response()->json('Song Deleted',200);

        }
        catch(\Exception $ex){

            return response()->json([
                'message' => 'Something Went Wrong SongController.destroy',
                'error' => $ex->getMessage()
            ],400);
        }
    }
}
