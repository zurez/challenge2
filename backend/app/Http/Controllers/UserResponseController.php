<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserResponse;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use App\Classes\GetPersonality;

class UserResponseController extends Controller
{
    //

    public function store(Request $r)
    {
        $ret = ['status' => 'success'];
        //return Input::all();
        try{
            // Create User Record 
            $user = User::firstOrCreate(['email' => $r->input('email')]);
            $user_id = $user->id;
            $responses = $r->input('responses');
            if(json_last_error() === 0){
                foreach($responses as $response){
                   $ur = new UserResponse;
                   $ur->question_id = $response['question_id'];
                   $ur->user_id = $user_id;
                   $ur->response = $response['value'];
                   $ur->save();
                    
                }
                
                $gp = new GetPersonality($r->input('responses'));

                $personalityType = $gp->personality();

                $ret['personalityType'] = $personalityType;
              
            }
          

        }
        catch(\Exception $e){
           
            $ret['status'] = 'error';
            $ret['message'] = $e->getMessage();
            $ret['line'] = $e->getLine();
        }
       
        return response()->json($ret);
    }

    public function index()
    {

        if(Input::has('email')){
            return $this->get_user_answers_by_email(Input::get('email'));
        }
        
        return false;
    }
    private function get_user_answers_by_email($email){

        return UserResponse::join("users","users.id","=","userresponse.user_id")
        ->join("questions","questions.id","=","userresponse.question_id")
        ->select([
            "questions.title",
            "questions.dimension",
            "questions.direction",
            "questions.meaning",
            "userresponse.id",
            "userresponse.response"

        ])
        ->where("users.email",$email)
        ->get();
    }
    

}
