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

class MainLogger{

	public function __construct($path, $debuglevel){
		$this->path = $path;
		$this->debuglevel = $debuglevel;
	}


	public function info($message){
		$this->message("[INFO]", $message);
	}

	public function debug($message, $level = 1){
		if($this->debuglevel > $level){
			$this->message("[DEBUG]", $message);
		}
	}

	public function message($level, $message){
		echo "[MainLogger]".$level." ".$message.PHP_EOL;
	}

}
?>
