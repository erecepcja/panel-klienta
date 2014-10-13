<?php 

// wpisz poniżej dane, które otrzymałeś od systemu eRecepcja

$url = 'http://medyczna1.erecepcja.eu/soap';
$login = 'soapowscy';
$haslo = 'soapowscy';

session_start();

$soap = new SoapClient('plik.wsdl', array('soap_version'   => SOAP_1_2)); 

if( !isset($_SESSION['soap']['sid']) )
{
	$_SESSION['soap']['sid'] = $soap->zaloguj('soapowscy','soapowscy');
} else
{
	$zal = $soap->zalogujPrzezSid($_SESSION['soap']['sid']);
	if( !$zal )
		$_SESSION['soap']['sid'] = $soap->zaloguj('soapowscy','soapowscy');
}

$wynikJson = $soap->odwolajRezerwacje(
	723 // id rezerwacji
);

echo 'Zwrocony kod wykonanej metody odwolajRezerwacje():<br><br> <pre>';
print_r(json_decode($wynikJson));
echo '</pre>
';

