<?php

function chk_array($array, $key){		
	if(isset($array[$key]) && !empty($array[$key])){		
		return $array[$key];
	}
	
	return null;
} 

function convertDate($date, $mask = 0){
	$array = explode(" ",$date);
	$arr1 = explode('/', $array[0]);
	$arr2 = explode('-', $array[0]);
	
	if(count($arr1) == 3){			
		if(1 == $mask){
			$date = trim($arr1[2]).trim($arr1[1]).trim($arr1[0]);
		}else{
			$date = trim($arr1[2]).'-'.trim($arr1[1]).'-'.trim($arr1[0]);			
		}
	}elseif(3 == count($arr2)){
		$date = trim($arr2[2]).'/'.trim($arr2[1]).'/'.trim($arr2[0]);
	}elseif(isset( $date[7] )){
		$ano = substr($date, 0, 4);
		$mes = substr($date, 4, 2);
		$dia = substr($date, 6, 2);
		$date = $ano.'-'.$mes.'-'.$dia;
	}else{
		$date = false;
	}

	$date = $date." ".$array[1];	
	return $date;
}

function getDataAtual($date = null, $format = 'd/m/Y'){ // informar o formato yyyy-mm-dd
	if($date){
		$arr1 = explode('/', $date);		
		if(count($arr1) != 3 && $format == 'd/m/Y'){
			$date = convertDate($date);
		}
		$data_atual = DateTime::createFromFormat($format, $date);
	}else{
		$data_atual = new DateTime();
	}
	
	if($data_atual){
		return $data_atual;
	}else{
		return false;
	}
}

function autoLoad($class_name){		
    $file = ABSPATH.DS.'classes/class-'.$class_name.'.php';		
    if(!file_exists($file)){
        echo '<br>'.$class_name.'<br>';			
        return;
    } 
    require_once $file;		
}

spl_autoload_register('autoLoad'); 