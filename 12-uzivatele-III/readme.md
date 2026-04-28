# 12. Uživatelské účty III. - OAuth login

:point_right:
Přihlašování jménem a heslem je vlastně jen základ. Pro uživatele (a také pro větší bezpečnost přihlašování) je vhodné jej rozšířit o alternativní možnosti či například vícefaktorové zabezpečení.

## Přihlašování pomocí protokolu OAuth
:point_right:

- Skoro každý má Google či Microsoft účet, nebo účet na sociálních sítích - proč se s ním tedy nepřihlašovat i do dalších aplikací? 
    - uživatelé si nemusí pamatovat další přihlašovací údaje
    - nemusíme řešit zabezpečení přihlašovacích údajů ve vlastní aplikaci, řešit dvoufaktorovou autentizaci atp.
    - společně s e-mailem získáme z daného účtu základní informace o uživateli (např. jméno, ID, profilový obrázek)
- většina služeb poskytujících přihlašování podporuje protokol OAuth 2.0
    - např. Facebook, Google, Microsoft, GitHub,...
- pro identifikaci uživatele využíváme údaje získané z API (nebo ID tokenu u OpenID Connect), pomocí access tokenu můžeme získat také další údaje o uživateli 
- alternativně bychom mohli použít např. autentizační protokol OpenID

### Kam ukládat identifikaci uživatelů ve vlastní aplikaci?
:point_right:

- z každé ze služeb vždy získáme ID uživatele, pod kterým je vedený v dané službě
- pro uložení ID si doplníme příslušný sloupec do tabulky s uživateli (v reálu jich může být i víc - např. ```facebook_id```, ```google_id``` atp.)
  - pokročilejší variantou by mohlo být spárování i většího množství účtů stejného typu (např. osobní a firemní účet Microsoft), ale tím to nyní nebudeme komplikovat 
- pokud budeme chtít více pracovat s API dané služby, uložíme si kromě ID a údajů daného uživatele také **access token**
    - např. do session - budeme jej dále potřebovat pro přístup k API dané služby    
    - access token je citlivý údaj – ukládáme ho bezpečně a jen pokud jej opravdu potřebujeme
- výhodou tohoto uložení informace o uživatelském účtu je to, že můžeme v aplikaci umožnit přihlašování lokálně i pomocí jiných služeb najednou (a uživatel je může dokonce střídat)
  
### Postup registrace a přihlašování uživatelů pomocí protokolu OAuth
:point_right:

1. aplikaci musíme mít zaregistrovanou na serveru poskytovatele
2. v aplikaci vygenerujeme odkaz, který uživatele přesměruje na server poskytovatele
    - s vygenerováním odkazu nám obvykle pomůže knihovna pracující s daným API
    - odkaz umístíme na web do přihlašovacího tlačítka, nebo na něj uživatele přesměrujeme z nějaké naší vlastní stránky
    - součástí požadavku by měl být parametr state (ochrana proti CSRF útokům)
3. uživateli se zobrazí standardní okno pro přihlášení danou službou a při prvním přihlášení také výzva k udělení oprávnění pro naši aplikaci
4. ať už nám uživatel přihlášení schválil, nebo odmítl, je přesměrován zpět do naší aplikaci
    - uživatel se dostane na callback URL, kterou jsme odeslali v požadavku na přihlášení a zaregistrovali ji v nastavení na serveru poskytovatele (registrace konkrétních URL je nutná pro zabezpečení)
5. pokud se uživatel úspěšně přihlásil, získáme autorizační kód, který následně vyměníme za access token pro přístup k API dané služby
    - některé služby vrací i refresh token, který umožňuje získat nový access token bez dalšího přihlášení
6. pomocí access tokenu získáme potřebné informace o uživateli (ID, jméno, e-mail, fotku atp.)
7. ve vlastní databázi v tabulce s uživateli vyhledáme uživatele podle ID v dané službě
    - pokud jej nalezneme, přihlásíme ho, jako kdyby zadal správnou kombinaci e-mailu a hesla
8. pokud uživatele podle ID nenalezneme, zkusíme jej najít pomocí e-mailu
    - pokud jej nalezneme, tak uživatele přihlásíme, jako kdyby zadal správnou kombinaci e-mailu a hesla (u citlivějších služeb zvážíme, zda byl e-mail ověřen poskytovatelem dané služby)
    - zároveň si do DB uložíme ID uživatel v dané službě
9. pokud jsme uživatele nenašli ani podle ID, ani podle e-mailu, uložíme jej do databáze jako uživatele nového
    - a samozřejmě jej přihlásíme

### Ukázka implementace přihlašování pomocí Google účtu
:point_right:

Jako příklad přihlášení pomocí externího ověření uživatele protokolem OAuth si do aplikace z dnešního cvičení doplníme možnost přihlašování pomocí Google účtu.
- Pro použití OAuth přihlášení je nutné si vytvořit vlastní aplikaci na straně poskytovatele a získat Client ID a Client Secret.
- Pro realizaci budete potřebovat vlastní uživatelský Google účet. Pokud jej nepoužíváte, velmi podobně by vypadalo přihlášení např. pomocí účtu Facebook, Microsoft atp.

:point_right:
Pro implementaci OAuth přihlašování v této ukázce použijeme knihovnu league/oauth2-client:
- Jde o obecnou knihovnu pro práci s OAuth 2.0, která poskytuje jednotné rozhraní pro různé poskytovatele (Google, Facebook, GitHub, Microsoft atd.).
- Díky tomu můžeme stejný kód snadno použít i pro jiné služby – stačí jen změnit tzv. *provider*.
  - pro každou službu existuje vlastní provider, ale jejich použití je velmi podobné
- Knihovna řeší základní OAuth flow (redirect, získání tokenu, práce s API), aniž bychom museli implementovat celý protokol ručně.

Získání balíčků:
```bash
composer require league/oauth2-client league/oauth2-google
```

:point_right:

Řešení přímo navazuje na [předchozí příklad](../11-uzivatele-II/11-local-login) s registrací, přihlašováním a obnovou zapomenutého hesla. 
Pokud jste tento příklad neprošli či jej nemáte připravený na serveru:
1. stáhněte si [zdrojový kód](../11-uzivatele-II/11-local-login)
2. nahrajte zdrojový kód aplikace na server eso.vse.cz
3. naimportujte [SQL export](../11-uzivatele-II/11-local-login/db.sql) do databáze

:orange_book:

**Řešení:**
- [prezentace s komentovaným postupem řešení](./12-google-login/prezentace-postup-vyvoje-google-login.pptx)
- [vytvořený zdrojový kód včetně exportu databáze](./12-google-login)
