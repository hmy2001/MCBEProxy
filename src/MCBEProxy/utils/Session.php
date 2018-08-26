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

use MCBEProxy\protocol\PacketAnalyze;

class Session{
	public function __construct($logger, $host, $serverip, $serverport){
		$this->serverip = $serverip;
		$this->serverport = (int) $serverport;
		$this->logger = $logger;

		$this->serverSocket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
		if(@socket_bind($this->serverSocket, $host) === true){
			$this->logger->debug("socket open (".$host.":random)");
		}else{
			$this->working = false;
			echo "Error\n";
		}
		socket_set_nonblock($this->serverSocket);

		//$this->packetanalyze = new PacketAnalyze($this->logger);
	}

	public function sendServerSocket($buffer){
		return socket_sendto($this->serverSocket, $buffer, strlen($buffer), 0, $this->serverip, $this->serverport);
	}

	public function receiveServerSocket(&$buffer){
		$bytes = socket_recvfrom($this->serverSocket, $buffer, 65535, 0, $address, $port);
		if($bytes !== false){
			if($address === $this->serverip and $port === $this->serverport){
				return $bytes;
			}
		}

		return false;
	}

	public function close($value){
		socket_close($this->serverSocket);
	}

}