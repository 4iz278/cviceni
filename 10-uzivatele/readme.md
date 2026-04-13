# 8. Uživatelské účty
U velkého množství aplikací potřebujeme, aby konkrétní požadavky mohli posílat jen uživatelé, které k tomu mají oprávnění. Např. aby nám obsah webu nemohl v administraci přepsat každý, kdo si jej načte.

## Autentizace vs. autorizace
:point_right:

V souvislosti s uživatelskými účty a oprávněními uživatelů se velmi často setkáváme s termíny *autentizace* a *autorizace*. Oba se vztahují k tomu, zda může daný uživatel provádět určité operace, ale každý znamená trošku něco jiného.

:point_right:

**Autentizace**
- jde o identifikaci uživatele (např. jeho přihlášení)
- *autentizace* (z angličtiny) = *autentifikace* (asi z francouzštiny :) = *authentization* = kdo jsem = zjištění totožnosti uživatele
- analogie s řidičským průkazem: Kdo je řidič? Jméno, příjmení, fotka. Pokud nás zastaví, zda jsme to my.
- uživatele můžeme identifikovat řadou různých způsobů - viz [dále](#metody-autentizace-u%C5%BEivatel%C5%AF)

:point_right:

**Autorizace**
- jde o ověření, zda může uživatel provést v naší aplikaci nějakou operaci (např. upravit danou stránku)
- analogie s řidičským průkazem: Když nás zastaví na Harley, máme na řidičáku skupinu A?
- nejčastěji řešíme oprávnění formou uživatelských rolí (jednou či několika pro každého uživatele)
    - např. administrátor může v e-shopu upravovat zboží, přihlášený uživatel si ho může koupit, nepřihlášený jen prohlížet
- oprávnění uživatelů by měla vyplývat z analýzy případů použití (use-case model)
- [podrobněji k autorizaci](#opr%C3%A1vn%C4%9Bn%C3%AD-u%C5%BEivatel%C5%AF)     

:grey_exclamation:
Autentizace říká *kdo uživatel je*, autorizace říká *co smí dělat*.

### Metody autentizace uživatelů
:point_right:

Existuje celá řada variant, jak ověřit, jestli je daný uživatel tím, za koho se chce vydávat.

Z jednotlivých metod bychom si měli vybrat podle toho, jak moc kritická data naše aplikace obsahuje. Jde o jakýsi kompromis mezi bezpečností a tím, jak moc chceme uživatele obtěžovat.

#### Běžné jednoduché autentizace
:point_right:
- [HTTP autentizace](#http-autentizace)
- [lokální přihlašování ověřené podle údajů v databázi](#lok%C3%A1ln%C3%AD-p%C5%99ihla%C5%A1ov%C3%A1n%C3%AD-u%C5%BEivatel%C5%AF)
- lokální ověření proti autentizačnímu serveru (LDAP, Active Directory od Microsoftu, ...)
- přihlašování pomocí externí služby 
  - např. pomocí Google účtu, účtu na Facebooku atp.
  - v současnosti jde nejčastěji o přihlášení protokolem OAuth, což si ukážeme ve [cvičení 11](../x11-oauth-curl)
  - patří sem také OpenId servery (např. mojeId), přihlašování pomocí Shibbolethu (používané např. v sítích univerzit) atp.
  - uživatele to zbavuje nutnosti pamatovat si další přihlašovací údaje a nás např. nutnosti implementovat dvoufaktorovou autentizaci 
- ideální stav je takový, kdy si uživatel může vybrat mezi lokálním přihlášením a přihlášením pomocí externí služby

:point_right:

#### Vícefaktorová autentizace
:point_right:
- jde o ověření nejen znalosti hesla, ale obvykle také toho, zda uživatel vlastní nějaké zařízení
- patří sem např. přihlašování pomocí certifikátů, zasílání SMS atp.
- populární variantou je zabezpečení přihlašování pomocí autentifikátorů
  - nejčastěji aplikace v mobilu, např. Google Authenticator, Microsoft Authenticator atd.
  - uživatel musí kromě jména a hesla zadat také kód, který se mění cca 1x za minutu
  - pro PHP můžeme využít existující knihovny - např. [sonata-project/google-authenticator](https://github.com/sonata-project/GoogleAuthenticator)

#### Přihlašování pomocí passkeys (bez hesla)
:point_right:
- moderní metoda autentizace založená na kryptografii (standard WebAuthn)
- uživatel se nepřihlašuje heslem, ale např. pomocí otisku prstu, Face ID nebo PINu na zařízení
- přihlašovací údaje jsou bezpečně uloženy v zařízení uživatele či v prohlížeči (ne na serveru)
- odpadá problém s únikem hesel nebo jejich opakovaným používáním
- implementace je složitější, proto se obvykle používají hotové služby nebo knihovny

### Hashování hesel
:point_right:
- Heslo nikdy neuchováváme v databázi ani v kódu aplikace v čitelné podobě!
    - Je zde vždy riziko, že se nám např. k datům v databázi někdo dostane - a v případě nešifrovaných hesel by je pak útočník jednoduše získal.
    - Většina uživatelů nemá pro každou aplikaci (službu) unikátní heslo, ale má jich jen několik, která střídají (v řadě případů dokonce mají např. jen 1 heslo pro banku a jedno jiné pro všechny ostatní služby) => když by útočník zjistil dané heslo z naší aplikace, může ho rozhodně zkusit použít i pro další služby.
- **Místo čitelného hesla ukládáme jeho hash**
    - = jednosměrný otisk dat získaný pomocí známé matematické funkce
    - z hashe nejde přímo zjistit původní heslo, ale dá se zjistit jiný řetězec, který má stejný hash
    - jelikož nejde z hashe nejde získat původní heslo, nemůže nám ho aplikace při obnově zapomenutého hesla poslat -> může nám nabídnout jen možnost jeho změny 
- Příklady hashovacích funkcí - MD5, SHA1, SHA256, komplet seznam viz [funkce hash](http://php.net/manual/en/function.hash.php). 
  - pro ukládání hesel nepoužíváme obecné hashovací funkce (např. MD5, SHA1, SHA256), protože jsou příliš rychlé a zranitelné vůči útokům
  - v praxi se sice můžeme setkat se staršími aplikacemi, které tyto funkce používají (často v kombinaci se "solí" (*salt*)), ale pro nové aplikace to není doporučený postup 
      
:point_right:

#### Solení hesel
- jde o způsob, jak i z jednoduchého hesla udělat složitější
- **salt (sůl)** = náhodná data, která jsou přimíchána do výsledného hashe (nebo uložena bokem) z původních dat
- smyslem je zamezit útokům pomocí tzv. **rainbow table (duhová tabulka)** - tzv. reverzní hashing = předvypočtené seznamy výsledků hashovacích funkcí, ze kterých lze odvodit původní vstupní data = ideální pro zjištění hesla, pokud se útočník nějak dostane k hashům
- Co si pod tím představit v praxi?
    - Uživatel nám zadal heslo "heslo" -> přidáme do něj nějaký další (ideálně náhodný) řetězec, tzv. sůl - výsledkem může být např. "he78D/4slo" -> tento řetězec zahashujeme a výsledek uložíme, včetně přimíchaného řetězec "78D/4" (ten můžeme např. připojit k hashi)
    - Při přihlášení uživatele provedeme stejnou operaci s jediným rozdílem - sůl negenerujeme náhodně, ale získáme ji z místa, kam jsme si ji uložili. A výsledky následně porovnáme.
- nemusíme to dělat ručně, výchozí funkce pro práci s hesly to celé umí udělat i automaticky
- pokud hesla solíme, můžeme použít i jinak ne zrovna bezpečnou hashovací funkci (např. wordpress také používá funkci md5 s přimícháním soli)     
- v PHP to buď vyřeší funkce ```password_hash()``` a ```password_verify()```, nebo příslušná část použitého frameworku
 
## HTTP autentizace
:point_right:

- = metoda autentizace, která je definována přímo v protokolu HTTP
- **Jak to funguje?**
    1. aplikace pošle http hlavičky vyžadující autentizaci
    2. prohlížeč zobrazí uživateli univerzální okno pro zadání uživatelského jména a hesla
    3. jméno a heslo zadané uživatelem pak prohlížeč zasílá v každém následujícím požadavku na server (tj. nejen požadavky na PHP skript, ale také na všechny obrázky atp.)
- heslo se na server posílá nešifrované => pro bezpečné použití **musíme být na https!**
- z pohledu uživatele má tato autentizace jednu podstatnou nevýhodu - nedá se z ní jednoduše odhlásit (to lze jen zavřením prohlížeče)
- HTTP autentizace má více forem (Basic, Digest) - obvykle používáme *Basic*
    
:point_right:
- Tato metoda funguje dokonce i mimo vlastní aplikaci (ověření nám pak zajistí např. Apache) => s výhodou lze tuto metodu použít k dočasnému zabezpečení vyvíjené aplikace před tím, než ji budeme chtít spustit veřejně :)
    - pro využití mimo aplikaci stačí v dané složce umístit soubory **.htaccess** a **.htpasswd**   
    
:blue_book:    
- [příklad zabezpečení složky pomocí .htaccess a .htpasswd](10-htpasswd/)
- [příklad HTTP Basic autentifikace v e-shopu](./10-app-eshop/admin_required.php)
- [.htpasswd generator](https://www.web2generators.com/apache-tools/htpasswd-generator)

## Lokální přihlašování uživatelů
:point_right:
- obvykle využíváme kombinaci uživatelského jména či e-mailu a hesla
    - kombinace jména a hesla je o trošku bezpečnější (jde o další údaj, který musí uživatel znát), ale e-mail je z pohledu uživatele pohodlnější 
    - při přihlašování pomocí mailu je uživatelsky přívětivější ignorovat velikost písmen
- u hesla je vhodné vyžadovat alespoň jeho minimální délku, ale neměli bychom to s požadavky přehánět
    - popravdě řečeno např. požadavky na velké a malé písmeno, speciální znak, číslo a alespoň 10 znaků vedou jen k tomu, že si uživatel heslo někam uloží či napíše - rozhodně si ho nebude chtít pamatovat
    - požadavky by měly být přiměřené důležitosti naší aplikace a citlivosti v ní uložených dat
- pokud nenutíme uživatele ověřit při registraci svůj e-mail, tak jej rovnou přihlásíme
  - aby nemusel zbytečně znovu zadávat své přihlašovací údaje, které zadal chvíli před tím při registraci

:point_right:
- po úspěšném přihlášení ukládáme informaci o uživateli do session
    - např. ID uživatele
    - díky tomu víme i při dalších požadavcích, že je uživatel přihlášený
- odhlášení uživatele spočívá ve smazání dat ze session (např. pomocí unset() nebo session_destroy())

### Jak lokální přihlášení realizovat?
:point_right:
V databázi máme tabulku s uživateli, ve které máme kromě loginu či e-mailu také sloupec pro hash hesla (doporučeně varchar o délce max. 255 znaků)

#### Registrace uživatele
:point_right:
- na zadání hesla se zeptáme 2x (abychom odchytili případné překlepy)
- před uložením uživatele ověříme, že daný login/e-mail ještě neexistuje
- heslo zahashujeme funkcí ```password_hash()``` a uložíme do databáze

```php
$login = $_POST['login'];
$passwordHash = password_hash($_POST['password'],PASSWORD_DEFAULT);

//uložení uživatele do DB
$query = $db->prepare('INSERT INTO users (login, password) VALUES (:login, :password)');
$query->execute([
  ':login'=>$login,
  ':password'=>$passwordHash
]);
```

#### Přihlášení uživatele
:point_right:
- podle zadaného přihlašovacího jména či e-mailu vybereme uživatele z databáze
- ověříme platnost zadaného hesla pomocí ```password_verify()```
- pokud nám ověření jména či hesla selže, zobrazíme uživateli jen obecnou hlášku o chybě (je to mezi formuláři jediná výjimka, kdy nechceme zobrazovat konkrétní chybu)
- po přihlášení je vhodné zavolat ```session_regenerate_id()``` (ochrana proti session fixation)
- pro budoucí změnu hashovací funkce je vhodné použít funkci ```password_needs_rehash()```

```php
//nastartujeme session
session_start();

$login = $_POST['login'];
$password = $_POST['password'];

//načteme uživatele z DB
$query = $db->prepare('SELECT * FROM users WHERE login=:login LIMIT 1;');
$query->execute([
  ':login'=>$login,
]);             

if ($user=$query->fetch(PDO::FETCH_ASSOC)){
  if (password_verify($password, $user['password'])){
    //ošetření možné potřeby změny hashe
    if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
      $newHash = password_hash($password, PASSWORD_DEFAULT);
    
      $update = $db->prepare('UPDATE users SET password=:password WHERE id=:id');
      $update->execute([
        ':password' => $newHash,
        ':id' => $user['id']
      ]);
    }
  
    //přegenerujeme ID session
    session_regenerate_id(true);

    //uložíme údaje uživatele do session (tj. přihlásíme ho)
    $_SESSION['id']=$user['id'];
    $_SESSION['login']=$user['login'];
    //úspěšně přihlášeného uživatele přesměrujeme na cílovou stránku
    header('Location: ./');
    exit();
  }
}
//TODO pokud se přihlášení nezdaří, zobrazíme obecnou chybovou hlášku
```

:blue_book:
- [jednoduchý příklad použití funkcí password_hash() a password_verify()](./password_verify.php)
- [funkce password_hash() v PHP manuálu](https://www.php.net/manual/en/function.password-hash.php)
- [funkce password_verify() v PHP manuálu](https://www.php.net/manual/en/function.password-verify.php)

:blue_book:

Příklady přihlašování v ukázkových aplikacích:
- příklad lokálního přihlášení v Nástěnce (podrobněji bylo popsáno [tady](../x07-ukazkova-aplikace#u%C5%BEivatelsk%C3%A9-%C3%BA%C4%8Dty-v-aplikaci-n%C3%A1st%C4%9Bnka))
    - [přihlášení](../x07-ukazkova-aplikace/07-nastenka-uzivatele/login.php)
    - [ověření platnosti přihlášení uživatele](../x07-ukazkova-aplikace/07-nastenka-uzivatele/inc/user.php)
- příklad lokálního přihlášení v e-shopu (podrobněji [popsáno dále](#uk%C3%A1zkov%C3%A1-aplikace-s-u%C5%BEivatelsk%C3%BDmi-%C3%BA%C4%8Dty)):
    - [přihlášení](./08-app-eshop/signin.php)
    - [vynucení přihlášeného uživatele](./08-app-eshop/user_required.php)

## Oprávnění uživatelů
:point_right:

Z hlediska oprávnění uživatelů (tj. jejich autorizace) **potřebujeme vždy ověřit, jestli uživatel může provést danou operaci**.
- Uživateli zobrazujeme v aplikaci jen odkazy a formuláře, které má právo použít (tj. např. v e-shopu běžný uživatel nevidí odkaz na úpravu ceny zboží :)).
- Ověřování provádíme ve všech skriptech, které mají být daným způsobem omezeny.
    - nemusí jít nutně o pokus o hack naší aplikace, ale uživatel se mohl např. odhlásit, ale na další záložce v prohlížeči mu zůstala zobrazená administrace naší aplikace

### Možnosti ověření oprávnění uživatelů
:point_right:

- Nejjednodušší variantou je ověření, zda uživatel je či není přihlášen.
- U nepatrně složitějších aplikací obvykle máme odlišeny administrátory a běžné uživatele - stačí na to 1 boolean hodnota uložená u daného uživatele v DB.    
- Ve složitějších aplikacích obvykle používáme **uživatelské role**.

### Jak pracovat s uživatelskými rolemi?
:point_right:
    
- jednodušší variantou mít v aplikaci jednu sadu vzájemně se rozšiřujících rolí
    - např. v CMS máme role *guest -> autor -> editor -> admin*
    - uživatel pak má obvykle jen 1 roli, kterou u něj máme uloženou v DB ve sloupci v tabulce s uživateli
- složitější variantou je možnost mít více rolí pro každého uživatele
    - uživatel by měl mít práva za všechny příslušné role najednou - nenuťte ho role přepínat!

### Oprávnění k jednotlivým zdrojům
:point_right:
      
Pokud máme rozsáhlejší či objektově psanou aplikaci a nechceme všude vypisovat role, které mají oprávnění provádět danou operaci, je vhodnější mít v aplikaci uložený seznam oprávnění, které se vztahují k jednotlivým rolím.

V praxi to může vypadat tak, že evidujeme identifikátor zdroje a jednotlivé operace. Například:
- v aplikaci máme zdroj **good**
- pro daný zdroj definujeme, jaké operace může provádět která role:
    - admin může provést všechny operace
    - seller má oprávnění k akcím *show*, *create* a *update*
    - guest má oprávnění pouze pro akci *show*
- ověření role pak vypadá tak, že ověříme, jestli aktuální uživatel má např. oprávnění *good-delete* (což dle uvedeného výčtu mohou jen uživatelé s rolí *admin*

:point_right:

**POZOR:** Pokud si píšete ověřování oprávnění sami, doporučuji mít oprávnění definovaná jen kladně (tj. výčet všech operací, které může uživatel provést).
- pokud má uživatel více rolí, tak nám stačí, že oprávnění pro danou operaci má libovolná z jeho rolí. 

:blue_book:

Příklad na ověřování oprávnění uživatelů pomocí zdrojů a rolí si [ukážeme za týden](../x09-uzivatele-db-json-xml).
 

## Ukázková aplikace s uživatelskými účty
:point_right:

Pro ukázku použití uživatelských účtů a možnosti rozlišení uživatelských rolí se podívejme na další verzi aplikace jednoduchého e-shopu, která v tomto případě disponuje možnostmi autentizace a autorizace uživatelů.
- aplikaci může používat jen přihlášený uživatel
    - nepřihlášený uživatel je automaticky přesměrován na přihlašovací stránku [signin.php](./08-app-eshop/signin.php)
    - ověření je v souboru [user_required.php](./08-app-eshop/user_required.php)
    - údaje o přihlášeném uživateli uchováváme v session
- jen admin může měnit nabídku zboží
    - pro přihlašování administrátorů je využívána HTTP autentifikace
- aplikace nemá ošetřené vstupy (prázdné heslo atp), pouze zamezuje SQL inject útoku - DIY :)   

Zkuste si tuto aplikaci spustit a projděte si okomentované zdrojové kódy.

:blue_book:
- postup zprovoznění ukázkové aplikace:
    1. stáhněte si celou složku aplikace ([08-app-eshop](./08-app-eshop)) a nahrajte ji na server
    2. nahrajte do MariaDB [strukturu databáze](./08-app-eshop/08-schema.sql) (pozor, schéma není stejné jako u předchozí verze e-shopu)
    3. nahrajte do MariaDB [ukázková data](./08-app-eshop/08-data.sql)
    4. nastavte vlastní xname a heslo k databázi v souboru [db.php](./08-app-eshop/db.php)
- část pro nepřihlášeného uživatele/databázová autentizace:
    - [signup.php](./08-app-eshop/signup.php) - registrace nového uživatele, ukázka práce s funkcí password_hash
    - [signin.php](./08-app-eshop/signin.php) - přihlášení existujícího uživatele, ukázka práce s funkcí password_verify
- část pro autorizaci a autentizaci:
    - [user required.php](./08-app-eshop/user_required.php) - soubor pro require, vynucení přihlášení uživatele, autentizace uložená v SESSION
    - [admin required.php](./08-app-eshop/admin_required.php) - soubor pro require, vynucení přihlášení administrátora, ukázka HTTP autentizace
- část pro přihlášeného uživatele:
    - [index.php](./08-app-eshop/index.php) - výpis zboží v e-shopu
    - [buy.php](./08-app-eshop/buy.php) - přidání zboží do košíku podle jeho ID
    - [cart.php](./08-app-eshop/cart.php) - výpis zboží přidaného do košíku
    - [remove.php](./08-app-eshop/remove.php) - smazání zboží z košíku
    - [signout.php](./08-app-eshop/signout.php) - odhlášení, zruší session
- část pro administátora:
    - [new.php](./08-app-eshop/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi
    - [delete.php](./08-app-eshop/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi
    - [update.php](./08-app-eshop/update.php) - úprava zboží v e-shopu 

:point_right:

Výzva k zamyšlení:
- *Zvládli byste předělat aplikaci tak, aby se i administrátoři přihlašovali normálně a ne pomocí HTTP autentifikace?*