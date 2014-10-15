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

$wolneTerminy = json_decode($soap->pobierzListeTerminow(
	68, // id stanowiska z jakiego chcemy (mozemy spr id stanowiska przy pomocy metody pobierzStuktureStanowisk())
	58, // id uslugi na jaka chcemy zapisac klienta (mozemy spr id stanowiska przy pomocy metody pobierzListeUslugStanowiska(idStanowiska))
	'2014-10-14', // od jakiej daty skrypt ma zaczac szukac? Jesli nie podamy tego parametru, to domyslnie zacznie szukanie od dzisiaj.
	15 // przez ile dni ma szukac terminow? Czasem domyslna liczba (30 dni) jest za duża i skrypt długo niemoże zwrócić wyniku.  
));
	


echo 'Otrzymalismy liste wolnych terminow:<br><br> <pre>';
print_r($wolneTerminy);
echo '</pre>
';

