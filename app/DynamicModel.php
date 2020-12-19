<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class DynamicModel extends Model
{
    public function addDynamicFiles($data) {
    	//inserting dynamic_files table 
    	return DB::table('dynamic_files')->insertGetId($data);
    }
}
