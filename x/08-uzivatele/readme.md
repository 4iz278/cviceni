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
  

* zabezpečení pomocí HTTP autentizaci lze realizovat i mimo kód aplikace - pomocí souborů **.htaccess** a **.htpasswd**
    * k dispozici celá řada generátorů - viz např. [.htaccess Tools](http://www.htaccesstools.com/htpasswd-generator/)
    * lze využít např. pro jednoduché znepřístupnění aplikace při vývoji na serveru dostupném přes internet


## 9. Domácí úkol

1. Nastudujte HTTP Digest autentizaci. Viz [http auth](http://php.net/manual/en/features.http-auth.php).




