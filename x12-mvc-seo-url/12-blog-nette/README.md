# Ukázka základní struktury aplikace v Nette

## Pro zprovoznění
* povolte zápis do složek
  * temp
  * log
* upravte přístupové údaje k databázi
  * app/config/config.local.neon

## Základní struktura
* celá PHP část aplikace je ve složce **app**
  * **model** - soubory modelu
  * **presenters** - jednotlivé presentery
  * **templates** - šablony v Latte
    * v jednotlivých složkách (dle presenterů) umístěné šablony pro konkrétní akce
    * soubor s layoutem
* veřejně dostupné soubory jsou ve složce **www**