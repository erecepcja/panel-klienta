<?php
session_start();

try {
    $x = new SoapClient("plik.wsdl", array('soap_version'   => SOAP_1_2));  
	var_dump($x->zmienSesje('a','e'));
	var_dump($x->pobierzSesje('a'));
	$wynik = $x->zaloguj('znanylekarz', 'znanylekarz123');
	var_dump($wynik);
} catch (Exception $e) {  
	var_dump($e);
    echo $e->getMessage(); 
} 