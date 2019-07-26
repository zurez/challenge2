<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model
{
    protected $table = "userresponse";

    protected $fillable = ['question_id','session_id','user_id','response'];
}
