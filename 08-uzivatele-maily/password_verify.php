<?php

	/**
	 * Jednoduchá demonstrace použití funkcí password_hash a password_verify
	 */

	$heslo = 'heslo';

	//hash získáme funkcí password_hash, jako algoritmus doporučuji uvést výchozí PASSWORD_DEFAULT; funkce do hesla zároveň doplní i sůl
	//TODO hash hesla bychom mohli uložit např. do databáze a odtud jej poté při přihlašování načíst
	$hash = password_hash($heslo, PASSWORD_DEFAULT);

	if (password_verify($heslo, $hash)){
		//TODO heslo bylo úspěšně ověřeno, uživatele přihlásíme
		echo 'OK';

		#region ověření bezpečnosti hashovací funkce
		//ověření bezpečnosti hashe není zcela nezbytné, ale je doporučené jej do přihlašování začlenit - zejména, pokud chceme mít aplikaci provozovanou dlouhodobě, postupně na více verzích PHP
		if (password_needs_rehash($hash, PASSWORD_DEFAULT)){
			$newHash = password_hash($heslo, PASSWORD_DEFAULT);
			//TODO uložení nového hashe hesla do db
		}
		#endregion ověření bezpečnosti hashovací funkce
	}else{
		//bylo zadáno chybné heslo
		echo 'chybné heslo';
	}