<?php

// wpisz poniżej dane, które otrzymałeś od systemu eRecepcja

$url = 'http://medyczna1.erecepcjaeu/soap?wsdl';
$login = 'soapowscy';
$haslo = 'soapowscy';

try 
{
    $soap = new SoapClient("plik.wsdl", array('soap_version'   => SOAP_1_2));  
	$wynik = $soap->zaloguj($login, $haslo);
	if( $wynik )
	{
		echo 'Sukces! Logowanie się powiodło!';
	} else
	{
		echo 'Błąd logowania, sprawdź poprawność loginu lub hasła.';
	}
} catch (Exception $e) {
   echo 'Mamy problem: '.$e->getMessage(); 
} 