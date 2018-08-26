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

class CommandReader{

	public function __construct(){
		$this->read = [];
		$this->write = null;
		$this->except = null;
	}

	public function getCommandLine(){
		$this->read[] = STDIN;
		if(stream_select($this->read, $this->write, $this->except, 0, 200000) > 0){
			$line = trim(fgets(STDIN));
			return $line;
		}
		return null;
	}

}
