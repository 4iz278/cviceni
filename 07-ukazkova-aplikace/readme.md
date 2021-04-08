# 7. Ukázkové aplikace

:grey_exclamation: **Tato složka obsahuje podklady k domácímu studiu.**

## Opakování z minulého cvičení

:point_right:

Nejprve si [vyřešíme domácí úkol](#%C5%99e%C5%A1en%C3%AD-dom%C3%A1c%C3%ADho-%C3%BAkolu) a následně se začneme zabývat [uživatelskými účty](#u%C5%BEivatelsk%C3%A9-%C3%BA%C4%8Dty) a doplníme je do aplikace nástěnky.

---

## Aplikace Nástěnka
:point_right:

Na cvičení [5. SQL a databáze](../05-sql-databaze) byl zadán domácí úkol, v rámci kterého jste měli rozšířit funkcionalitu nástěnky vytvářené na daném cvičení. Zadání tohoto domácího úkolu naleznete [zde](../05-sql-databaze#dom%C3%A1c%C3%AD-%C3%BAkol).

Ukážeme si vyřešení tohoto domácího úkolu a následně do aplikace doplníme jednoduché přihlašování uživatelů.

### Řešení domácího úkolu
:point_right:

V rámci domácího úkolu bylo požadováno doplnění možnosti editace příspěvků a doplnění možnosti zobrazování příspěvků jen ze zvolené kategorie. Pokud máte u domácího úkolu vlastní řešení, určitě můžete pokračovat i v něm či si jej můžete zkontrolovat.

**Nutná příprava:**
1. stáhněte si [zdrojový kód](../05-sql-databaze/05-aplikace-nastenka)
2. nahrajte zdrojový kód aplikace na server eso.vse.cz
3. naimportujte SQL export do databáze
 
:orange_book:

**Řešení:**
- [prezentace s komentovaným postupem řešení](./07-nastenka-reseni-du/prezentace-nastenka-reseni-du.pptx)
- [vytvořený zdrojový kód včetně exportu databáze](./07-nastenka-reseni-du)

## Uživatelské účty
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
:point_right:

Jako další část dnešního cvičení si do aplikace Nástěnka doplníme možnost jednoduché registrace a přihlášení uživatelů.

Nebudeme řešit oprávnění uživatelů, každý z přihlášených uživatelů bude moct přidávat příspěvky a také všechny příspěvky upravovat.  

**Řešení přímo navazuje na předchozí příklad** vyřešení zadání domácího úkolu. Pokud jste jej z nějakého důvodu neabsolvovali, je potřeba:
1. stáhněte si [zdrojový kód](./07-nastenka-reseni-du)
2. nahrajte zdrojový kód aplikace na server eso.vse.cz
3. naimportujte SQL export do databáze
 
:orange_book:

**Řešení:**
- [prezentace s komentovaným postupem řešení](./07-nastenka-uzivatele/prezentace-nastenka-uzivatele.pptx)
- [vytvořený zdrojový kód včetně exportu databáze](./07-nastenka-uzivatele)       
