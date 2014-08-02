<?php

/**
 * Plugin Name: João Grilo
 * Plugin URI: https://github.com/wordpressceara/joaogrilo
 * Description: Esse projeto é um canivete suíço para desenvolvedores WordPress. Ele contém as mais variadas funções para customização do projeto.
 * Version: 0.1
 * Author: Comunidade Wordpress Ceará
 * Author URI: https://www.facebook.com/groups/wordpressceara
 */

if(!class_exists('Joao_Grilo')) :
	
	class JoaoGrilo
	{
	    public static function init()
	    {
	    	include_once 'library\autoload.php';
	    }
	}
	
	$JoaoGrilo = new JoaoGrilo();
	$JoaoGrilo->init();
	
endif;