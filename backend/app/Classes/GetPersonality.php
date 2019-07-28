<?php

namespace App\Classes;

use App\Questions;

class GetPersonality {
    
    private $ei,$sn ,$tf,$jp,$responses;

    public function __construct($responses)
    {
       $this->responses = $responses;

       $this->ei = 0;
       $this->sn = 0;
       $this->tf = 0;
       $this->jp = 0;

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
        $processed = $this->merge_question_response($questions,$this->responses);

        foreach( $processed as $key => $value){
            
            switch($value->dimension){
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
        if($response->direction < 0){
            if($response->value > 4){
                $this->ei -= 1;
            }else{
                $this->ei +=1;
            }
        }else{
            if($response->value > 4){
                $this->ei += 1;
            }else{
                $this->ei -=1;
            }
        }
    }


    private function handle_sn($response){
        if($response->direction < 0){
            if($response->value > 4){
                $this->sn -= 1;
            }else{
                $this->sn +=1;
            }
        }else{
            if($response->value > 4){
                $this->sn += 1;
            }else{
                $this->sn -=1;
            }
        }
    }

    private function handle_tf($response){
        if($response->direction < 0){
            if($response->value > 4){
                $this->tf -= 1;
            }else{
                $this->tf +=1;
            }
        }else{
            if($response->value > 4){
                $this->tf += 1;
            }else{
                $this->tf -=1;
            }
        }
    }

    private function handle_jp($response){
        if($response->direction < 0){
            if($response->value > 4){
                $this->jp -= 1;
            }else{
                $this->jp +=1;
            }
        }else{
            if($response->value > 4){
                $this->jp += 1;
            }else{
                $this->jp -=1;
            }
        }
    }

    public function personality()
    {
        $ret = "";

        if($this->ei > 0 ){
            $ret .= "I";
        }else{
            $ret .= "E";
        }

        if($this->ei > 0 ){
            $ret .= "N";
        }else{
            $ret .= "S";
        }

        if($this->ei > 0 ){
            $ret .= "F";
        }else{
            $ret .= "T";
        }

        if($this->ei > 0 ){
            $ret .= "P";
        }else{
            $ret .= "J";
        }
        return $ret;
    }

    
    
}