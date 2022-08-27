<?php
 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAuthRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepository $repo)
    {
        $this->userRepo = $repo;
    }
 
    public function register(Request $request)
    {
        $response = $this->validation($request);
       
        if ($response && $response->getStatusCode() == 400) {
            return $response;
        }
        $response = $this->userRepo->createOrUpdateUser($request);

        return $response;
    }
 
    public function login(Request $request)
    {

        $input = $request->only('email', 'password');
       
        if (Auth::guard()->attempt($input)) {
            
            $user=auth()->user();
            
            $token = $request->user()->createToken($user->name)->plainTextToken;

            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $data['phone'] = $user->phone;
            $data['address'] = $user->address;

            return response()->json([
                'success' => true,
                'token' => $token,
                'data' => $data,
            ]);

            } else {
                return response()->json(['error' => 'Wrong Credentials','success' => false], 401);
        }

 
    }
 
    // public function logout(Request $request)
    // {

    //     $token['token'] = $request->bearerToken();
    //     //valid credential
    //     $validator = Validator::make($token, [
    //         'token' => 'required'
    //     ]);

    //     //Send failed response if request is not valid
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'errors' => $validator->messages()
    //         ], 400);
    //     }
 
    //     try {
    //         JWTAuth::invalidate($request->token);
 
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User logged out successfully'
    //         ]);
    //     } catch (JWTException $exception) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Sorry, the user cannot be logged out'
    //         ], 500);
    //     }
    // }
 
    // public function getAuthUser(Request $request)
    // {
    //     $this->validate($request, [
    //         'token' => 'required'
    //     ]);
 
    //     $user = JWTAuth::authenticate($request->token);
 
    //     return response()->json(['user' => $user]);
    // }
     /**
     * @param Request $request
     * @return $this|false|string
     */
    public function validation($request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50|confirmed',
            'phone' => 'required|unique:users|max:13',
            'address' => 'required'
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