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

namespace MCBEProxy;

use MCBEProxy\utils\CommandReader;
use MCBEProxy\utils\Config;
use MCBEProxy\utils\MainLogger;
use MCBEProxy\utils\SocketReader;

class MCBEProxy{
    protected $path, $logger;
    protected static $interface;

    public function getPath(){
        return $this->path;
    }

    public function getLogger(){
        return $this->logger;
    }

    public static function getInterface(){
        return self::$interface;
    }

    public function __construct($path){
        set_error_handler(function($severity, $message, $file, $line){
            echo "LINE: ".$line . "\n";
            echo "log: ".$message . "\n";
            $debug = debug_backtrace();
            echo $debug[1]["class"] . " : " . $debug[1]["function"] . "\n";
            echo $debug[2]["class"] . " : " . $debug[2]["function"] . "\n";
        });

        $this->path = $path;
        self::$interface = clone $this;

        $this->config = new Config($this->path.DIRECTORY_SEPARATOR . "config.json", [
            "host" => "0.0.0.0",
            "port" => "19132",
            "serverip" => "0.0.0.0",
            "serverport" => "19132",
            "debuglevel" => 0,
        ]);
        $this->config->save();

        $this->logger = new MainLogger($this->path, $this->config->get("debuglevel"));
        $this->logger->info("MCBEProxy starting now...");

        $this->working = true;

        $this->commandreader = new CommandReader();
        $this->socketreader = new SocketReader($this->logger, $this->config->get("host"), $this->config->get("port"), $this->config->get("serverip"), $this->config->get("serverport"));

        $this->logger->info("MCBEProxy start!");

        echo "\x1b]0;MCBEProxy running!\x07";

        $this->tick();
    }

    public function tick(){
        while($this->working){
            $this->getCommandLine();
            for($i = 0; $i <= 100000; $i++){
                $this->socketreader->tick();
            }
        }
    }

    public function getCommandLine(){
        $line = $this->commandreader->getCommandLine();
        if($line !== null){
            $line = explode(" ", $line);
            switch($line[0]){
                case "stop":
                case "shutdown":
                    $this->shutdown();
                break;
                case"help":
                    if(isset($line[1])){
                        switch($line[1]){
                            case "stop":
                            case "shutdown":
                                echo "Shutdown system.\n";
                            break;
                        }
                    }else{
                        echo "Usage:\n-stop\n-shutdown : Shutdown system.\n";
                    }
                default:
                    echo "UnknownCommand: " . $line[0] . "\n";
                break;
            }
        }
    }

    public function shutdown(){
        $this->working = false;
        $this->config->save();
        $this->socketreader->shutdown();
        $this->logger->info("Shutdown a system now...");
    }
}