<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    public function addJobApplication($userData)
    {
    	//inserting job_application table     	
    	return DB::table('job_application')->insertGetId($userData);
    }
}
