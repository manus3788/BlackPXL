<?php

namespace App\Helpers;

use Mail;
/**
 * 
 */
class MailHelper 
{
	public static function sendMail($data)
	{
		$data['file'] = asset($data['resume']);
		$data['body'] = " Job Application for the Position for ".$data['designation'].".";
		$data['otherText'] = " Message : ".$data['message'].".";
		Mail::send('mail.sendJobDesc', $data, function($message)use($data) {
            $message->to($data["email"])
                    ->subject($data["name"].' Job Application')
                    ->attach($data['file']);
        });
		$response = [];
	    if( count(Mail::failures()) > 0 ) {
	    	$response['message'] = '';
	    	foreach(Mail::failures() as $error) {
		       $response .=  $error ."<br />";
		    }
	    	$response['http_code'] = 404;
		    return $response;
	    }
	    $response['message'] = 'Application Sent Success';
	    $response['http_code'] = 200;
	    return $response;
    }
	
}