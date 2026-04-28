# 11. Uživatelské účty II. - posílání mailů, obnova zapomenutého hesla

V [minulém bloku](../10-uzivatele) jsme si vytvořili jednoduché přihlášení uživatelé pomocí jména a hesla. Jenže často se stává, že uživatelé heslo zapomenou a potřebují jej obnovit. Obvyklý postup pak zahrnuje ověření identity posláním mailu - nejprve se tedy podíváme na posílání mailů.

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

- Přímo v PHP najdeme funkci ```mail()```, která umí e-mail odeslat prostřednictvím unixového nástroje sendmail - tj. funguje na většině serverů.
- Funkce ```mail()``` je ale *poměrně hloupá - respektive řeší jen odeslání, ale ne sestavení e-mailu*.
    - Hodí se ale např. pro jednoduché posílání notifikací administrátorům.
    - Není ideální pro běžné produkční použítí:
      - chování závisí na konfiguraci serveru
      - není úplně jednoduché sestavit mail se všemi hlavičkami tak, aby neskončil ve spamu
- Pro složitější e-maily a posílání mailů např. přes jiný SMTP server obvykle použíme odpovídající knihovny.
    - jako univerzální knihovnu doporučuji **PHPMailer**
        - jednoduchá, srozumitelná knihovna umožňující poslat např. HTML mail s přílohami nejen sendmailem, ale i přes SMTP server
        - je použita také v dalších řešeních, např. ve WordPressu
        - instalace nejjednodušeji pomocí composeru
    - ve většině PHP frameworků existuje jejich vlastní řešení pro posílání e-mailů, přičemž v některých případech jej můžeme použít i mimo framework

:point_right:
Poslání mailu funkcí mail:
```php
mail($to, $subject, $message, $headers);
//hlavičky jsou volitelné, ale je nutné do nich zadat např. info o odesílateli...
//návratová hodnota funkce mail() je true/false, ale označuje jen odeslání - ne doručení příjemci!
```

:point_right:
Ukázka vhodného jednoduchého použití funkce mail:
```php
mail(
  'xname@vse.cz',
  'Chyba v aplikaci',
  "Došlo k chybě.\nČas: " . date('d.m.Y H:i:s') . "\nURL: " . $_SERVER['REQUEST_URI'],
  [
    'From' => 'xname@vse.cz',
    'Content-Type' => 'text/plain; charset=UTF-8'
  ]
);
```

:grey_exclamation:
- Odesílání mailů ze serveru eso.vse.cz je omezeno pouze na posílání mailů na školní doméně a jsou omezena MIME rozšíření.
  - Např. na Google či Seznam si mail z tohoto serveru nepošlete.
  - Pozor na nastavení kódování mailu. 
- Nezapomeňte, že odeslání mailu nutně neznamená, že jej příjemce obdrží. Mail může skončit ve spamu, být zablokován atp.

:blue_book:

Příklad a podklady:
- [Příklad mail() - prostý text](./11-mail-plaintext.php)
- [Příklad mail() - HTML verze](./11-mail-html.php)
- [Příklad PHPMailer](./11-phpmailer/example.php)
- [Příklad PHPMailer s přílohou](./11-phpmailer/example-with-attachment.php)
- [Funkce mail() na w3schools.com](https://www.w3schools.com/php/func_mail_mail.asp)
- [Informace ke knihovně PHPMailer](https://github.com/PHPMailer/PHPMailer)

:blue_book:

Řešení pro posílání mailů ve frameworcích:
- [Nette\Mail](https://doc.nette.org/cs/mail)
- [Symfony\Mailer](https://symfony.com/doc/current/mailer.html)

### Posílání velkého množství e-mailů
:point_right:

- Pokud budete chtít z webu např. rozesílat newsletter či jinou formu reklam většímu množství uživatelů, či jen máte na serveru velký provoz, např. v e-shopu, je vhodnější použít specializovanou e-mailovou službu (SaaS).
- Při odesílání většího množství e-mailů řešíme tzv. *doručitelnost (deliverability)*:
  - na managed hostingu vám pak nevypnou základní posílání mailů
  - nebudete muset tak moc řešit, zda nejste na spamovém blacklistu, škálování, balancování atp.
  - e-mailové služby řeší za vás i technické nastavení (SPF, DKIM, DMARC), které ovlivňuje doručitelnost
- Pozor, většina normálních e-mailových schránek (např. gmail) má limit na počet odeslaných zpráv - tj. nemůžete je používat pro rozesílání velkého množství mailů, i když se k nim zvládnete přihlásit přes SMTP.

Příklady e-mailových služeb (SaaS) pro odesílání e-mailů:
- [Amazon SES](https://aws.amazon.com/ses/) - SMTP jako SaaS, pod Amazon Web Services (levný, spolehlivý)
- [Sendgrid](https://sendgrid.com/) - další SMTP server jako SaaS, velké objemy (i miliony mailů měsíčně; drahý, ale spolehlivý)
- [MailChimp](http://mailchimp.com/) - kompletní odesílání mailů jako SaaS (tvorba šablon, WYSIWYG editor, plánovač odesílání, tracking doručení i přečtení mailu příjemcem, garantuje doručení, velmi drahý)
- [Ecomail](https://ecomail.cz/) - česká platforma pro e-mail marketing, často používaná u e-shopů
- [SmartEmailing](https://www.smartemailing.cz/) -další český nástroj pro newslettery a kampaně

:point_right:

Otázka k zamyšlení: *Jak lze poznat, že uživatel dostal do schránky mail, nebo si ho dokonce přečetl? A je to spolehlivé?*

## Obnova zapomenutého hesla
:point_right:

Možnost obnovy zapomenutého hesla je jedním z obvyklých požadavků kladených na aplikace, do kterých se musejí uživatelé přihlašovat. Jak již ale víme, všechny přijatelně napsané aplikace mají místo původních hesel uloženy v databázi jen jejich hashe, ze kterých nejde původní hesla rekonstruovat. Aplikace tedy nemůže odeslat uživateli původní heslo, ale může mu nabídnout nastavení hesla nového. Ideálně tak, aby si jej vybral dotyčný uživatel sám.

:point_right:

**Obvyklý postup obnovy hesla:**
1. uživatel zjistí, že mu nejde se do aplikace přihlásit => pravděpodobně zapomněl heslo
2. uživatel vyplní formulář s požadavkem na obnovu zapomenutého hesla
3. aplikace musí nějak ověřit identitu uživatele
    - u běžných aplikací je vygenerován dočasný kód na změnu hesla, který je uživateli zaslán e-mailem (tj. je ověřeno, že uživatel má přístup do dané e-mailové schránky); kód má omezenou platnost (časově a počtem použití)
    - u kritičtějších aplikací je očekávána větší úroveň zabezpečení - z automatizovaných lze využít např. zaslání dalšího kódu SMSkou atp., ale lze se setkat i s ověřením identity reálnými pracovníky
4. aplikace uživateli heslo rovnou změní na nějaké dočasné, nebo uživatel využije odkaz na změnu hesla a nastaví si jej sám
    - druhá varianta je lepší, neboť tím nezpůsobíme problémy uživatelům, kterým se někdo snaží do účtu neúspěšně nabourat (tj. někdo odeslal požadavek na změnu hesla bez vědomí uživatele), nebo kteří si později na původní heslo vzpomenou

### Ukázka implementace přihlašování včetně možnosti obnovy zapomenutého hesla
:point_right:

V rámci ukázkového příkladu si vytvoříme základ aplikace s lokální autentizací uživatelů - tj. s údaji uloženými v databázi a přihlášením uživatele pomocí SESSION.

Aplikace bude obsahovat:
- formuláře pro přihlášení existujícího uživatele a registraci uživatele nového
- možnost odhlášení a zobrazení informace o tom, zda je uživatel přihlášen
- možnost poslání požadavku na změnu hesla, zaslání příslušného odkazu e-mailem a možnost změnit zapomenuté heslo na nové

:orange_book:
- [prezentace s komentovaným postupem implementace přihlašování a obnovy zapomenutého hesla](./11-local-login/prezentace-postup-vyvoje-local-login.pptx)
- [vytvořený zdrojový kód včetně exportu databáze](./11-local-login)