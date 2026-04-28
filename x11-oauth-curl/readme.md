# 11. Přihlašování přes OAuth, CURL 

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

Pro vyzkoušení volání můžete využít [API z minulého cvičení](../x10-rest-api-pdf#tvorba-rest-api).

:blue_book:
- [příklad využití REST API pomocí CURL](./11-php-client-curl.php)
- [příklad využití REST API pomocí file_get_contents()](./11-php-client-file_get_contents.php)  

:point_right:

*K zamyšlení: Zvládli byste vytvořit PHP skript s formulářem pro přidání nové osoby do adresáře, který využíváme přes API?*
  
:blue_book:

Další zdroje:
- [Web services (SOAP) v PHP manuálu](https://www.php.net/manual/en/book.soap.php)
- [GraphQL pro PHP](https://graphql.org/code/#php) (ale existuje i celá řada dalších knihoven)

## Přihlašování pomocí protokolu OAuth
:point_right:

- Vedle lokálního přihlašování uživatelů poskytuje velké množství aplikací také přihlášení pomocí účtů např. na sociálních sítích. Proč tomu tak je?
    - uživatelé si nemusí pamatovat další přihlašovací údaje
    - nemusíme řešit zabezpečení přihlašovacích údajů ve vlastní aplikaci, řešit dvoufaktorovou autentizaci atp.
    - společně s e-mailem získáme z daného účtu 
- většina služeb poskytujících přihlašování podporuje protokol OAuth 2.0
    - např. Facebook, Google, Twitter, GitHub,...
- výsledkem přihlášení je získání ID uživatele přidělené danou službou a také přístup k API, které daná služba poskytuje (a pomocí něj můžeme získat další informace o uživateli) 
- alternativně bychom mohli použít např. autentizační protokol OpenID

### Kam ukládat identifikaci uživatelů ve vlastní aplikaci?
:point_right:

- z každé ze služeb vždy získáme ID uživatele, pod kterým je vedený v dané službě
- pro uložení ID si doplníme příslušný sloupec do tabulky s uživateli (v reálu jich může být i víc - např. ```facebook_id```, ```google_id``` atp.)
- pokud budeme chtít více pracovat s API dané služby, uložíme si kromě id a údajů daného uživatele také **access token**
    - např. do session - budeme jej dále potřebovat pro přístup k API dané služby    
- výhodou tohoto uložení informace o uživatelském účtu je to, že můžeme v aplikaci umožnit přihlašování lokálně i pomocí jiných služeb najednou (a uživatel je může dokonce střídat)
  
### Postup registrace a přihlašování uživatelů pomocí protokolu OAuth
:point_right:

1. aplikaci musíme mít zaregistrovanou na serveru poskytovatele
2. v aplikaci vygenerujeme odkaz, který uživatele přesměruje na server poskytovatele
    - s vygenerováním odkazu nám obvykle pomůže knihovna pracující s daným API
    - odkaz umístíme na web do přihlašovacího tlačítka, nebo na něj uživatele přesměrujeme z nějaké naší vlastní stránky
3. uživateli se zobrazí standardní okno pro přihlášení danou službou a při prvním přihlášení také výzva k udělení oprávnění pro naši aplikaci
4. ať už nám uživatel přihlášení schválil, nebo odmítl, je přesměrován zpět do naší aplikaci
    - uživatel se dostane na callback URL, kterou jsme odeslali v požadavku na přihlášení a zaregistrovali ji v nastavení na serveru poskytovatele
5. pokud se uživatel úspěšně přihlásil, získáme access token pro přístup k API dané služby
6. pomocí access tokenu získáme potřebné informace o uživateli (ID, jméno, e-mail, fotku atp.)
7. ve vlastní databázi v tabulce s uživateli vyhledáme uživatele podle ID v dané službě
    - pokud jej nalezneme, přihlásíme ho, jako kdyby zadal správnou kombinaci e-mailu a hesla
8. pokud uživatele podle ID nenalezneme, zkusíme jej najít pomocí e-mailu
    - pokud jej nalezneme, přihlásíme ho, jako kdyby zadal správnou kombinaci e-mailu a hesla
    - zároveň si do DB uložíme ID uživatel v dané službě
9. pokud jsme uživatele nenašli ani podle ID, ani podle e-mailu, uložíme jej do databáze jako uživatele nového
    - a samozřejmě jej přihlásíme

### Ukázka implementace přihlašování pomocí Facebooku
:point_right:

Jako příklad přihlášení pomocí externího ověření uživatele protokolem OAuth si do aplikace z dnešního cvičení doplníme možnost přihlašování pomocí uživatelského účtu na síti Facebook.

Pro realizaci budete potřebovat vlastní uživatelský účet na Facebooku. Pokud jej nepoužíváte, velmi podobně by vypadalo přihlášení např. pomocí účtu Google, Twitter atp.

:point_right:

**Řešení přímo navazuje na předchozí příklad** s registrací, přihlašováním a obnovou zapomenutého hesla. Pokud jste jej z nějakého důvodu neabsolvovali:
1. stáhněte si [zdrojový kód](./11-local-login)
2. nahrajte zdrojový kód aplikace na server eso.vse.cz
3. naimportujte [SQL export](./11-local-login/local-login.sql) do databáze

:orange_book:

**Řešení:**
- [prezentace s komentovaným postupem řešení](./11-facebook-login/prezentace-postup-vyvoje-facebook-login.pptx)
- [vytvořený zdrojový kód včetně exportu databáze](./11-facebook-login)
