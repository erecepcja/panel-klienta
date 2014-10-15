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

$wynikAutoryzajci = json_decode($soap->autoryzacjaKlienta('500-000-000', '', '', '49040501580','', 0));

if( $wynikAutoryzajci->kod == '0')
{
	$wynikJson = $soap->zapiszKlientaNaTermin(
		68, // id stanowiska z jakiego chcemy (mozemy spr id stanowiska przy pomocy metody pobierzStuktureStanowisk())
		58, // id uslugi na jaka chcemy zapisac klienta (mozemy spr id stanowiska przy pomocy metody pobierzListeUslugStanowiska(idStanowiska))
		'2014-10-15 16:07:00' // data na jaka klient ma byc zapisany (mozna ja uzyskac z poprzedniego przykladu nr 4)
	);
}

echo 'Zwrocony kod wykonanej metody zapiszKlientaNatermin():<br><br> <pre>';
print_r(json_decode($wynikJson));
echo '</pre>
';

