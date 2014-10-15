<?php 

// wpisz poniżej dane, które otrzymałeś od systemu eRecepcja

$url = 'http://medyczna1.erecepcja.eu/soap';
$login = 'soapowscy';
$haslo = 'soapowscy';

session_start();

$soap = new SoapClient($url.'-wsdl', array('soap_version'   => SOAP_1_2)); 

if( !isset($_SESSION['soap']['sid']) )
{
	$_SESSION['soap']['sid'] = $soap->zaloguj('soapowscy','soapowscy');
} else
{
	if( $soap->zalogujPrzezSid($_SESSION['soap']['sid']) )
	{
		$_SESSION['soap']['sid'] = $soap->zaloguj('soapowscy','soapowscy');
	}
}

var_dump($_SESSION['soap']['sid']);

