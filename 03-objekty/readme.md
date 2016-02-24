# 3. Objekty v PHP, soubory

## Práce se souborovým systémem
* na [minulém cvičení](../02-retezce-soubory) jsme se zabývali prací s obsahem souborů
* PHP samozřejmě disponuje také funkcemi pro práci s celými soubory
* nejčastěji užívané funkce:
  * **copy($source, $dest)**
    * funkce pro zkopírování souboru
  * **rename($source, $dest)**
    * funkce pro přejmenování či přesun souboru či adresáře
  * **unlink($file)**
    * smazání souboru
  * **mkdir($dir)**
    * funkce vytvoření adresáře
  * **rmdir($dir)**
    * funkce pro smazání prázdného adresáře
  * **file_exists($file)**
    * funkce pro zjištění existence souboru či adresáře
  * **move_uploaded_file($source, $dest)**
    * funkce pro přesun nahraného souboru

* [příklad kontrola čtení/zápisu](./03-soubory-stav.php)
* [příklad manipulace se soubory](./03-soubory-manipulace.php)
* [příklad výpis adresáře](./03-soubory-scandir.php)

## Třídy, rozhraní atd.
TODO


TODO:
* definice tříd, rozhraní atd.
* namespaces
- zvážit iterátory