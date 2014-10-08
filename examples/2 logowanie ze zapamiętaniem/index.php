<?php 

// wpisz poni¿ej dane, które otrzyma³eœ od systemu eRecepcja

$url = 'http://medyczna1.erecepcjaeu/soap';
$login = 'soapowscy';
$haslo = 'soapowscy';

session_start();

$soap = new SoapClient('plik.wsdl', array('location'=>$url)); 

if( !isset($_SESSION['soap']['sid']) )
{
	$_SESSION['soap']['sid'] = $soap->zaloguj('soapowscy','soapowscy');
} else
{
	$zal = $soap->zalogujPrzezSid($_SESSION['soap']['sid']);
	if( !$zal )
		$_SESSION['soap']['sid'] = $soap->zaloguj('soapowscy','soapowscy');
}


