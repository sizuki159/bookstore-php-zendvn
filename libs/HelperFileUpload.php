<?php

class HelperFileUpload
{
    // Check file size
	public static function checkSize($size, $min, $max){
		$flag = false;
		if($size >= $min && $size <= $max) $flag = true;
		return $flag;
	}
	
	// Check file extensions
	public static function checkExtension($fileName, $arrExtension){
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$flag = false;
		if(in_array(strtolower($ext), $arrExtension)==true) $flag = true;
		return $flag;
    }
    
    // Random file name
    public static function randomStringFile($fileName, $length = 5){
		$ext = pathinfo($fileName, PATHINFO_EXTENSION);
		$arrCharacter = array_merge(range('A','Z'), range('a','z'), range(0,9));
		$arrCharacter = implode('', $arrCharacter);
		$arrCharacter = str_shuffle($arrCharacter);
	
		$result		= substr($arrCharacter, 0, $length) . '.' . $ext;
		return $result;
	}
}
