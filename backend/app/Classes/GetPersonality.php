<?php

namespace App\Classes;

use App\Questions;
use Log;

class GetPersonality {
    
    public $responses;
    public  $ei  = 0;
    public  $sn  = 0;
    public  $tf  = 0;
    public  $jp  = 0;

    public function __construct($responses)
    {
       $this->responses = $responses;

    }
    

    private function get_questions(){
        return Questions::select([
            'id',
            'title',
            'dimension',
            'direction',
            'meaning'
        ])->get();
    }
    
    private function merge_question_response($questions,$responses){
        $ret = array();
      
        foreach($questions as $question){
            $temp = [
                "dimension" => $question->dimension,
                "direction" => $question->direction,
                "meaning" => $question->meaning
            ];
            $ret[$question->id] = $temp;
        }
        foreach($responses as $response ){
            $ret[$response['question_id']]['value'] = $response['value'];
        }
        return $ret;
    }
    private function calculate(){
        $questions = $this->get_questions();
        $processed = (Object)$this->merge_question_response($questions,$this->responses);

        foreach( $processed as $key => $value){
          
            switch($value['dimension']){
                case 'EI':
                    $this->handle_ei($value);
                    break;
                case 'SN':
                    $this->handle_sn($value);
                    break;
                case 'TF':
                    $this->handle_tf($value);
                    break;
                case 'JP':
                    $this->handle_jp($value);
                    break;
                default:
                    break;
                
            }
        }
    }
    private function handle_ei($response){
        
        if($response['direction'] === 1){
            $this->ei += $response['value'];
        }else{
            $this->ei += (8-$response['value']);
        }
    }

    private function handle_sn($response){
        
        if($response['direction'] === 1){
            $this->sn += $response['value'];
        }else{
            $this->sn += (8-$response['value']);
        }
    }

    private function handle_tf($response){
        
        if($response['direction'] === 1){
            $this->tf += $response['value'];
        }else{
            $this->tf += (8-$response['value']);
        }
    }

    private function handle_jp($response){
        
        if($response['direction'] === 1){
            $this->jp += $response['value'];
        }else{
            $this->jp += (8-$response['value']);
        }
    }

    public function personality()
    {
        $ret = "";

        $this->calculate();
        
        if( $this->ei <= 4){
            $ret .= "E";
        }else{
            $ret .= "I";
        }
        if( $this->sn <= 4){
            $ret .= "S";
        }else{
            $ret .= "N";
        }
        if( $this->tf <= 4){
            $ret .= "T";
        }else{
            $ret .= "F";
        }
        if( $this->jp <= 4){
            $ret .= "J";
        }else{
            $ret .= "P";
        }

        return $ret;
        
    }

    
    
}