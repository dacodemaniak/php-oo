<?php
namespace Core;

use Core\Http\Foundation\Request as HttpRequest;
use Core\Annotations\Route;

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
    
    /**
     * 
     * @var Request Données de la requête HTTP
     */
    private $request;
    
    /**$annotations
     * 
     * @var Core\Annotations\Route
     */
    private $routes;
    
    const _SRC_ROOT_DIR = "src/";
    
    /**
     */
    private function __construct(){
        spl_autoload_register("self::autoload");
        
        // Récupère les données de la requête HTTP
        $this->request = new HttpRequest();
        
        // Récupère les routes définies dans les contrôleurs
        $this->routes = new Route();
    }
    
    public static function getKernel() {
        if (self::$instance == null) {
            self::$instance = new Kernel();
        }
        
        return self::$instance;
    }
    
    /**
     * 
     * @return Request Requête HTTP
     */
    public function getRequest(): HttpRequest {
        return $this->request;
    }
    
    private static function autoload(string $className) {
        $classPath = explode("\\", $className);
        $classFile = array_pop($classPath) . ".php";
        $path = __DIR__ . "/../" . join(DIRECTORY_SEPARATOR, $classPath);
        
        require_once($path . DIRECTORY_SEPARATOR . $classFile);
    }
}

