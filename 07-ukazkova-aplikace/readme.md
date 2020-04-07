# 7. Ukázkové aplikace

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu ke cvičení 9. 4. 2020, doporučuji ji však ke studiu také studentům z pátečních cvičení.**

## Opakování z minulého cvičení

:point_right:

V minulém cvičení jsme se zabývali prací s databází a uložením dat v session a cookies.

Ohledně **session** byste si měli pamatovat:
- session slouží k uložení dat, která chceme uchovat na serveru mezi jednotlivými požadavky uživatele (např. přihlášení či položky v košíku)
- pro spuštění session je nutné zavolat funkci ```session_start()```
- následně máte session data k dispozici v globálním poli ```$_SESSION```
- do session jde uložit libovolná serializovatelná data (řetězce, čísla, pole, serializovatelné objekty)
- pro identifikaci konkrétního uživatele se používá kód, který je u uživatel uložen v cookie

## Obsah dnešního cvičení

:point_right:

Dnešní cvičení máme tak trochu navíc, neboť byl zrušen původně plánovaný děkanský den. Nemáme tedy ve čtvrtek volno, ale měli bychom se věnovat studiu. 

Ačkoliv by řada z vás raději již slavila Velikonoce, využijme tohoto času ke společnému programování. Nejprve si [vyřešíme domácí úkol](#%C5%99e%C5%A1en%C3%AD-dom%C3%A1c%C3%ADho-%C3%BAkolu) a následně se začneme zabývat [uživatelskými účty](#u%C5%BEivatelsk%C3%A9-%C3%BA%C4%8Dty) a doplníme je do aplikace nástěnky.

## Aplikace Nástěnka
:point_right

Na cvičení [5. SQL a databáze](../05-sql-databaze) byl zadán domácí úkol, v rámci kterého jste měli rozšířit funkcionalitu nástěnky vytvářené na daném cvičení. Zadání tohoto domácího úkolu naleznete [zde](../05-sql-databaze#dom%C3%A1c%C3%AD-%C3%BAkol).

V rámci dnešního cvičení si ukážeme vyřešení tohoto domácího úkolu a následně do aplikace doplníme jednoduché přihlašování uživatelů.

### Řešení domácího úkolu
:point_right:

V rámci domácího úkolu bylo požadováno doplnění možnosti editace příspěvků a doplnění možnosti zobrazování příspěvků jen ze zvolené kategorie. Pokud máte u domácího úkolu vlastní řešení, určitě můžete pokračovat i v něm či si jej můžete zkontrolovat.

**Nutná příprava:**
1. stáhněte si [zdrojový kód](../05-sql-databaze/05-aplikace-nastenka)
2. nahrajte zdrojový kód aplikace na server eso.vse.cz
3. naimportujte SQL export do databáze
 
:orange_book:

**Řešení:**
- [prezentace s komentovaným postupem řešení](TODO)
- [vytvořený zdrojový kód včetně exportu databáze](TODO)

### Uživatelské účty
:point_right:

Uživatelskými účty se podrobněji budeme zabývat až na dalším cvičení. V tomto cvičení jen uveďme pár základních pravidel:
- pro lokální přihlašování obvykle používáme kombinaci uživatelského jména (či e-mailu) a hesla
- heslo nikdy neukládáme do databáze v čitelné podobě, ale vždy hashovaně
    - heslo je pak chráněné i v případě, kdy se nám někdo dostane do databáze
    - z hashe nejde získat původní heslo zpátky (tj. při jeho zapomenutí jej aplikace nemůže uživateli sdělit!)    

:point_right:

Pro zahashování (zašifrování) hesla budeme používat funkci ```password_hash```, pro ověření jeho správnosti pak funkci ```password_verify```. Ve skutečnosti kontrolujeme, jestli se hash hesla zadaného při přihlášení shoduje s hashem hesla uloženým v databázi

Pro registraci i přihlášení uživatele použijeme normální formulář v aplikaci. Přihlášení uživatele si pamatujeme pomocí **session**. 
   
### Uživatelské účty v aplikaci Nástěnka
TODO




## Domácí úkol
:house:

V tomto týdnu nemáme klasický domácí úkol, ale je na čase, abyste začali přemýšlet nad zadáním své PHP aplikace, kterou budete odevzdávat ve zkouškovém období.
Aplikace by měla být postavena nad databází a využívat alespoň 3 tabulky ve vazbách 1:N či M:N. Zároveň je nutné, aby aplikace byla použitelná a smysluplná.

Zadání stačí v podobě pár vět, ve kterých popíšete, co má aplikace umět. Zadání je potřeba odevzdat do odevzdávárny v InSISu nejpozději do **8. 5. 2020**.         