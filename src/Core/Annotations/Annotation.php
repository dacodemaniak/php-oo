<?php
namespace Core\Annotations;

/**
 *
 * @author jean-luc
 *        
 */
abstract class Annotation
{
    protected $routes;

    protected function __construct() {
        $this->routes = [];
    }
    
    abstract protected function readAnnotation();
    
    public function getRoutes(): array {
        return $this->routes;
    }
    
    protected function fetchFiles(string $path) {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . "/../../" . $path));
        
        $files = [];
        
        foreach ($iterator as $file) {
            
            if ($file->isDir()){
                continue;
            }
            
            $classFilePath = explode(DIRECTORY_SEPARATOR, $file->getPathname());
            $classFileName = array_pop($classFilePath);
            $className = substr($classFileName, 0, -4);
            $files[] = "\\Controllers\\" . $className;
        }
        return $files;
    }
}

