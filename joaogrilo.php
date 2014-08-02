<?php

/*
Plugin Name: João Grilo
Plugin URI: http://www.bindigital.com.br
Description: João Grilo Functions All
Version: 1.0
Author: Tiago Pires
Author URI: http://www.bindigital.com.br
*/

class JoaoGrilo
{
    public static function init()
    {
    	include_once 'library\autoload.php';
    }
}

$JoaoGrilo = new JoaoGrilo();
$JoaoGrilo->init();
