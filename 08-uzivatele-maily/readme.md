# 8. Uživatelé, maily

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičením 16. a  17. 4. 2020.**
Oproti běžným podkladům ke cvičením zde naleznete podrobnější vysvětlení dané problematiky a další příklady.

## Opakování z předchozích cvičení

:point_right:

Ve cvičení 06 jsme se zabývali prací s databází a uložením dat v session a cookies. Tyto znalosti poté byly využity v ukázkovém příkladu ve cvičení 07, ve kterém jsme začali s přihlašováním uživatelů.

:point_right:

Ohledně **session** byste si měli pamatovat:
- session slouží k uložení dat, která chceme uchovat na serveru mezi jednotlivými požadavky uživatele (např. přihlášení či položky v košíku)
- pro spuštění session je nutné zavolat funkci ```session_start()```
- následně máte session data k dispozici v globálním poli ```$_SESSION```
- do session jde uložit libovolná serializovatelná data (řetězce, čísla, pole, serializovatelné objekty)
- pro identifikaci konkrétního uživatele se používá kód, který je u uživatel uložen v cookie

:point_right:

Ohledně **uživatelských účtů** jsme zatím nastínili, že:
- pro přihlašování přímo na daném webu používáme obvykle kombinaci jména či mailu a hesla
- heslo nikdy neukládáme do databáze v čitelné podobě!
- k hashování hesel jsme použili funkci ```password_hash``` a pro ověření hesla při přihlášení pak funkci ```password_verify```
- informaci o přihlášeném uživateli ukládáme v session

### Kontroly formulářů  

:point_right:

Na předchozích cvičeních jsme se zabývali také kontrolami formulářů. S ohledem na opakující se připomínky a následné dotazy k těmto kontrolám si připomeňme, že:
- tam, kde je to možné, je vhodné do formuláře zapsat kontroly v HTML 5 (a případně v javascriptu),
- bez ohledu na kontroly uvedené v předchozím bodu je nutné mít kontroly i na straně PHP (a kontrolovat je nutné i např. položky vybírané ze selectu),
- chybové hlášky musí uživateli konkrétně říct, co má opravit,
- ve formuláři musí zůstat vyplněná aspoň data, která byla správně (aby je uživatel nemusel vyplňovat znovu).  

:point_right:

Část z vás si stále ještě není jistá, jak ověřit funkčnost kontroly v PHP, když chybu odchytí už prohlížeč. Máme na výběr 2 varianty:
- pracnější varianta: z formuláře ty kontroly v HTML 5 a javascriptu dočasně odstraníme;
- rozumnější varianta: dočasně danou stránku upravíte ve formuláři:
    1. kliknete pravým tlačítkem myši na vybrané pole a zvolíte prozkoumat/inspect
    2. kontrolu hodnot atp. odstraníme v rámci vývojářské konzole (jde tak např. dopsat i chybnou hodnotu do selectu atp.).  

### Řešení domácího úkolu s e-shopem

:house:

V rámci [domácího úkolu](../06-session-cookies#dom%C3%A1c%C3%AD-%C3%BAkol) odevzdávaného do 10. 4. 2020 bylo vaším úkolem aplikaci nejen spustit někde na serveru, ale také ji rozšířit o možnost mít v košíku více kusů od každého druhu zboží.
Ačkoliv jsou domácí úkoly již opraveny, je vhodné, abychom si alespoň nastínili, jak mohlo vypadat jeho vypracování.

:point_right:

Měli bychom se snažit o to, aby aplikace byla uživatelsky přívětivá. K tomu by mělo platit, že
- pokud mám v košíku víc kusů u jednoho zboží, bude dané zboží jen na jednom řádku a budu tam mít uvednou informaci o počtu kusů, ceně za kus a celkové ceně za daný typ zboží;
- když už mám v košíku položku X a poté chci zase do košíku přidat položku X, tak se počet kusů v košíku zvýší;
- z košíku můžu odebrat i jen jeden kus zboží X, ne ho nutně odebrat všechno;
- když se počet kusů zboží X sníží na 0, zboží z košíku úplně zmizí.

Pokud bychom šli v uživatelské přívětivosti o něco dále:
- v košíku by mělo jít měnit počet kusů zboží
    - šlo to realizovat nejen klasickým formulářem, ale také např. pomocí odkazů **+** a **-**
- při koupi zboží je hezké mít možnost vložit do košíku např. 10 kusů zboží X a nemuset je klikat jednotlivě.

#### Jak to realizovat v rámci session?
:point_right:

- v SESSION bude zboží uložené jen v 1 poli (např. v ```$_SESSION['cart']```)
- nejjednodušší variantou je to, abychom dané pole indexovali pomocí IDček zboží a jako hodnoty tam měli počet kusů.    

```php
//ukázka možného přidání zboží do košíku
if (isset($_SESSION['cart'][$idZbozi])){
  $_SESSION['cart'][$idZbozi]++;
}else{
  $_SESSION['cart'][$idZbozi]=1;
}

//ukázka odebrání zboží z košíku
if (isset($_SESSION['cart'][$idZbozi])){
  if ($_SESSION['cart'][$idZbozi]>1){
    $_SESSION['cart'][$idZbozi]--;
  }else{
    unset($_SESSION['cart'][$idZbozi]);
  }
}
```

#### Na co nezapomenout?
:point_right:

Pokud máme v aplikaci formulářové pole či odkazy na přidávání/odebírání kusů zboží, nesmíme zapomenout na kontroly. Aplikace by neměla připustit, abychom do košíku dostali záporný počet kusů.

Máme-li změnu realizovanou např. pomocí odkazu, tak to, že při 0 položkách daný odkaz nezobrazíme, ještě neznamená, že nám uživatel na server daný požadavek nepošle!

---

:point_right:

**Na tomto cvičení nás čeká:**
- [práce s uživatelskými účty](#u%C5%BEivatelsk%C3%A9-%C3%BA%C4%8Dty)
- [oprávnění uživatelů](#opr%C3%A1vn%C4%9Bn%C3%AD-u%C5%BEivatel%C5%AF)
- [ukázkový e-shop s přihlašováním uživatelů](#uk%C3%A1zkov%C3%A1-aplikace-s-u%C5%BEivatelsk%C3%BDmi-%C3%BA%C4%8Dty)
- [posílání e-mailů](#pos%C3%ADl%C3%A1n%C3%AD-e-mail%C5%AF)
- [zadání domácího úkolu](#dom%C3%A1c%C3%AD-%C3%BAkol) (za maximálně 3 body)

---

## Uživatelské účty
:point_right:

Příklad s uživatelskými účty jsme trochu nakousli už u [aplikace Nástěnka](../07-ukazkova-aplikace#u%C5%BEivatelsk%C3%A9-%C3%BA%C4%8Dty), ale je nutné, abychom to probrali podrobněji.

Nejprve si projdeme trochu nezbytné teorie a poté se podíváme na praktický příklad.

### Autentizace vs. autorizace
:point_right:

V souvislosti s uživatelskými účty a oprávněními uživatelů se velmi často setkáváme s termíny *autentizace* a *autorizace*. Oba se vztahují k tomu, jestli může daný uživatel s naší aplikací provádět nějaké operace, ale každý znamená trošku něco jiného.

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

### Metody autentizace uživatelů
:point_right:


TODO

### Hashování hesel
:point_right:

TODO

### HTTP autentizace
:point_right:

TODO

### Lokální přihlašování uživatelů
:point_right:

TODO

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

Příklad na ověřování oprávnění uživatelů pomocí zdrojů a rolí si [ukážeme za týden](../09-uzivatele-db-json-xml).
 

## Ukázková aplikace s uživatelskými účty
:point_right:

Pro ukázku použití uživatelských účtů a možnosti rozlišení uživatelských rolí se podívejme na další verzi aplikace jednoduchého e-shopu, která v tomto případě disponuje možnostmi autentizace a autorizace uživatelů.
- aplikaci může používat jen přihlášený uživatel
    - nepřihlášený uživatel je automaticky přesměrován na přihlašovací stránku [signin.php](./08-app-eshop/signin.php)
    - ověření je v souboru [user_required.php](./08-app-eshop/user_required.php)
    - údaje o přihlášeném uživateli uchováváme v session
- jen admin může měnit nabídku zboží
    - pro přihlašování administrátorů je využívána HTTP autentifikace
- pplikace nemá ošetřené vstupy (prázdné heslo atp), pouze zamezuje SQL inject útoku - DIY :)   

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
    - [index.php](./08-app-eshop/index.php) - výpis zboží v e-shopu.
    - [buy.php](./08-app-eshop/buy.php) - přidání zboží do košíku podle jeho ID
    - [cart.php](./08-app-eshop/cart.php) - výpis zboží přidaného do košíku
    - [remove.php](./08-app-eshop/remove.php) - smazání zboží z košíku
    - [signout.php](./08-app-eshop/signout.php) - odhlášení, zruší session
- část pro administátora:
    - [new.php](./08-app-eshop/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi.
    - [delete.php](./08-app-eshop/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi.
    - [update.php](./08-app-eshop/update.php) - úprava zboží v e-shopu. 

:point_right:

Výzva k zamyšlení:
- *Zvládli byste předělat aplikaci tak, aby se i administrátoři přihlašovali normálně a ne pomocí HTTP autentifikace?*

## Posílání e-mailů

### K čemu je dobré posílání mailů z PHP?
:point_right:

S posíláním mailů z PHP se setkáme v celé řadě aplikací. Jako příklady můžeme jmenovat:
- v návaznosti na uživatelské účty např. pro poslání odkazu pro potvrzení platnosti e-mailové adresy či pro změnu hesla,
- potvrzení objednávky z e-shopu,
- zasílání novinek na webu pro odběratele,
- upozornění administrátora na chybu v aplikaci.

### Co bychom naopak rozhodně dělat neměli?
:point_right:

- Neměli bychom posílat spam - tj. např. reklamy a novinky uživatelům, kteří si je výslovně nevyžádali.
- Rozhodně bychom neměli posílat maily, ve kterých se vydáváme za někoho jiného!


### Jak e-mail odeslat?
:point_right:

- Přímo v PHP najdeme funkci ```mail()```, která umí e-mail odeslat prostřednictvím unixového nástroje sendmail - tj. funguje na většině serverů.
- Funkce ```mail()``` je ale poměrně hloupá - respektive řeší jen odeslání, ale ne sestavení e-mailu.
    - Hodí se ale např. pro jednoduché posílání notifikací administrátorům.
    - Upozornění: Na serveru eso.vse.cz funguje posílání e-mailů jen na školní adresy. 
- Pro složitější e-maily a posílání mailů např. přes jiný SMTP server obvykle použíme odpovídající knihovny.
    - jako univerzální knihovnu doporučuji **PHPMailer**
        - jednoduchá, srozumitelná knihovna umožňující poslat např. HTML mail s přílohami nejen sendmailem, ale i přes SMTP server
        - je použita také v dalších řešeních, např. ve WordPressu
        - instalace nejjednodušeji pomocí composeru
    - ve většině PHP frameworků jejich vlastní řešení pro posílání e-mailů, přičemž v některých případech jej můžeme použít i mimo framework 

Poslání mailu funkcí mail:
```php
mail($to, $subject, $message, $headers);//hlavičky jsou volitelné, ale je nutné do nich zadat např. info o odesílateli...
```

:blue_book:

Příklad a podklady:
- [Příklad mail()](./08-funkce-mail/mail-plaintext.php)
- [Příklad mail() - HTML verze](./08-funkce-mail/mail-html.php)
- [Příklad PHPMailer](./08-phpmailer/example.php)
- [Příklad PHPMailer s přílohou](./08-phpmailer/example-with-attachment.php)
- [Funkce mail() na w3schools.com](https://www.w3schools.com/php/func_mail_mail.asp)
- [Informace ke knihovně PHPMailer](https://github.com/PHPMailer/PHPMailer)

:blue_book:

Řešení pro posílání mailů ve frameworcích:
- [Nette\Mail](https://framework.zend.com/manual/2.1/en/modules/zend.mail.introduction.html)
- [Symfony\Mailer](https://symfony.com/doc/current/mailer.html)
- [Zend\Mail](https://framework.zend.com/manual/2.1/en/modules/zend.mail.introduction.html)

### Posílání velkého množtví e-mailů
:point_right:

Pokud budete chtít z webu např. rozesílat newsletter či jinou formu reklam většímu množství uživatelů, či jen máte na serveru velký provoz např. v e-shopu, je vhodnější místo výchozího SMTP serveru použít nějaké řešení v podobě SaaS.
- na managed hostingu vám pak nevypnou základní posílání mailů
- nebudete muset tak moc řešit, zda nejste na spamovém blacklistu, škálování, balancování apt.
- Pozor, většina normálních e-mailových schránek (např. gmail) má limit na počet odeslaných zpráv - tj. nemůžete je používat pro rozesílání velkého množství mailů, i když se k nim zvládnete přihlásit přes SMTP.

Příklady SMTP serverů jako SaaS:
- [Amazon SES](https://aws.amazon.com/ses/) - SMTP jako SaaS, pod Amazon Web Services (levný, spolehlivý)
- [Sendgrid](https://sendgrid.com/) - další SMTP server jako SaaS, velké objemy (i miliony mailů měsíčně; drahý, ale spolehlivý)
- [MailChimp](http://mailchimp.com/) - kompletní odesílání mailů jako SaaS (tvorba šablon, WYSIWYG editor, plánovač odesílání, tracking doručení i přečtení mailu příjemcem, garantuje doručení, velmi drahý)

:point_right:

Otázka k zamyšlení: *Jak lze poznat, že uživatel dostal do schránky mail, nebo si ho dokonce přečetl?*

## Domácí úkol
:house:
> Domácí úkol vychází z ukázkové aplikace **Nástěnka s uživatelskými účty**, kterou jsme vytvářeli na Velikonočním cvičení.
>
> **Nezbytná příprava:**
> 1. pokud jste ji zatím neviděli, prohlédněte si [prezentaci s postupem implementace přihlašování uživatelů](../07-ukazkova-aplikace/07-nastenka-uzivatele/prezentace-nastenka-uzivatele.pptx) :orange_book:
> 2. stáhněte si [zdrojové kódy](../07-ukazkova-aplikace/07-nastenka-uzivatele)
> 3. nahrajte zdrojový kód aplikace na server eso.vse.cz
> 4. naimportujte SQL export do databáze 
>
> **Vaším úkolem je:**
>
> - **doplnit do aplikace rozlišení rolí uživatelů - budeme rozlišovat běžné uživatele a administrátory** *(0,5 bodu)*
>   - stačí jeden vhodný sloupec v DB, při registraci je uživatel automaticky v roli běžného uživatele
>   - žádnou stránku pro administraci uživatelů dělat nemusíte 
> - **administrátoři mohou upravovat a mazat všechny příspěvky, běžní uživatelé jen příspěvky vlastní** *(1 bod)*
> - **pro administrátory doplňte možnost přidávat, upravovat a odebírat kategorie, ve kterých jsou příspěvky zařazeny** *(1,5 bodu)*
>   - při smazání kategorie můžete smazat všechny do ní zařazené příspěvky, neřešte jejich převod do jiné kategorie
>   - ideálně to bude nějaká samostatná stránka, na kterou budou mít přístup jen administrátoři (a také na ni jen oni uvidí odkaz z hlavní stránky aplikace)
>
> **Způsob a termín odevzdání:**
>
> Vytvořenou aplikaci nahrajte na server eso.vse.cz a zašlete mi odkaz na ni na e-mail stanislav.vojir@vse.cz nejpozději do 24. 4. 2020 23:59. 