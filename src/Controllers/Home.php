<?php
namespace Controllers;

/**
 *
 * @author jean-luc
 *        
 */
class Home
{

    /**
     * @Route\Get(path="/")
     */
    public function home(){
        echo "Hello, je suis le contrôleur par défaut";
    }
}

