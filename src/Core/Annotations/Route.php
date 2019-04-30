<?php
namespace Core\Annotations;

use Core\Annotations\Annotations;
use Core\Annotations\IAnnotationReader;
/**
 *
 * @author jean-luc
 *        
 */
class Route extends Annotation implements IAnnotationReader
{

    /**
     */
    public function __construct(){
        parent::__construct();
        
        $this->readAnnotation();
    }
    
    /**
     * @Override
     */
    protected function readAnnotation() {
        $controllers = parent::fetchFiles("Controllers");
        $matches = [];
        
        foreach($controllers as $controller) {
            
            $reflector = new \ReflectionClass($controller);
            
            $methods = $reflector->getMethods();
            foreach($methods as $method) {
                $docComment = $reflector->getMethod($method->name)->getDocComment();
                
                //define the regular expression pattern to use for string matching
                $pattern = "#(@[a-zA-Z]+\s*[a-zA-Z0-9, ()_].*)#";
                
                //perform the regular expression on the string provided
                preg_match_all($pattern, $docComment, $matches, PREG_PATTERN_ORDER);
                
                try {
                    $this->routes[$controller][$method->name] = $this->read($matches[0][0]);
                } catch (Exception $e) {
                    // NOOP
                }
                
            }
        }
    }
    
    public function read(string $annotation): array {
        if (strstr($annotation, "@Route") !== false ) {
            $stringParser = explode("\\", $annotation);
            array_shift($stringParser);
            // Extract Http verb from annotation
            $httpVerb = substr($stringParser[0],0, strpos($stringParser[0], "("));
            
            // Extract route path
            $pattern = "#\((.*?)\)#";
            preg_match($pattern, $stringParser[0], $matches);
            
            $path = $matches[1];
            
            // path parser
            $pathes = explode("=", $path);
            
            $routePath = str_replace("\"","", $pathes[1]);
            
            return [
                "verb" => $httpVerb,
                "route" => $routePath
            ];
        }
        
        throw new \Exception("No route found");
    }
}

