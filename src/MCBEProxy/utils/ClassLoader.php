<?php

/*
 *  __  __  _____ ____  ______   _____                     
 * |  \/  |/ ____|  _ \|  ____| |  __ \                    
 * | \  / | |    | |_) | |__    | |__) | __ _____  ___   _ 
 * | |\/| | |    |  _ <|  __|   |  ___/ '__/ _ \ \/ / | | |
 * | |  | | |____| |_) | |____  | |   | | | (_) >  <| |_| |
 * |_|  |_|\_____|____/|______| |_|   |_|  \___/_/\_\\__, |
 *                                                    __/ |
 *                                                   |___/ 
 *
 *
 * This software is simply implemented in proxy of minecraft.
 *
*/

namespace MCBEProxy\utils;

class ClassLoader{
	private $path = [];

	public function addPath($path){
		$this->path[] = $path;
	}

	public function register(){
		return spl_autoload_register([$this, "loadClass"]);
	}

	public function findClass($name){
		$components = explode("\\", $name);

		$baseName = implode(DIRECTORY_SEPARATOR, $components);

		foreach($this->path as $path){
			if(file_exists($path.DIRECTORY_SEPARATOR.$baseName.".php")){
				return $path.DIRECTORY_SEPARATOR.$baseName.".php";
			}else{
				echo "NotPath: ".$path.DIRECTORY_SEPARATOR.$baseName.".php".PHP_EOL;//Debug
			}
		}
		return null;
	}

	public function loadClass($name){
		$path = $this->findClass($name);
		if($path !== null){
			include($path);
			return true;
		}
		return false;
	}

}
