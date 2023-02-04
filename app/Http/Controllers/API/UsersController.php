<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\ImageService;
class UsersController extends Controller
{

    public function show($id)
    {
        try{

            $user =User::findorFail($id);
            return response()->json(['user' => $user],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'message' => 'Something went wrong in UserController.show',
                'error' => $e->getMessage()
            ],400);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        //  dd($request);
        // return response()->json(['user detail updated',$request],200);
        //  die();

        try{

            $user =User::findorFail($id);

            if ($request->hasFile('image')) {
                (new ImageService)->updateImage($user, $request, '/images/users/', 'update');
            }
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->location = $request->location;
            $user->description = $request->description;

            $user->save();

            return response()->json(['user detail updated'],200);

        }catch(\Exception $e)
        {
            return response()->json([
                'message' => 'Something went wrong in UserController.update',
                'error' => $e->getMessage()
            ],400);
        }
    }
}
