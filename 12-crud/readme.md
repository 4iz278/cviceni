# 12. CRUD aplikace, REST API


## CRUD

**CRUD** = **C**reate, **R**ead, **U**pdate, **D**elete = programový pøístup/idiom pro práce s daty. Èasto ve vztahu k nìjakému objektu, který jde Vytvoøit, Èíst, Aktualizovat a Mazat.

## REST

**REST** = **RE**presentational **S**tate **T**ransfer = architektonický pøístup, který umo¾òuje pracovat se stránkami a mìnit jejich stav. URI stránky je typicky namapováno na nìjaký objekt a pomocí HTTP metod (GET, POST, PUT, DELETE) mìníme stav tohoto objektu.
** REST není protokol, jen zpùsob komunikace. REST se èasto pou¾ívá pod HTTP protokolem.

Pøíklad: 

* **GET https://nejakaaplikace.com/clients/adam** - zobrazí detail pro klienta Adama.
* **POST https://nejakaaplikace.com/clients** - zalo¾í nového klienta, v tìle HTTP metody jsou data (jméno: Adam, pøíjmení: Shelby)
* **PUT https://nejakaaplikace.com/clients/adam** - aktualizuje klienta, v tìle HTTP metody jsou nová data (jméno: Adam, pøíjmení: Shelby)
* **DELETE https://nejakaaplikace.com/clients/adam** - sma¾e klienta Adama

Typické a pøímoèaré propojení s CRUD:

* **POST** = **C**reate
* **GET** = **R**ead
* **PUT** = **U**pdate
* **DELETE** = **D**elete

### Otázky

* Jaké HTTP metody mù¾eme pou¾ívat v HTML?
* Jak byste vyøe¹ili odeslání nìjakých dat pøes HTTP metodu, kterou HTML nepodporuje (napø. jak poslat HTTP PUT pro update záznamu pomocí HTML formuláøe)? Zajímá mì **øe¹ení na serveru** (jako autoøi API) a **øe¹ení na klientovi** (HTML).

## API

* **API** = Application Program Interface = aplikaèní programové rozhraní = popis, jak pracovat s cizím programem tak, jak to jeho autor dovolil. Umo¾òuje napojit se na nìjakou aplikaci typicky *zvenèí* a propojit ji s na¹í aplikací nebo ji na dálku ovládat. V pøípadì webu je API typicky tøeba, abychom dokázali vyu¾ívat nìjaké slu¾by, které jsme sami nenapsali, ale chceme je mít v na¹í aplikaci, napø. pou¾ít mapy od Google pro plánovaní trasy v na¹í aplikaci, posílat automaticky pøíspìvky na Twitter, komentáøe u¾ivatelù v na¹í aplikaci ukládat rovnou na zeï ve Facebooku, ovìøit u¾ivatele pomocí jiné slu¾by, apod.
* API pí¹e autor pùvodního programu.
* API jako jedno z mála potøebuje dobrou a podrobnou (programátorskou) dokumentaci.
* API není pro koncové u¾ivatele, ale pro programátory.
* API je dálkový ovladaè k cizímu programu.
* API "voláme" pomocí nìjaké slu¾by, dnes typicky pøes REST skrze HTTP request.


## 1. Zdroje pro cvièení:

* 

## 2. Vytvoøení db schématu


## 3. Naplnìní testovacími daty


## 4. Pøipojení k databázi


## 5. Práce s aplikací


### Poznámky a otázky k aplikaci


##  6. Domácí úkol

* Napi¹te klienta pro jakékoli volnì dostupné API (Google Maps, Seznam Mapy, Twitter, Facebook, Pinterest, Instagram... nebo i jakékoli jiné).
