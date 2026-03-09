# 4. Validace formulářů
* o tom, jak získat data z formulářů či pomocí URL jsme se už bavili v souvislosti s globálními poli **$_GET** a **$_POST** ([tady](../02-pole-retezce#get-post-request))
* je nutné kontrolovat nejen to, zda nám data dorazila, ale také jejich tvar/správnou hodnotu
* validace vstupů je důležitá jak kvůli správné funkci aplikace, tak kvůli bezpečnosti
* obdobná pravidla pro kontroly se budou týkat také dalších vstupních dat - např. dat načtených přes API

Opakování jednoduchého formuláře:
```html
<form method="post"><!--U formuláře můžeme definovat metodu get nebo post. Pokud by skript neměl data posílat sám sobě, ale někam jinam, uvedeme ještě parametr action.-->
  <label for="cislo">Zadejte číslo:</label><!--label je popiskem pole, které má id stejné, jako je tady hodnota atributu for-->
  <input type="number" name="cislo" id="cislo" value="<?php echo htmlspecialchars($_POST['cislo'] ?? '');?>"><!--pole s vypsanou dříve odeslanou hodnotou, zkuste si vzpomenout, co dělá htmlspecialchars()-->
</form>
```
### Proč data kontrolovat?
:point_right:

Pokud máme např. ve formuláři pole pro zadání dnešního data, může uživatel stejnou hodnotu zapsat mnoha různými způsoby:
```
20. 3. 2020
20.3.2020
20.03.2020
20.3.20
20.03.20
20. března 2020
2020-03-20
March 03, 2020
20. 3.
```

### Základní zásady kontroly dat
:point_right:

* **Všechny vstupy od uživatele je nutné kontrolovat** - ať už byly odeslány formulářem, nebo v URL uvedené v rámci odkazu!
* Data můžeme kontrolovat také pomocí HTML5 validace nebo JavaScriptu, ale přesto je musíme znovu zkontrolovat i na serveru! 
  * Data nám mohl poslat také nějaký skript, robot atp. A nebo prostě uživatel vypnul javascript nebo použil starý prohlížeč. 
* Chyby musíme uživateli zobrazovat v přehledné a hlavně srozumitelné podobě - žádné hlášky ve stylu "Ve formuláři je chyba." nebo "Vyplňte povinná pole."
* U důležitějších formulářů je vhodné aplikovat CSRF ochranu (Cross-Site Request Forgery) - ale to až budeme umět používat *session*... 
* To, co nemusí uživatel zadávat ručně, mu umožníme nějak vybrat:
  * např. výběrem ze selectu, 
  * výběrem z kalendáře atp.,
  * kliknutím na odkaz.

### Můžeme uživateli usnadnit zadávání dat?
:point_right:

Pokud chcete od uživatele údaj, který je běžně možné zadat ve větším množství formátů, zkuste se zamyslet nad tím, zda data není vhodné ještě před kontrolou upravit.
* Například z telefonního čísla můžeme vyházet mezery, lomítka a pomlčky;
* u čísla můžeme v českém prostředí automaticky převést desetinnou čárku na tečku;
* u datumu můžeme z českého formátu udělat mezinárodní atd. 

:point_right:
V praxi často postupujeme ve dvou krocích:
1. **normalizace dat** (např. odstranění mezer, sjednocení formátu)
2. **validace dat** (ověření, že data splňují požadovaná pravidla)

### Postup implementace validace
:point_right:

1. kontrola v rámci HTML/HTML 5 formuláře
   * nedá se na ni sice úplně spolehnout, ale je to nejrychlejší varianta, jak "omezit" kreativitu uživatele 
   * např. vhodná formulářová pole (datum, čas, email), omezení délky (maxlength), povinné pole (required) atd.
2. volitelná kontrola v JavaScriptu
   * vhodná hlavně u dynamicky načítaných formulářů, zlepšuje uživatelský komfort, ale není úplně nezbytná
   * může být výrazně interaktivnější, než kontrola na serveru (např. se uživatel dozví o chybě hned při zadání chybné hodnoty)
3. kontrola dat na serveru
    * kontrola dat na serveru je vždy povinná - ať už byla data získána z GETu, nebo POSTu
4. pokud byla v datech chyba, zobrazíme formulář k opravě
   * musí v něm být ty hodnoty, které nám uživatel poslal! (aspoň ty, které byly správně)
5. pokud byla data v pořádku, provedeme požadovanou akci
   * pokud byla data poslána metodou POST, tak provedeme přesměrování!    

### Jak informovat uživatele o chybách
:point_right:

* Všechny chyby bychom měli srozumitelně popsat, aby uživatel rovnou věděl, co po něm chceme.
* O všech chybách informujeme uživatele najednou - je to příjemnější, než když nám aplikace formulář 5x vrátí vždy s jinou chybou.
* Chyby zobrazujeme rovnou na stránce s formulářem, ne na samostatné stránce! 
* Minimálně to, co bylo správně, musí zůstat ve formuláři vyplněno!
* Chyby můžeme zobrazit 2 způsoby:
  1. na začátku formuláře či každé jeho sekce zobrazíme výpis chyb (např. jako odrážky) - což je pro nás jako programátory jednodušší, ale uživatelsky je to méně přívětivé
  2. chyby zobrazujeme u jednotlivých polí formuláře    

### Přesměrování po zpracování formuláře 
:point_right:

* **Pokud odesíláme formulář pomocí POSTu, je nutné po jeho úspěšném zpracování provést redirect!**
  * Pokud bychom to neudělali, tak prohlížeč při obnově dané stránky vyzve uživatele k opětovnému odeslání dat (zeptá se jich, zda chtějí odeslat data a provést nákup či něco podobného znovu). 
* Přesměrování je nutné vyřešit na úrovni protokolu HTTP (nestačí přesměrování javascriptem atp.). 
* Před odesláním libovolných dat (tj. ještě před doctypem) zavoláme v PHP funkci:

```php
header('Location: skript.php'); //ukázka odeslání hlavičky pro dočasné přesměrování
exit();
```

:point_right:
- Přesměrování provádíme jen v situaci, že formulář neobsahoval chyby.
- Z hlediska struktury skriptu je běžné nejdříve zkontrolovat a zpracovat data z formuláře a teprve poté začít generovat HTML  


### Užitečné validační funkce
:point_right:

* **preg_match($pattern, $text)**
  * funkce pro kontrolu, zda zadaný text odpovídá požadovanému regulárnímu výrazu
  * regulární výraz zapisujeme mezi oddělovače (nejčastěji `/`), z hlediska datového typu je to string

* **filter_var($text, $filtr)**
  * funkce pro validaci a případné "pročištění" vstupu
  * PHP obsahuje řadu předdefinovaných filtrů (např. pro e-mail, URL nebo čísla)
  * pro běžné typy dat je často jednodušší použít tuto funkci než vlastní regulární výraz
  * kromě validace může **filter_var()** sloužit také k tzv. **sanitizaci** dat – tedy k automatickému odstranění nebo úpravě nežádoucích znaků ze vstupu (např. u e-mailu nebo URL)

```php
if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
  echo 'Musíte zadat platný e-mail.';
}
```    

### Příklady k validaci formulářů
:blue_book:
* [příklad validace - HTML 5](0$-validace-html5.php)
* [příklad validace - souhrnné hlášení chyb](../04-validace/04-validace-souhrnna.php)
* [příklad validace - hlášení chyb u jednotlivých inputů](../04-validace/04-validace-inputy.php)
* [podklady k formulářům v JavaScriptu](https://github.com/4iz268/cviceni/tree/master/10-formulare)
* [w3schools - Filter functions](http://www.w3schools.com/php/php_ref_filter.asp)
* [PHP manuál - preg_match](http://php.net/manual/en/function.preg-match.php)
 
:orange_book:

Kromě již kompletních příkladů se pojďme společně podívat na **postup tvorby jednoduchého formuláře s kontrolami**.

V následujícím příkladu budeme chtít od uživatele chtít získat jméno a příjmení, e-mail a telefon, na kterém je možné jej kontaktovat. Výsledek poté zapíšeme do CSV souboru.
* [prezentace s komentovaným postupem řešení](./04-priklad-validace/04-prezentace-priklad-form.pptx)
* [vytvořený soubor](./04-priklad-validace/formular.php)