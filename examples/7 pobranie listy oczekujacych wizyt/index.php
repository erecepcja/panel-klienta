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

$wynikJson = $soap->pobierzListeRezerwacjiStanowiska(
	68, // id stanowiska z jakiego chcemy (mozemy spr id stanowiska przy pomocy metody pobierzStuktureStanowisk())
	'2014-10-14' //data z jakiego dnia chcemy uzyskac liste rezerwacji
);

echo 'Lista rezerwacji z dnia 2014-10-14:<br><br> <pre>';
print_r(json_decode($wynikJson));
echo '</pre>
';

