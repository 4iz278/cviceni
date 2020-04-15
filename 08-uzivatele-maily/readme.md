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

:point_right:

**Jak to realizovat v rámci session?**
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


:point_right:

**Na co nezapomenout?**
Pokud máme v aplikaci formulářové pole či odkazy na přidávání/odebírání kusů zboží, nesmíme zapomenout na kontroly. Aplikace by neměla připustit, abychom do košíku dostali záporný počet kusů.

Máme-li změnu realizovanou např. pomocí odkazu, tak to, že při 0 položkách daný odkaz nezobrazíme, ještě neznamená, že nám uživatel na server daný požadavek nepošle!

---

:point_right:

**Na tomto cvičení nás čeká:**
- [práce s uživatelskými účty](#u%C5%BEivatelsk%C3%A9-%C3%BA%C4%8Dty)
- [oprávnění uživatelů](#opr%C3%A1vn%C4%9Bn%C3%AD-u%C5%BEivatel%C5%AF)
- [posílání e-mailů](#pos%C3%ADl%C3%A1n%C3%AD-e-mail%C5%AF)

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


## Oprávnění uživatelů
:point_right:

TODO

## Posílání e-mailů
:point_right:

**K čemu je dobré posílání mailů z PHP?**
S posíláním mailů z PHP se setkáme v celé řadě aplikací. Jako příklady můžeme jmenovat:
- v návaznosti na uživatelské účty např. pro poslání odkazu pro potvrzení platnosti e-mailové adresy či pro změnu hesla,
- potvrzení objednávky z e-shopu,
- zasílání novinek na webu pro odběratele,
- upozornění administrátora na chybu v aplikaci.

:point_right:

**Co bychom naopak rozhodně dělat neměli?**
- Neměli bychom posílat spam - tj. např. reklamy a novinky uživatelům, kteří si je výslovně nevyžádali.
- Rozhodně bychom neměli posílat maily, ve kterých se vydáváme za někoho jiného!


### Jak e-mail odeslat?
:point_right:

- Přímo v PHP najdeme funkci ```mail()```, která umí e-mail odeslat prostřednictvím unixového nástroje sendmail. Tj. na většině serverů s ní můžeme maily ručně poslat.
- Funkce ```mail()``` je ale poměrně hloupá - respektive řeší jen odeslání, ale ne sestavení e-mailu.
    - Hodí se ale např. pro jednoduché posílání notifikací administrátorům.
    - Upozornění: Na serveru eso.vse.cz funguje posílání e-mailů jen na školní adresy. 
- Pro složitější e-maily a posílání mailů např. přes jiný SMTP server obvykle použíme odpovídající knihovny.
    - jako univerzální knihovnu doporučuji **PHPMailer**
        - jednoduchá, srozumitelná knihovna umožňující poslat např. HTML mail s přílohami nejen sendmailem, ale i přes SMTP server
        - je použita také v dalších řešeních, např. ve WordPressu
    - ve většině PHP frameworků jejich vlastní řešení pro posílání e-mailů, přičemž v některých případech jej můžeme použít i mimo framework 

Poslání mailu funkcí mail:
```php
mail($to, $subject, $message, $headers);//hlavičky jsou volitelné, ale je nutné do nich zadat např. info o odesílateli...
```

:blue_book:
Příklad a podklady:
- [Příklad mail()](TODO)
- [Příklad PHPMailer](TODO)
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