<?php

namespace App\Classes;

use App\Questions;
use Log;

class GetPersonality {
    
    public $responses;
    public  $e  = 0;
    public  $i  = 0;
    public  $s  = 0;
    public  $n  = 0;
    public  $t  = 0;
    public  $f  = 0;
    public  $j  = 0;
    public  $p  = 0;

    public function __construct($responses)
    {
       $this->responses = $responses;

       $this->e = 0;
       $this->i = 0;
       $this->s = 0;
       $this->n = 0;
       $this->t = 0;
       $this->f = 0;
       $this->j = 0;
       $this->p = 0;

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
        
        if( $response['value'] >4){
            if($response['direction'] < 0){
                $this->e++;
            }else{
                $this->i++;
            }
        }
        else if ($response['value'] < 4 ){
            if($response['direction'] <0){
                $this->i++;
            }else{
                $this->e++;
            }
        }
    }

    private function handle_sn($response){
        
        if( $response['value'] >4){
            if($response['direction'] < 0){
                $this->s++;
            }else{
                $this->n++;
            }
        }
        else if ($response['value'] < 4 ){
            if($response['direction'] <0){
                $this->n++;
            }else{
                $this->s++;
            }
        }
    }

    private function handle_tf($response){
        
        if( $response['value'] >4){
            if($response['direction'] < 0){
                $this->t++;
            }else{
                $this->f++;
            }
        }
        else if ($response['value'] < 4 ){
            if($response['direction'] <0){
                $this->f++;
            }else{
                $this->t++;
            }
        }
    }

    private function handle_jp($response){
        
        if( $response['value'] >4){
            if($response['direction'] < 0){
                $this->j++;
            }else{
                $this->p++;
            }
        }
        else if ($response['value'] < 4 ){
            if($response['direction'] <0){
                $this->p++;
            }else{
                $this->j++;
            }
        }
    }

    public function personality()
    {
        $ret = "";

        $this->calculate();
        if( $this->e < $this->i){
            $ret .= "I";
        }else{
            $ret .= "E";
        }

        if( $this->s < $this->n){
            $ret .= "N";
        }else{
            $ret .= "S";
        }

        if( $this->t < $this->f){
            $ret .= "F";
        }else{
            $ret .= "T";
        }

        if( $this->j < $this->p){
            $ret .= "P";
        }else{
            $ret .= "J";
        }


        return $ret;
        return [$this->e,$this->i, $this->s, $this->n];
    }

    
    
}