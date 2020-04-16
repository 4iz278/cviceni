# 8. Uživatelé, autentizace, autorizace

:no_entry: **TYTO PODKLADY BUDOU TEPRVE AKTUALIZOVÁNY** :no_entry: 

## 1. Zdroje pro cvičení:

* http://php.net/manual/en/function.hash.php - generace hashe ze vstupních dat
* http://php.net/manual/en/function.password-hash.php - hashování hesla
* http://php.net/manual/en/function.password-verify.php - kontrola hesla
* http://php.net/manual/en/features.http-auth.php - HTTP autentizace 

### Poznámky a otázky k aplikaci
* **Otázky:**
  * Je HTTP autentizace bezpečná? Pod jakým protokolem musí aplikace běžet, aby HTTP hlavičky nešlo odposlouchávat?
  * Jaké jsou výhody/nevýhody používání HTTP autentizace?
  * Jak se jde odhlásit z HTTP autentizace?
  * Jaké jsou formy HTTP autentizace? (Basic, Digest). Jak se liší?

## 6. Hashování hesla

* **Hash = výstup hashovací funkce = digest = otisk dat = jednosměrný otisk nějakých dat pomocí známého matematického algoritmu.** Pro člověka se špatně pamatuje. Vypadá jako náhodná data. Hash jednoho  algoritmu bude mít stejnou délku pro jakkoli dlouhá vstupní data. Z výsledného hashe je prakticky nemožné (či velmi obtížné) určit vstupní data. I malá změna vstupních dat zcela změní výsledný hash. Pro různá vstupní data by neměly existovat stejné hashe (prolomeno u MD5 a SHA1).
* Příklady hashovacích funkcí - MD5, SHA1, SHA256, komplet seznam viz [funkce hash](http://php.net/manual/en/function.hash.php).
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

* Různé formy - záleží na tom, kde jsou umístěna data o uživatelích:
  * databázová - ověření vůči datům v databázi - viz [signin](./08-app/signup.php) a [user required](./08-app/user_required.php).
  * HTTP autentizace - podpora přímo v protokolu HTTP pomocí HTTP hlaviček, viz [admin required](./08-app/admin_required.php).
  * další, např. LDAP, NDS v Novell Intranetware, Active Directory od Microsoftu...

* zabezpečení pomocí HTTP autentizaci lze realizovat i mimo kód aplikace - pomocí souborů **.htaccess** a **.htpasswd**
    * k dispozici celá řada generátorů - viz např. [.htaccess Tools](http://www.htaccesstools.com/htpasswd-generator/)
    * lze využít např. pro jednoduché znepřístupnění aplikace při vývoji na serveru dostupném přes internet


## 9. Domácí úkol

1. Nastudujte HTTP Digest autentizaci. Viz [http auth](http://php.net/manual/en/features.http-auth.php).




