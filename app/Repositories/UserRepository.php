<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\User;
use Hash;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function createOrUpdateUser($request)
    {

        $request['name'] = $request->first_name.' '.$request->last_name;

        $user = $request->id ?  $this->model::find($request->id) : $this->model;

        $user = $user->updateOrCreate(
            [
                'email' => $request->email,
            ],
            [
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'phone' =>$request->phone,
                'address' => $request->address,
            ]
        );
        
        if(!$user){
        	
	        return response()->json([
	            'success' => false,
	            'errors' => $user
	        ]	, 400);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }
}
