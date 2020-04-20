# 11. Přihlašování přes OAuth, CURL

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry: 

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičení 8. 5. 2020, doporučuji ji však ke studiu také studentům z pátečních cvičení.**

## Opakování z předchozích cvičení
:point_right:

Na dnešním cvičení navážeme na [předchozí cvičení](../10-rest-api-pdf), na kterém jsme se zabývali **tvorbou API**. O tom bychom si měli pamatovat, že:
- pro REST API využíváme HTTP metody GET, POST, PUT a DELETE,
- pro komunikaci většinou používáme [JSON](../09-uzivatele-db-json-xml#json) nebo [XML](../09-uzivatele-db-json-xml#xml).

:point_right:

Následně si nejprve připomeneme **práci s uživatelskými účty**, kterou jsme se zabývali [na cvičení 08](../08-uzivatele-maily).
Ohledně lokálního přihlašování je vhodné si připomenout, že:
- hesla ukládáme v aplikaci vždy šifrovaně (a při zapomenutém hesle jej tedy nemůžeme uživateli poslat),
- informace o přihlášením uživateli si ukládáme do session.

---

:point_right:

**Na tomto cvičení nás čeká:**
- [volání vzdáleného API](#vol%C3%A1n%C3%AD-vzd%C3%A1len%C3%A9ho-api)
- [ukázka obnovy zapomenutého hesla](#obnova-zapomenut%C3%A9ho-hesla)
- [přihlašování pomocí protokolu Oauth](#p%C5%99ihla%C5%A1ov%C3%A1n%C3%AD-pomoc%C3%AD-protokolu-oauth)

---

## Volání vzdáleného API
:point_right:

Velké množství aplikací dnes na internetu obvykle nefunguje jako zcela samostatné a oddělené kusy software, ale jsou vzájemně provázány prostřednictvím API. Ale proč vlastně?
- větší pohodlí pro uživatele (např. se může přihlásit uživatelským účtem z Googlu či Facebooku i do naší apky, může do ní přímo načítat data...)
- získání dat, která nemá naše aplikace k dispozici, ale potřebujeme je pro naši činnost (např. nabídka zájezdů a dopravy na webu cestovní agentury, zobrazení mapy atp.)
- kontrola stavu vzdáleného systému,...

:point_right:
Existuje celá řada standardů, na kterých může být API postaveno. Nejčastěji používáme v zásadě 3 (respektive 4) z nich - REST API (či vzdálené volání požadavků přes HTTP), SOAP a QraphQL.

Na tomto cvičení si ukážeme využívání externího REST API, které je velmi populární jak pro svoji jednoduchost, tak také pro snadnost použití nejen z PHP, ale také např. z JavaScriptu.

### Volání REST API z PHP
:point_right:

V případě, že máme na serveru povolený *fopen wrapper* (o kterém jsme se bavili v souvislosti s prací se soubory), můžeme vzdálená data jednoduše stáhnout prostřednictvím funkce ```file_get_contents()```. V případě HTTP metody GET dokonce bez jakéhokoliv nastavování (ale jde doplnit konfigurace i pro další metody).

Pokud potřebujeme větší kontrolu nad odesláním požadavku, nebo máme na serveru z bezpečnostních důvodů fopen wrapper zakázaný, využijeme možnost využít **CURL**.

Pro vyzkoušení volání můžete využít [API z minulého cvičení](../10-rest-api-pdf#tvorba-rest-api).

:blue_book:
- [příklad využití REST API pomocí CURL](./11-php-client-curl.php)
- [příklad využití REST API pomocí file_get_contents()](./11-php-client-file_get_contents.php)  

:point_right:
**K zamyšlení: Zvládli byste vytvořit PHP skript s formulářem pro přidání nové osoby do adresáře, který využíváme přes API?**
  
:blue_book:
Další zdroje:
- [Web services (SOAP) v PHP manuálu](https://www.php.net/manual/en/book.soap.php)
- [GraphQL pro PHP](https://graphql.org/code/#php) (ale existuje i celá řada dalších knihoven)

## Obnova zapomenutého hesla
:point_right:

TODO 


## Přihlašování pomocí protokolu OAuth
:point_right:

TODO
