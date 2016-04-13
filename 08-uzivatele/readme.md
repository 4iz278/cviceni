# 8. Uživatelé, autentizace, autorizace

Do našeho e-shopu přidáme autentizaci (KDO je uživatel) a autorizaci (CO může uživatel dělat). Aplikaci může používat pouze přihlášený uživatel. Katalog může spravovat pouze administrátor.

## 1. Zdroje pro cvičení:

* http://php.net/manual/en/function.hash.php - generace hashe ze vstupních dat
* http://php.net/manual/en/function.password-hash.php - hashování hesla
* http://php.net/manual/en/function.password-verify.php - kontrola hesla
* http://php.net/manual/en/features.http-auth.php - HTTP autentizace 

## 2. Vytvoření db schématu

Vytvořte na serveru eso.vse.cz ve vaší MySQL databázi tabulku goods (zboží) a users (uživatelé).

[create table goods and users](./08-schema.sql)

## 3. Naplnění testovacími daty

Naplňte vytvořenou tabulku testovacími daty. Testovací data lze vygenerovat např. aplikací http://www.generatedata.com/

[insert test data](./08-data.sql)

## 4. Připojení k databázi

Pro práci s DB budeme opět používat třídu [PDO](http://php.net/manual/en/class.pdo.php), která je abstraktním objektem nad jakoukoli databází:

[db.php](./08-app/db.php)

**Nezapomeňte v souboru nastavit váš xname a heslo pro připojení do db!**

## 5. Práce s aplikací

Zkopírujte scripty z adresáře 08-data do vašeho adresáře na serveru eso.vse.cz.

Funkční aplikaci pak najdete na adrese:

https://eso.vse.cz/~xhraj18/ (použijte váš vlastní xname :)

Případy užití:

Část pro nepřihlášeného uživatele/databázová autentizace:

* [signup](./08-app/signup.php) - registrace nového uživatele, demonstrace práce s funkcí [password_hash](http://php.net/manual/en/function.password-hash.php).
* [signin](./08-app/signup.php) - přihlášení existujícího uživatele, demonstrace práce s funkcí   [password_verify](http://php.net/manual/en/function.password-verify.php).

Část pro přihlášeného uživatele:

* [index](./08-app/index.php) - výpis zboží v e-shopu.
* [buy](./08-app/buy.php) - přidání zboží do košíku dle ID (demonstrace práce se sessions).
* [cart](./08-app/cart.php) - výpis zboží přidaného do košíku (demonstrace práce se sessions).
* [remove](./08-app/remove.php) - smazání zboží z košíku (demonstrace práce se sessions).
* [signout](./08-app/signout.php) - odhlášení, zruší session (demonstrace práce se sessions).

Část pro administátora (správce):

* [new](./08-app/new.php) - přidání nového zboží do e-shopu, začne se nabízet ke koupi.
* [delete](./08-app/delete.php) - smazání zboží z e-shopu, přestane se nabízet ke koupi.
* [update](./08-app/update.php) - úprava zboží v e-shopu.

Část pro autorizaci a HTTP autentizaci:

* [user required](./08-app/user_required.php) - soubor pro require, vynucení přihlášení uživatele.
* [admin required](./08-app/admin_required.php) - soubor pro require, vynucení přihlášení administrátora, demonstrace HTTP autentizace.


### Poznámky a otázky k aplikaci

* Aplikaci může používat jen přihlášený uživatel - pokud není přihlášen, aplikace provede HTTP redirect na [signin](./08-app/signup.php) stránku. Viz [user required](./08-app/user_required.php).
* Jen admin může měnit katalog zboží. Viz [admin required](./08-app/admin_required.php). Tato část používá HTTP autentizaci.
* Aplikace nemá ošetřené vstupy (prázdné heslo), pouze zamezuje SQL inject útoku. Do it yourself - udělejte si sami doma :)
* **Otázky:**
  * Je HTTP autentizace bezpečná? Pod jakým protokolem musí aplikace běžet, aby HTTP hlavičky nešlo odposlouchávat?
  * Jaké jsou výhody/nevýhody používání HTTP autentizace?
	* Jak se jde odhlásit z HTTP autentizace?
	* Jaké jsou formy HTTP autentizace? (Basic, Digest). Jak se liší?

## 6. Hashování hesla

* Hash = výstup hashovací funkce = digest = otisk dat = jednosměrný otisk nějakých dat pomocí známého matematického algoritmu. Pro člověka se špatně pamatuje. Vypadá jako náhodná data. Hash jednoho  algoritmu bude mít stejnou délku pro jakkoli dlouhá vstupní data. Z výsledného hashe je prakticky nemožné (či velmi obtížné) určit vstupní data. I malá změna vstupních dat zcela změní výsledný hash. Pro různá vstupní data by neměly existovat stejné hashe (prolomeno u MD5 a SHA1).
* Příklady hashovacích funkcí - MD5, SHA1, SHA256, komplet seznam viz [funkce hash](./08-schema.sql) http://php.net/manual/en/function.hash.php
* **Pokud nevíte, kterou hashovací funkci použít, SHA256 a SHA512 jsou OK. Neberte MD5, ani SHA1.**
* Při hashování je vhodné použít **salt (sůl)** = náhodná data, která jsou přimíchána do výsledného hashe (nebo uložena bokem) z původních dat. Smyslem je zamezit útokům pomocí tzv. **rainbow table (duhová tabulka)** - tzv. reverzní hashing = předvypočtené slovníky výsledků hashovacích funkcí, ze kterých lze odvodit původní vstupní data = ideální pro zjištění hesla, pokud se útočník nějak dostane k hashům.
* Hesla můžeme hashovat sami pomocí [funkce hash](http://php.net/manual/en/function.hash.php), vybrat hashovací funkci, generovat vlastní **sůl**, atd.
* Nebo jednoduše použijeme [funkci password_hash](http://php.net/manual/en/function.password-hash.php), která sama generuje bezpečnou sůl a používá aktuálně bezpečnou hashovací funkci. Vygenerovaný hash v sobě dále obsahuje použitou hashovací funkci a sůl. **Tohle je preferovaný způsob hashování hesla v PHP**.
* Pro ověření hesla použijeme funkci [funkci password_verify](http://php.net/manual/en/function.password-verify.php).
* Viz [ukázka použití funkce password_verify](./password_verify.php).
* **Otázky:**
  * Které hashovací funkce nemáme používat? Proč?
  * Co se stane, když útočník bude znát hash hesla? Jde z něj vypočítat či určit původní heslo? Jak?
	* Co je duhová tabulka (rainbow table)?
  * Musíme solit?
  * Co se stane, pokud útočník bude znát jen sůl?
  * Je možné mít sůl pokaždé stejnou? Nebo pokaždé jinou? Jaké jsou výhody/nevýhody?
  * Proč se salt (sůl) jmenuje právě sůl? V čem je analogie?


## 7. Autentizace

* **Autentizace (z angličtiny)= autentifikace (asi z francouzštiny :) = authentization = kdo jsem = zjištění totožnosti uživatele.**
* Analogie s řidičským průkazem - kdo je řidič? Jméno, příjmení, fotka. Pokud nás zastaví, zda jsme to my.
* Různé formy - záleží na tom, kde jsou umístěna data o uživatelích:
  * databázová - ověření vůči datům v databázi - viz [signin](./08-app/signup.php) a [user required](./08-app/user_required.php).
	* HTTP autentizace - podpora přímo v protokolu HTTP pomocí HTTP hlaviček, viz [admin required](./08-app/admin_required.php).

## 8. Autorizace

* **Autorizace = co můžu dělat, jaká mám oprávnění, kam mám přístup.**
* Analogie s řidičským průkazem - když nás zastaví na Harley, máme na řidičáku skupinu A?
* Typicky mapováno na role a use-cases (případy užití) v aplikaci - v našem obchodu jen admin může měnit katalog zboží, ostatní uživatelé mohou používat aplikaci. Nepřihlášený uživatel nemůže aplikaci vůbec používat.

## 9. Domácí úkol

1. Nastudujte HTTP Digest autentizaci. Viz [http auth](http://php.net/manual/en/features.http-auth.php).
2. Upravte aplikaci tak, aby byl i administrátor ověřován pomocí databáze. Zrušte HTTP autentizaci.




