<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Appointment;
use Hash;

/**
 * Class AppointmentsRepository.
 */
class AppointmentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Appointment::class;
    }

    public function create($request)
    {
    	$request['location_distence']='56km';
        $request['user_id'] = auth()->user()->id;

        $appointment = $this->model::create($request);
        
        if(!$appointment){
        	
	        return response()->json([
	            'success' => false,
	            'errors' => 'Some thing went wrong,please try again!'
	        ]	, 400);
        }

        return response()->json([
            'success' => true,
            'data' => $appointment
        ], 200);
    }


}
