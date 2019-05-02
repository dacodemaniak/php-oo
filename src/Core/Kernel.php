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
    private $route;
    
    const _SRC_ROOT_DIR = "src/";
    
    private $response;
    
    
    /**
     */
    private function __construct(){
        spl_autoload_register("self::autoload");
        
        // Récupère les routes définies dans les contrôleurs
        $this->route = new Route();
        
        // Récupère les données de la requête HTTP
        try {
            $this->request = new HttpRequest($this->route);
        
            // Tente de déterminer le gestionnaire de réponse
            try {
                $responseHandler = $this->request->hasMatch();
                var_dump($responseHandler);
            } catch(\Exception $e) {
                // Default to 404...
                echo "Default to 404 : " . $e->getMessage();
            }
        } catch(\Exception $e) {
                die($e->getMessage());
        }
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
    
    
    public function sendResponse() {
        
    }
    
    private static function autoload(string $className) {
        $classPath = explode("\\", $className);
        $classFile = array_pop($classPath) . ".php";
        $path = __DIR__ . "/../" . join(DIRECTORY_SEPARATOR, $classPath);
        
        require_once($path . DIRECTORY_SEPARATOR . $classFile);
    }
}

