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

    public function getAppointments($request)
    {
    	if($request->has('date')){
    		$appointments = $this->model::where('user_id',auth()->user()->id)->where('date',$request->date)->get();
    	}else{
    		$appointments = $this->model::where('user_id',auth()->user()->id)->get();
    	}
    	
        
        return response()->json([
            'success' => true,
            'data' => $appointments
        ], 200);
    }

    public function deleteAppointment($id){

    	$appointment = $this->model::find($id);
        
        if ($appointment) 
        {
            $appointment->delete();
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found!'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully!'
        ], 200);
    }

    public function editAppointment($request,$id){

    	$appointment = $this->model::where('id',$id)->update($request);
        
        if ($appointment) 
        {
	        return response()->json([
	            'success' => true,
	            'message' => 'Appointment edit successfully!'
	        ], 200);
        }
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found!'
            ], 400);
    }
    


}
