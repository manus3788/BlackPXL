<?php

namespace App\Helpers;
use File;
class GenericFunctions 
{
    public static function removeSelctedSpecialChar($string) {
      $pattern = '/[^a-zA-Z0-9\.*]/i';
      return str_replace(' ', '', preg_replace($pattern, '', $string));
    }

    public static function fileUpload($file, $fileName, $folder) {
    	/*
			\Files\Resumes folders are to be created to upload the file in the that location
    	*/
    	$newFolder = "\Files".$folder; // 
    	/*
			public_path gives the url till public folder so, concatenating with folders where file has to uplaod
    	*/
        $path = public_path() . $newFolder; 
        /*
			checking the folders are exists or not. 
			if not exist
				create folders and upload the files
			else 
				move the file to the location

			if files are uploaded then returning full path to save it to Database
			else returning false
    	*/
    	if(!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        if ($file->move($path, $fileName)) {
            return $newFolder.'\\'.$fileName;
        } else {
            return false;
        }
    }
}
