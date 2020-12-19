<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\GenericFunctions;
use Carbon\Carbon;
use App\DynamicModel;
use Response;
class DynamicController extends Controller
{
   public function index()
   {
   		return view('dynamic');
   }

   public function uploadDynamicFiles(Request $request)
   {	
   		$files = $request->all();
   		if (!empty($files)) {
	   		$upload = new DynamicModel();
   			foreach ($files as $key => $file) {
   				$data = [];
   				/*
		          converting original name into (Current time+extention)
		          and also removing special characters if any using  removeSelctedSpecialChar  method of GenericFunctions static class
		        */
	   			$fileName = GenericFunctions::removeSelctedSpecialChar(Carbon::now()).'.'.$file->getClientOriginalExtension();
	   			/*
		            File upload using fileUpload of GenericFunction class
		            if uploaded 
		              inserting db using addDynamicFiles method of DynamicModel class
		          */ 
	   			$filePath = GenericFunctions::fileUpload($file, $fileName, '\Dynamic Files');
	   			$data = array(
	   				'file' => $filePath
	   			);
	   			$upload->addDynamicFiles($data);
	   		}
	   		return Response(['message'=>'Files are Uploaded'], 200);
   		} 
	   		return Response(['message'=>'No Files selected to Upload'], 404);

   }
}
