<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Questions;
class QuestionsController extends Controller
{
    
    function index(){
        
        $response = ["status"=>"success"];

        try{
            $questions = Questions::select([
                'id',
                'title',
            ])->get(); // 10 only.
            $response["questions"] = $questions;
        }
        catch(\Exception $e){
            $response["status"] = "error";
            $response["message"] = $e->getMessage();
        }
        
         
        return response()->json($response);
    }
}
