# 9. Uživatelé a DB, JSON, XML

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry: 

## Opakování z předchozího cvičení
:point_right:

Na [předchozím cvičení](../08-uzivatele-maily) jsme se zabývali autentizací a autorizací uživatelů a zasíláním e-mailů. Na tyto znalosti budeme navazovat jak na dnešním cvičení, tak na [cvičení 11](../11-oauth-curl). Pojďme si to tedy trochu připomenout.

:point_right:

Ohledně **autentizace a autorizace uživatelů** byste si měli pamatovat:
- autentizace = autentifikace = zjištění, jaký uživatel se snaží aplikaci používat (tj. ověření totožnosti)
- autorizace = zjištění, zda může uživatel provádět konkrétní činnosti (např. upravovat záznamy atp.)
- pro autentizaci byste měli umět využít jednoduchou HTTP autentifikaci a také lokální přihlašování uživatelů s ověřením dle údajů v databázi
    - hesla vždy ukládáme hashovaně
    - informaci o přihlášení uživatele ukládáme do ```$_SESSION```
- autorizaci obvykle řešíme systémem rolí
    - buď je ověřujeme přímo u jednotlivých činností,
    - nebo využíváme systém oprávnění k jednotlivým definovaným zdrojům (což je vhodnější pro větší aplikace)

:point_right:
    
Ohledně **posílání mailů** byste měli vědět, že:
- pro jednoduché poslání mailu je možné použít funkci ```mail()```
- pro posílání složitějších mailů, mailů s přílohami atp. je vhodné použít nějakou knihovnu, např. ```PHPMailer```            

---

:point_right:

**Na tomto cvičení nás čeká:**
- [práce s datem a časem](#pr%C3%A1ce-s-datem-a-%C4%8Dasem)
- [víceuživatelský přístup k databázi](#v%C3%ADceu%C5%BEivatelsk%C3%BD-p%C5%99%C3%ADstup-k-datab%C3%A1zi)
- strukturované datové formáty
    - [JSON](#json)
    - [XML](#xml)
- [zadání domácího úkolu](#dom%C3%A1c%C3%AD-%C3%BAkol)

---

## Práce s datem a časem
:point_right:

S datem a časem se setkáváme ve větším množství případů, než by se mohlo na první pohled zdát. V každém redakčním systému máme zobrazenou informaci o poslední změně článku, e-maily a objednávky mají své datum odeslání, ale např. také ban, který dostaneme na diskusním fóru, má své datum vypršení. Je tedy nezbytné, abychom se seznámili s tím, jak s datem a časem pracovat z PHP.

:point_right:

- pro práci s datem a časem máme v PHP na výběr 2 varianty:
    1. funkce, se kterými můžeme pracovat s konkrétními hodnotami časových údajů (např. funkce ```date()```)
    2. objektový přístup, ve kterém jsou časové údaje instancemi tříd (např. ```DateTime```, ```TimeInterval``` atd.)
- existuje celá řada způsobů formátování data a času do čitelné podoby
    - pro zobrazení uživatelům bychom měli volit takový formát, který pro něj přirozený (např. u nás je příjemnější si přečíst datum *22.4.2020*, než *2020-04-22*)
    - pro specifické případy (např. cookies, rss atp.) existují předdefinované tvary zápisu data, ale jinak si můžeme datum naformátovat dle svého uvážení
- nezapomeňte, že s datem a časem jde pracovat i přímo v SQL dotazech
    - pokud např. chceme vybrat z databáze články, které se změnily v posledním týdnu, napíšeme daný posun času přímo do SQL - rozhodně tedy nenačítáme všechny články do PHP, abychom je teprve poté filtrovali
    
:point_right:

***Základní funkce pro práci s datem a časem**         

Pro základní práci s datem a časem si ve většině případů vystačíme dokonce jen se třemi funkcemi. Pojďme se na ně podívat:

```php
//funkce time() nám vrací aktuální timestamp (počet sekund od 1.1.1970)
$timestamp = time(); 

//timestamp je číslo, můžeme tedy s ním tak pracovat
$timestampPred5Minutami = $timestamp - 5*60;

//funkce pro převod řetězce obsahujícího datum a čas na timestamp (tuto funkci používáme např. pro převod datumu získaného z SQL dotazu)
$timestamp = strtotime('2020-04-22 10:00:00');

//funkce pro naformátování data do požadovaného tvaru
echo date('d.m.Y H:i:s', $timestamp);
```
***Objektový přístup k datu a času***

Objekty představující časové údaje používáme zejména v případě, kdy chceme používat kontrolu datových typů u funkcí/metod, nebo používáme objektově-relační mapování při ukládání dat do databáze.

```php
//vytvoření objektu DateTime s hodnotou aktuálního data a času
$date = new DateTime();

//výpis naformátovaného data
echo $date->format('d.m.Y');

//vytvoření DateTime z naformátovaného řetězce
$date = DateTime::createFromFormat('Y-m-d', '2020-04-22');
``` 

:point_right:

Funkcí i tříd pracujících pro práci s datem a časem existuje poměrně velké množství, podrobněji si je představíme v následujících 2 ukázkových příkladech. 

:blue_book:
- TODO
- [funkce date() v PHP manuálu](https://www.php.net/manual/en/function.date.php)
- [Class DateTime v PHP manuálu](https://www.php.net/manual/en/class.datetime.php)
- [PHP Date/Time Functions na w3schols.com](https://www.w3schools.com/php/php_ref_date.asp)

## Víceuživatelský přístup k databázi
:point_right:

Webové aplikace jsou samozřejmě určeny pro větší množtví uživatelů, kteří je mohou používat ve stejný čas. Otázka, kterou si ale musíme při tvorbě aplikace položit, je ta, zda mohou uživatelé upravovat stejná data (např. administrátoři e-shopu mohou spravovat zboží, objednávky atp.), či nikoliv (např. každý uživatel může upravovat svůj profil).

V případě, že existuje riziko, že bude chtít najednou upravovat více uživatelů jedna a ta samá data, měli bychom v aplikaci implementovat **zamykání záznamů**.

### Typy zámků 
:point_right:

V aplikaci můžeme využít buď optimistické, nebo pesimistické zamykání záznamů. Vybereme si z nich podle toho, zda očekáváme, že každý uživatel, který si data otevře k úpravě, nějakou úpravu opravdu provede.
Pojďme si je tedy blíže představit.

:point_right:

#### Optimistic lock = optimistické zamykání
Více uživatelů může najednou začít upravovat stejný záznam, ale očekáváme, že jej většina z nich neuloží (např. záznam ve sdíleném adresáři).

Postup:
1. při otevření záznamu pro úpravu si zapamatujeme datum a čas jeho poslední změny
2. v okamžiku uložení změněného záznamu zkontrolujeme, jestli se náš uložený datum a čas poslední změny shodují s datem a časem, kdy byl záznam opravdu naposledy upraven
    - pokud v mezičase došlo ke změně, data neuložíme, ale upozorníme uživatele na tuto změnu

:point_right:

#### Pessimistic lock = pesimistické zamykání
Očekáváme, že téměř každý uživatel, který si otevře záznam k úpravě, jej opravdu upraví. (např. stránku v CMS) V okamžiku otevření záznamu k úpravě jej tedy pro ostatní uživatele uzamkneme a nedovolíme jim jej začít upravovat. Ostatní uživatelé musí počkat, než dokončíme editaci.

Postup:     
1. při otevření záznamu pro úpravu si k němu do databáze uložíme ID uživatele, který začal záznam upravovat, a také aktuální datum a čas (pro časové omezení platnosti zámku)
2. pokud se záznam pokusí otevřít pro úpravu jiný uživatel, ověříme, jestli je stále platný u něj uložený zámek
    - pokud ano, neumožníme uživatel záznam pro úpravu otevřít)
3. při ukládání záznamu zkontrolujeme, zda není záznam uzamčen pro jiného uživatele (např. po časovém vypršení našeho vlastního zámku)
4. při uložení záznamu či potvrzení zrušení jeho úpravy smažeme u daného záznamu informace o uživateli a čas zamčení daného záznamu 

### Ukázková aplikace se zamykáním záznamů
:point_right:

Pro ukázku použití zamykání záznamů při víceuživatelském přístupu se podívejme na další verzi aplikace jednoduchého e-shopu, která v tomto případě jak optimistickým, tak také pesimistickým zámkem při editace zboží.
- stejně jako ve verzi z minulého cvičení využívá aplikace autentizaci uživatelů dle údajů v databázi, informace o přihlášení je uložena v session
- oproti minulému cvičení je i administrátor ověřován podle údajů v databázi
    - pro testování je v aplikaci připraven uživatel s e-mailem ```admin@eshop.tld``` a heslem ```admin```, ale příslušnou roli můžete v databázi přidat i libovolnému jinému uživateli 
- aplikace nemá ošetřené vstupy (prázdné heslo atp), pouze zamezuje SQL inject útoku - DIY :)   

Zkuste si tuto aplikaci spustit a projděte si okomentované zdrojové kódy.

:blue_book:
- postup zprovoznění ukázkové aplikace:
    1. stáhněte si celou složku aplikace ([09-app-eshop](./09-app-eshop)) a nahrajte ji na server
    2. nahrajte do MariaDB [strukturu databáze](./09-app-eshop/09-schema.sql) (pozor, schéma není stejné jako u předchozí verze e-shopu)
    3. nahrajte do MariaDB [ukázková data](./09-app-eshop/09-data.sql)
    4. nastavte vlastní xname a heslo k databázi v souboru [db.php](./09-app-eshop/db.php)
- část pro nepřihlášeného uživatele/databázová autentizace:
    - [signup.php](./09-app-eshop/signup.php) - registrace nového uživatele, ukázka práce s funkcí password_hash
    - [signin.php](./09-app-eshop/signin.php) - přihlášení existujícího uživatele, ukázka práce s funkcí password_verify
- část pro autorizaci a autentizaci:
    - [user required.php](./09-app-eshop/user_required.php) - soubor pro require, vynucení přihlášení uživatele, autentizace uložená v SESSION
    - [admin required.php](./09-app-eshop/admin_required.php) - soubor pro require, ověřuje, zda je přihlášený uživatel v roli "admin" (jde vlastně o rozšíření souboru user_required.pph)    
- část pro přihlášeného uživatele:
    - [index.php](./09-app-eshop/index.php) - výpis zboží v e-shopu
    - [buy.php](./09-app-eshop/buy.php) - přidání zboží do košíku podle jeho ID
    - [cart.php](./09-app-eshop/cart.php) - výpis zboží přidaného do košíku
    - [remove.php](./09-app-eshop/remove.php) - smazání zboží z košíku
    - [signout.php](./09-app-eshop/signout.php) - odhlášení, zruší session
- část pro administátora:
    - [new.php](./09-app-eshop/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi
    - [delete.php](./09-app-eshop/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi
    - [update_optimistic.php](./09-app-eshop/update_optimistic.php) - **úprava zboží v e-shopu s optimistickým zamykáním záznamů**
    - [update_pessimistic.php](./09-app-eshop/update_pessimistic.php) - **úprava zboží v e-shopu s pesimistickým zamykáním záznamů** 

:point_right:
*Otázky k zamyšlení:*
- *Musíme zamykání záznamů použít vždy? Kdy ano a kdy ne?*
- *Ukázka optimistického zamykání [update optimistic](./09-app-eshop/update_optimistic.php) používá předání data a času poslední editace přes formulářové hidden pole. Tato data však mohou být při odeslání formuláře změněna/podstrčena uživatelem. Jak se jde proti tomu bránit? Má smysl to ošetřovat? Kdy ano/ne?*

## JSON a XML
:point_right:

- Většina byť jen trochu složitějších aplikací potřebuje pro svoji funkčnost komunikovat s dalšími aplikacemi, či například podporovat export dat.
    - chceme exportovat seznam objednávek, stáhnout fakturu, naimportovat kontakty, stáhnout data z cizí aplikace atp.
- Pro komunikaci se obvykle používají strukturované formáty.
    - nejčastěji tím myslíme [XML](#xml) a [JSON](#json) 
    - kromě toho ale existují i další formáty - např. CSV, které známe již ze [2. cvičení](../02-retezce-soubory)

### JSON
:point_right:
- = jednoduchý formát odvozený od zápisu objektů v jazyce JavaScript (*JavaScript Object Notation*)
- výhody:
    - podporují ho v podstatě všechny moderní jazyky
    - jde o datově úsporný formát
    - jednoduchý i při ručním vytváření
- nevýhody:
    - není standartní mechanismus kontroly dat - je nutné kontrolovat v rámci zpracovávající aplikace
    - existuje [json schema](http://json-schema.org), ale není moc podporované a využívané
    - nepodporuje jmenné prostory a vícenásobné definice prvků se stejným jménem

**Příklad JSONu:**    
```json
{
    "10":{
        "jmeno":"Josef",
        "prijmeni":"Novák",
        "email":["josef.novak@nekde.cz","josef.novak@nikde.com"]
    },
    "12":{
        "jmeno":"Eva",
        "prijmeni":"Adamová"
    }
}
```

:point_right:

#### Práce s JSONem z PHP
- **json_encode($data, $options)**
    - funkce pro zakódování pole, objektu atd.
    - pomocí ```$options``` jdou ovlivnit vlastnosti konverze - viz [json_encode v PHP manuálu](http://php.net/manual/en/function.json-encode.php)
- **json_decode($json, $assoc=false)**
    - funkce pro dekódování JSONu
    - vrací asociační pole nebo objekt (dle nastavení 2. parametru)
- Interface **JsonSerializable**
    - pro převod objektů do JSONu jsou ve výchozím stavu serializovány všechny properties
    - serializaci je možné ovlivnit implementováním rozhraní JsonSerializable (funkce **jsonSerialize()**)

```php
$data = ['jmeno'=>'Josef','prijmeni'=>'Novák'];
$json = json_encode($data); //funkce pro vytvoření JSONu z pole

$data2=json_decode($json, true); //funkce pro dekódování JSONu (vrací asociační pole)
```

:blue_book:
- [příklad json_encode(), json_decode()](./09-json/json_encode_decode.php)
- [příklad JsonSerializable](./09-json/jsonserializable.php)

### XML
:point_right:

- značkovací jazyk využívaný pro záznam dokumentů o volitelné struktuře
- jde o obecný jazyk, z něhož jsou odvozeny konkrétní formáty používané pro konkrétní účely
    - dnes se s ním setkáme téměř všude
    - xHTML, docx, xlsx, isdoc, rss...
- každé XML by mělo být vytvářeno dle konkrétního schématu
    - schéma = popis, jaké značky mohou být v dokumentu použity a jaké jsou jejich hodnoty
- výhody:
    - jasně definovaná struktura, snadno kontrolovatelná standartními mechanismy (dle schématu)
    - podpora ve všech rozumných programovacích jazycích (ale ne vždy je to zcela jednoduché)
    - možnost XSL transformací
    - možnost kombinovat větší množství jmenných prostorů
- nevýhody:
    - pro jednoduchou výměnu dat je XML zbytečně "ukecané" - i v následujícím příkladu značky zabírají větší množství znaků, než samotný obsah
    - v případě velkých dokumentů náročné na paměť (při zpracování DOM parserem - tj. procházení v podobě stromu)

**Příklad XML:** 
```xml
<?xml version='1.0' encoding='UTF-8'?>
<osoby>
    <osoba id="10">
        <jmeno>Josef</jmeno>
        <prijmeni>Novák</prijmeni>
        <email>josef.novak@nekde.cz</email>
        <email>josef.novak@nikde.com</email>
    </osoba>
    <osoba id="12">
        <jmeno>Eva</jmeno>
        <prijmeni>Adamová</prijmeni>
    </osoba>
</osoby>
```

:point_right:

#### Práce s XML z PHP
- v PHP máme k dispozici několik parserů, které umí pracovat s XML dokumenty
    - DOM přístup (procházení dle uzlů stromu)
        - [SimpleXML](http://php.net/manual/en/book.simplexml.php) (SimpleXMLElement)
        - [DOM Parser](http://php.net/manual/en/class.domdocument.php) (DOMDocument)
    - SAX přístup ("proudové" zpracování - vhodné pro hodně velké dokumenty)
        - [XMLReader](http://php.net/manual/en/xmlreader.open.php)
        - [Expat parser](http://www.w3schools.com/php/php_xml_parser_expat.asp)
- **pro většinu případů doporučuji použít SimpleXML**
    - jednoduchý objektový přístup ke XML dokumentu
        - co vnořená značka, to vnořený objekt
        - k atributům přistupujeme jako k prvkům pole
    - lze jej využít pro čtení i zápis XML dokumentu
    - objekty jsou vzájemně převoditelné s DOM Parserem
        - toto využijeme pro složitější manipulace např. s pořadím elementů, které SimpleXML neumí
    - pozor, SimpleXML tak trochu ignoruje jmenné prostory (což nám pro většinu běžné práce nevadí, ale existují i dokumenty, ve kterých jsou elementy z více jmenných prostorů)

```php
$xml = simplexml_load_string($data);
if (!empty($xml->osoba)){
  foreach($xml->osoba as $osoba){
    echo (string)$osoba['id'];
    echo ': ';
    echo (string)$osoba->jmeno;
    echo ' ';
    echo (string)$osoba->prijmeni;    
  }
}
```

:blue_book:
- [příklad SimpleXML](./09-xml/simplexml.php)
- [příklad DOMDocument](./09-xml/domdocument.php)
- [příklad validace](./09-xml/validace.php)
- [příklad XSL transformace](./09-xml/transformace.php)
- [příklad RSS čtečka](./09-xml/rss-reader.php)

## Domácí úkol
:house:
> Domácí úkol vychází z ukázkového e-shopu ve verzi, na které jsme si na dnešním cvičení vysvětlovali zamykání záznamů při víceuživatelském přístupu.
>
> **Nezbytná příprava:**
> 1. stáhněte si [zdrojové kódy](./09-app-eshop)
> 2. nahrajte zdrojový kód aplikace na server eso.vse.cz
> 3. naimportujte do databáze [export struktury databáze](./09-app-eshop/09-schema.sql) i [ukázková data](./09-app-eshop/09-data.sql)
>
> **Váš úkol:**
>
> Upravte řešení optimistického zamykání záznamů (v souboru [update_optimistic.php](./09-app-eshop/update_optimistic.php)) tak, aby aplikace při zjištění konfliktu zobrazila změněná data a zeptala se uživatele, zda si je přeje přepsat daty svými.
>
> **Způsob a termín odevzdání:**
>
> Vytvořenou aplikaci nahrajte na server eso.vse.cz a zašlete mi odkaz na ni na e-mail stanislav.vojir@vse.cz nejpozději do 1. 5. 2020 23:59.