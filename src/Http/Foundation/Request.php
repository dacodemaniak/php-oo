<?php
namespace  Http\Foundation;

/**
 *
 * @author jean-luc
 *        
 */
class Request {

    /**
     * Stores some query params
     * @var array
     */
    private $queryParams = [];
    
    /**
     * 
     */
    public function __construct(){
        $this->queryParams = $this->_getQueryParams();
    }
    
    public function __get($attributeName) {
        if (! property_exists($this, $attributeName)) {
            if (array_key_exists($attributeName, $this->queryParams)) {
                return $this->queryParams[$attributeName];
            }
        }
        throw new \Exception("L'attribut " . $attributeName . " n'existe pas dans la classe " . self::class);
    }
    
    public function __set($attributeName, $value) {
        
    }
    
    /**
     * Returns poor array with query parameters
     * @return array
     */
    private function _getQueryParams(): array {
        $params = [];
        foreach($_SERVER as $key => $value) {
            $params[strtolower($key)] = $value;
        }
        
        // Parcourir $_GET et $_POST
        foreach($_GET as $key => $value) {
            $params[$key] = $value;
        }
        
        foreach($_POST as $key => $value) {
            $params[$key] = $value;
        }
        return $params;
    }
}

