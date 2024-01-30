<?php
class Session{
	
	public static function init(){	
		session_start();
		if(!self::isExist('cart'))
		{
			self::set('cart', ['quantity' => [], 'price' =>[]]);
		}
	}
	
	public static function set($key, $value){
		$_SESSION[$key] = $value;
	}
	
	public static function get($key){
		if(isset($_SESSION[$key]))
			return $_SESSION[$key];
		return null;
	}

	public static function isExist($key)
	{
		if(isset($_SESSION[$key]))
			return true;
		return false;
	}
	
	public static function delete($key){
		if(isset($_SESSION[$key])) unset($_SESSION[$key]);
	}
	
	public static function destroy(){
		session_destroy();
	}

}

