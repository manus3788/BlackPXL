<?php

namespace App\Http\Controllers;

use App\Helpers\GenericFunctions;
use App\Helpers\MailHelper;

use Illuminate\Http\Request;
use File;
use Carbon\Carbon;
use App\JobApplication;

class JobController extends Controller
{
    public function index() {
      // job application view load
    	return view('job');
    }

    public function storeUserInfo(Request $request) {
      /*
          Validating form inpur files
          and it returns 422 if not validated
      */
    	$validated = $request->validate([
	        'name' => 'required|max:20',
	        'email' => 'required|regex:/^.+@.+$/i|max:50',
	        'designation' => 'required',
	        'resume' => 'required|mimes:doc,pdf,docx',
	        'message' => 'required|max:255',
	    ]);

    	$data = $request->all();
        $file = $request->file('resume'); // fetching file
        /*
          converting original name into (Name of the applicant+current time+extention)
          and also removing special characters if any using  removeSelctedSpecialChar  method of GenericFunctions static class
        */
        $fileName = GenericFunctions::removeSelctedSpecialChar($request->input('name').Carbon::now()).'.'.$file->getClientOriginalExtension(); 
          /*
            File upload using fileUpload of GenericFunction class
            if uploaded 
              inserting db using addJobApplication method of JobApplication class
          */ 
        if ($data['resume'] = GenericFunctions::fileUpload($file, $fileName, '\Resumes')) {
           	$application = new JobApplication();
           	if ($application->addJobApplication($data)) {
              /*
                sending mail using sendMail method of MailHelper class
              */
                $response = MailHelper::sendMail($data);
                return Response(['message'=>$response['message']], $response['http_code']);
           	} else {
           		return Response(['message'=>'Something went wrong, Application Not Sent'], 404);// 404 status code accordingly
           	}
        } else {
        	return Response(['message'=>'File Not Uploaded, Please Try Again'], 404);// 404 status code accordingly
        }
    }
}
