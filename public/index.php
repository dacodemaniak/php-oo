<?php
/**
 * @name index.php
 * @author Aélion - Avr. 2019
 * @version 1.0.0
 * @desc Point d'entrée dans l'application PHP
 */
require_once("./../src/Core/Kernel.php");


use Core\Kernel;

ini_set("display_errors", true);
error_reporting(E_ALL^E_NOTICE);
    
 $app = Kernel::getKernel();