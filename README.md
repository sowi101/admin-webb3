# Projekt i Webbutveckling III (DT173G) administrativ webbplats
I detta repository finns källkodsfiler för en administrativ webbplats för ett fiktivt företag i form av en restaurang. Denna webbplats har skapats för projektarbetet i kursen Webbutveckling III på Mittuniversitetet. Webbplatsen konsumerar data från flera webbtjänster som också har skapats i projektet, genom att hantera menyer och bokningar. Det finns funktionalitet för att både skapa, läsa, uppdatera och radera bokningar och från meny.

## Webbplatsen
Webbplatsen är skapad med hjälp av HTML-kod för grundläggande innehåll, PHP-kod för dynamiskt innehåll och CSS-kod för utseende. I repositoriet finns även bilder och grafik. För att konsumera webbtjänsterna används cURL.

### Funktionalitet
- Möjlighet att skapa, ändra och radera rätter och drycker till restaurangens meny.
- Möjlighet att skapa, ändra och radera bordsbokningar.
- Inloggning och utloggning.
- Presentation av tillagt information. 

### PHP-filer
- **index.php**: Startsida med inloggningsformulär, **POST**-anrop till webbtjänsten **login.php**.
- **admin.php**: Huvudmeny som nås efter inloggning.
- **courses.php**: Formulär för att lägga till maträtter och utskrift av i tre tabeller. **POST**- och **GET**-anrop görs till webbtjänsten **menuapi.php**.
- **drinks.php**: Formulär för att lägga till drycker och utskrift av drycker i fyra tabeller. **POST**- och **GET**-anrop görs till webbtjänsten **menuapi.php**.
- **booking.php**: Formulär för att lägga till bokningar och tabell som skriver ut bokningar gjorda från den administrativa och den publika webbplatsen. **POST**- och **GET**-anrop görs till webbtjänsten **bookingapi.php**.
- **editmenuitem.php**: Formulär för att ändra maträtt eller dryck. **GET**- och **PUT**-anrop görs till webbtjänsten **menuapi.php**.
- **editbooking.php**: Formulär för att ändra bokning. **GET**- och **PUT**-anrop görs till webbtjänsten **bookingapi.php**.
- **deletemenuitem.php**: Innehåller enbart kod för **DELETE**-anrop till webbtjänsten **menuapi.php**.
- **deletebooking.php**: Innehåller enbart kod för **DELETE**-anrop till webbtjänsten **bookingapi.php**.
- **logout.php**: Innehåller enbart kod för att förstöra sessionsvariabeln som krävs för att vara inloggad.

I en includes-mapp finns även följande filer:
- **config.php**: Innehåller kod för webbplatsens title och initiering av session, inkluderas i header.php.
- **header.php**: Innehåller boilerplate för HTML5 samt webbplatsens header med navigering och logotyp, inkluderas på varje webbsida.
- **footer.php**: Innehåller webbplatsens footer, inkluderas på varje webbsida.

## Om repositoriet
Skapat av Sofia Widholm 2022

Webbutveckling III, Webbutvecklingsprogrammet, Mittuniversitetet

Texten i menyerna är hämtade från [Fratelli](https://www.fratelliorebro.se/) och [Trattorian](https://trattorian.se/) och fotografierna är hämtade från [Unsplash](https://unsplash.com/). Övrig text och grafik är skapade av mig.
