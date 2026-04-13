# Zabezpečení složky v Apache

- do příslušné složky nahrajte soubory **.htaccess** a **.htpasswd**
    - zabezpečení se pak vztahuje na všechny soubory v této složce, včetně podsložek
- v souboru **.htaccess** je konfigurace pro Apache
    - v tomto případě je tu jen vynucení přihlášení, ale možností je tu opravdu hodně (podrobněji se tomu budeme ještě věnovat)
- v souboru **.htpasswd** je seznam povolených kombinací jmen a hesel ve tvaru
    ```
    login:zahashovanéHeslo
    ```
- pro vygenerování dalších hesel můžete použít např. [.htpasswd generator](https://www.web2generators.com/apache-tools/htpasswd-generator)  

## Jak to vyzkoušet?
1. nahrajte tuto složku na server eso.vse.cz
2. v souboru .htaccess upravte absolutní cestu k souboru s hesly (min. nahraďte xname)
3. načtěte příslušnou cestu v prohlížeči (tj. něco jako [https://eso.vse.cz/~xname/08-htpasswd/](https://eso.vse.cz/~xname/08-htpasswd/))
4. pro přihlášení jsou tu pak povoleny kombinace:
     - *login:heslo*
     - *test:test*