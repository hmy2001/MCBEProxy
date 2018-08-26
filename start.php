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

namespace MCBEProxy{
    use MCBEProxy\MCBEProxy;
    use MCBEProxy\utils\ClassLoader;

    require_once(__DIR__ . "/src/MCBEProxy/utils/ClassLoader.php");

    $loader = new ClassLoader();
    $loader->addPath(__DIR__ . "/src");
    $loader->register();

    if(php_sapi_name() === "cli"){
        $class = new MCBEProxy(__DIR__);
        $class->getLogger()->info("Thank you for using MCBEProxy by Hmy2001!");
    }else{
        echo "It cannot start from web.<br> Please start from a command-line<br>";
    }
}
