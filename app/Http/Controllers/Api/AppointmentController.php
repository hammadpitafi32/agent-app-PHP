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
        $input=$request->all();
        $date=date_create($input['date']);
        $input['date']=date_format($date,"Y/m/d");
        
        $response = $this->appointmentRepo->create($input);

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
    // get Appointments
    public function getAppointments(Request $request)
    {

        $response = $this->appointmentRepo->getAppointments($request);

        return $response;
    }
    // Delete appointment
    public function deleteAppointment($id)
    {
        
        $response = $this->appointmentRepo->deleteAppointment($id);

        return $response;
    }
    // Edit
    public function updateAppointment(Request $request, $id) {
 
        if (count($request->all())) {
            
            $input=$request->all();
            $response = $this->appointmentRepo->editAppointment($input,$id);

            return $response;
        }

        return response()->json([
                'error' => 'Please change some value',
                'success' => false
        ], 400);
        

    }  

}
