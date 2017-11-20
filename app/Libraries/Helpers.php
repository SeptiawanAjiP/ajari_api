<?php

class Helpers
{
	private static $folder = 'sd';
	private static $appUrl = 'https://www.com';

	private static function getImgPath()
	{
		$basePath = rtrim(preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']), Helpers::$apiFolder);
		return $basePath.'/dedaharan/img/';
	}

	private static function userPath()
	{
		return Helpers::getImgPath().'img/user/';
	}

	private static function mentorPath()
	{
		return Helpers::getImagePath().'img/mentor/';
	}

}

?>