<?php

class Ajari
{
	private static function getImgPath()
	{
		$basePath = rtrim(preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']), Helpers::$apiFolder);
		return $basePath.'/djhfkd/';
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