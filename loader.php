<?php
/**
 * Created by PhpStorm.
 * User: julio.gomes
 * Date: 10/10/2016
 * Time: 16:51
 */
require_once('config.php');

if(SISTEMA_DESATIVADO){
	echo ' SISTEMA DESATIVADO';
	exit;
}

// Inicia a sessão
session_name('lp');

// Verifica o modo para debugar
if ( ! defined('DEBUG') || DEBUG === false ){
	// Esconde todos os erros
	error_reporting(0);
	ini_set("display_errors", 0);
}else{
	// Mostra todos os erros
	error_reporting(E_ALL);
	ini_set("display_errors", 1);	
}

require_once('functions/global.functions.php');


$exec = new MVC();