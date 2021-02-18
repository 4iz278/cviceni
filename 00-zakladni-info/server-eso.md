# Server eso.vse.cz
 * jedná se o výukový server, na který máte automaticky zřízen přístup v rámci absolvence tohoto předmětu
 * jedná se o linuxový server s Apachem, PHP a MySQL
 * **uživatelské účty jsou obvykle platné jen do konce příslušného zkouškového období**

## Připojení
 * k serveru je možný přístup pouze prostřednictvím protokolu **SCP** či **SFTP**
    * Secure Copy
    * protokoly odvozené od SSH (Secure Shell)
    * nejedná se ani o běžné FTP, ani o FTPS
    * na serveru eso je povolené i přímé připojení prostřednictvím protokolu *SSH* (např. pomocí [Putty](http://putty.org))
 * vaše soubory jsou dostupné na adrese **http://eso.vse.cz/~xname/**

### Přístupové údaje
 * protokol: **SFTP**
 * port: **22**
 * server: **eso.vse.cz**
 * login: **xname**
 * heslo: **jako do školní sítě**

### Vhodný software
 * [WinSCP](http://winscp.net/)
    * k dispozici i na školních počítačích
 * [SFTP plugin pro Total Commander](http://www.ghisler.com/plugins.htm)
    * po nainstalování jej naleznete v položce "Síť"
    * je nutné dokopírovat DLL soubory
 * [FileZilla](https://filezilla-project.org)
 * namapování deploye v rámci vývojového prostředi (např. PhpStorm)

### Přístup k MySQL
 * pro přístup k databázi je potřebné speciální heslo, které naleznete po přihlášení k serveru v souboru *mysql-heslo.txt*
