<?php
namespace  Core\Http\Foundation;

use Core\Annotations\Route;

/**
 *
 * @author jean-luc
 *        
 */
class Request implements \Iterator{

    /**
     * Stores some query params
     * @var array
     */
    private $queryParams = [];
    
    /**
     * 
     * @var int Array fetch index
     */
    private $index;
    
    /**
     * 
     * @var Route Instance des routes définies dans l'application
     */
    private $route;
    
    /**
     * {@inheritDoc}
     * @see Iterator::current()
     */
    public function current()
    {
        return current($this->queryParams);
        
    }

    /**
     * {@inheritDoc}
     * @see Iterator::key()
     */
    public function key()
    {
        return key($this->queryParams);
        
    }

    /**
     * {@inheritDoc}
     * @see Iterator::next()
     */
    public function next()
    {
        next($this->queryParams);
        
    }

    /**
     * {@inheritDoc}
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        reset($this->queryParams);
        
    }

    /**
     * {@inheritDoc}
     * @see Iterator::valid()
     */
    public function valid(): bool
    {
        return key($this->queryParams) !== null;
        
    }

    /**
     * 
     */
    public function __construct(Route $route){
        $this->queryParams = $this->_getQueryParams();
        $this->route = $route;
    }
    
    public function __get($attributeName) {
        if (! property_exists($this, $attributeName)) {
            if (array_key_exists($attributeName, $this->queryParams)) {
                return $this->queryParams[$attributeName];
            }
        } else {
            return $this->{$attributeName};
        }
        throw new \Exception("L'attribut " . $attributeName . " n'existe pas dans la classe " . self::class);
    }
    
    public function __set($attributeName, $value) {
        
    }
    
    public function hasMatch(): array {
        try {
            $responseHandler = $this->route->hasMatch(
                $this->request_method,
                $this->request_uri
            );
            return $responseHandler;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
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

