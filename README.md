Panel Klienta
============

WebServices SOAP do obsługi panelu klienta eRecepcji. 

1. Początek początków
----------------------------

Jesteś zainteresowany wprowadzeniem na swoją stronę rezerwacji on-line? Poniżej znajdziesz instrukcje jak to zrobić razem z systemem eRecepcja.pl. Implementacja naszego API jest prosta i przejrzysta.

2. Wymagania
---
Co będzie potrzebne do implementacji na naszej stronie kodu? Będziemy potrzebowali
- odpowiedniej grafiki
- serwera z interpreterem PHP 5.x z obsługą SOAP
- specjalnego konta użytkownika z systemu eRecepcja (dane jakie powinniśmy otrzymać: login, hasło, specjalny adres url)

3. Pierwsze kroki w implementacji
---
Najprostsze logowanie przez web serwisy można zrobić za pomocą kodu:

```php
$soap = new SoapClient($url.'-wsdl', array('soap_version'   => SOAP_1_2));  
$wynik = $soap->zaloguj($login, $haslo);
if( $wynik )
{
    echo 'Sukces! Logowanie się powiodło!';
} else
{
    echo 'Błąd logowania, sprawdź poprawność loginu lub hasła.';
}
```

gdzie zmienne url, login oraz haslo są danymi konta użytkownika z serwisu eRecepcja. Ten sposób logowania jest dobry dla funkcji API, które nie muszą korzystać z pamięci podręcznej serwera.

Sposób dzięki któremu będziemy mogli korzystać ze wszystkich funkcji:

```php
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
```
Na samym początku musimy zastartować zmienne sesyjne, aby przetrzymać session id. Session id posłuży nam do wznawiania pamięci podręcznej po stronie serwera API. Jeśli zalogowanie przez tą zmienną nie powiedzie się, to ponownie się logujemy. Może tak się zdarzyć, że za dużo czasu upłynie od ostatniej akcji po stronie serwera i zmienne podręczne wymagają odnowienia.

Aby mieć większą kontrolę nad wyrzucanymi wyjątkami przez protokół SOAP, można zaopatrzyć powyższą sekcję kodu w instrukcje `try` / `catch`:

```php
try 
{
    // kod z powyższej sekcji

} catch (Exception $e) {
   echo 'Mamy problem: '.$e->getMessage(); 
} 
```

4. Zapisanie na wizytę
---

```php
$wynik = json_decode($soap->autoryzacjaKlienta('500-000-000', '', '', '49040501580','', 0));
if( $wynikAutoryzajci->kod == '0')
{
    $wynikJson = $soap->zapiszKlientaNaTermin(
        68, // id stanowiska z jakiego chcemy (mozemy spr id stanowiska przy pomocy metody pobierzStuktureStanowisk())
        58, // id uslugi na jaka chcemy zapisac klienta (mozemy spr id stanowiska przy pomocy metody pobierzListeUslugStanowiska(idStanowiska))
        '2014-10-15 16:07:00' // data na jaka klient ma byc zapisany (mozna ja uzyskac z poprzedniego przykladu nr 4)
    );
} else
{
    echo 'coś poszło nie tak: '.$wynik->wiadomosc;
}
```

5. Wyniki działania funkcji
---

Funkcje API (poza tymi odpowiedzialnymi za logowanie) zwracają ciąg tekstowy w formacie JSON. Po jego zdekodowaniu funkcją `json_decode()` otrzymujemy wynikowy obiekt. Możliwe parametry wynikowe to kod oraz wiadomość.

### kod 
- Jeśli jest równy 0, to oznacza poprawne wykonie funkcji
- Jeśli jest większy od 0, to oznacza nieprawidłowe działanie

### wiadomosc
Jak sama nazwa wskazuje, parametr ten wskazuje informacje do operacji jaka była wykonana. W przypadku błędu, będzie przechowywać dane jaki błąd wystąpił.

6. Przykłady
---
Przykładowe próbki są dostępne w folderze examples/