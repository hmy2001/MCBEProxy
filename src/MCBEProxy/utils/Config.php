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

class Config{
	protected $path, $content, $overwrite;

	public function __construct($path, $content = [], $overwrite = false){
		$this->path = $path;
		$this->content = $content;
		$this->overwrite = $overwrite;
		if(file_exists($this->path)){
			$this->content = json_decode(file_get_contents($this->path), true);
		}else{
			$this->save();
		}
	}

	public function get($name){
		if(isset($this->content[$name])){
			return $this->content[$name];
		}
		return null;
	}

	public function set($name, $content){
		return $this->content[$name] = $content;
	}

	public function save(){
		file_put_contents($this->path, json_encode($this->content, JSON_PRETTY_PRINT));
	}

}
?>
