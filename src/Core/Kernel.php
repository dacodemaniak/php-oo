<?php
namespace Core;

/**
 * @name Kernel
 * @author Aélion
 * @namespace Core
 * @version 1.0.0
 * @desc Singleton of Kernel app
 *        
 */
final class Kernel
{
    
    /**
     * 
     * @var Core\Kernel Instance du coeur de l'application
     */
    private static $instance;
    
    const _SRC_ROOT_DIR = "src/";
    
    /**
     */
    private function __construct(){
        spl_autoload_register("self::autoload");
    }
    
    public static function getKernel() {
        if (self::$instance == null) {
            self::$instance = new Kernel();
        }
        
        return self::$instance;
    }
    
    private static function autoload(string $className) {
        $classPath = explode("\\", $className);
        $classFile = array_pop($classPath) . ".php";
        $path = __DIR__ . "/../" . join(DIRECTORY_SEPARATOR, $classPath);
        
        require_once($path . DIRECTORY_SEPARATOR . $classFile);
        
    }
}

