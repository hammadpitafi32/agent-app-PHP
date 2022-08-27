<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    protected $appointmentRepo;

    public function __construct(AppointmentRepository $repo)
    {
        $this->appointmentRepo = $repo;
    }
    // Create Appointment
    public function create(Request $request)
    {
        $response = $this->validation($request);
        
        if ($response && $response->getStatusCode() == 400) {
            return $response;
        }
 
        $response = $this->appointmentRepo->create((array)$request->all());

        return $response;
    }
    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function validation($request)
    {

        $validator = Validator::make($request->all(), [
            'appointment_address' => 'required',
            'date' => 'required|date',
            'client_first_name' => 'required',
            'client_last_name' => 'required',
            'client_email' => 'required|email',
            'client_address' => 'required',
            'client_phone' => 'required',

        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(),
                'success' => false
            ], 400);
        }

        /*validation end*/
        
    }

}
