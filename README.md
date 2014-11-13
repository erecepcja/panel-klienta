Panel Klienta
============

WebServices SOAP do obsługi panelu klienta eRecepcji. 

1. Początek początków
----------------------------

Jesteś zainteresowany wprowadzeniem na swoją stronę rezerwacji on-line? Poniżej znajdziesz instrukcje jak to zrobić razem z systemem eRecepcja.pl. Impelementacja naszego API jest prosta i przejrzysta.

2. Wymagania
---
Co będzie potrzebne do implementacji na naszej stronie kodu? Będziemy potrzebowali
- odpowiedniej grafiki
- serwera z interpreterem PHP 5.x z obsugą SOAP
- specjalnego konta użytkownika z systemu eRecepcja (dane jakie powinniśmy otrzymać: login, hasło, specjalny adres url)

3. Pierwsze kroki w implementacji
---
Przede wszystkim będziemy potrzebowali zmiennych sesyjnych, aby podtrzymać zalogowanego
użytkownika i jego dane podręczne. 
<code>session_start();</code>

Najprostsze logowanie przez web serwisy można zrobić za pomocą kodu:
<code>
$soap = new SoapClient($url.'-wsdl', array('soap_version'   => SOAP_1_2));  
$wynik = $soap->zaloguj($login, $haslo);
if( $wynik )
{
    echo 'Sukces! Logowanie się powiodło!';
} else
{
    echo 'Błąd logowania, sprawdź poprawność loginu lub hasła.';
}
</code>
gdzie zmienne url, login oraz haslo są danymi konta użytkownika z serwisu eRecepcja. Ten sposób logowania jest dobry dla funkcji API, które nie muszą kożystać z pamięci podręcznej serwera.

Sposób dzięki któremu będziemy mogli kożystać ze wszystkich funkcji:
<code>
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
</code>



6. Przykłady
---
Przykładowe próbki doków są dostępne w folderze examples/

