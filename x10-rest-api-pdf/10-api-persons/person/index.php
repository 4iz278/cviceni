<?php

  /**
   * REST API pro práci s osobami
   */

  #region načtení závislostí
  require_once __DIR__.'/../functions.php';//načtení souboru s pomocnými funkcemi
  try{
    require_once __DIR__.'/../db.php';//připojení k DB
  }catch (\Exception $e){
    send_error_response('Chyba připojení k databázi.', 500);
  }
  #endregion načtení závislostí

  switch ($_SERVER['REQUEST_METHOD']){
    case 'GET':
      //načtení jedné či několika osob
      if (!empty($_GET['id'])){
        getSinglePerson($db);
      }else{
        getPersons($db);
      }
      break;
    case 'POST':
      //vytvoření nové osoby
      createPerson($db);
      break;
    case 'PUT':
      //aktualizace existující osoby
      updatePerson($db);
      break;
    case 'DELETE':
      //smazání osoby
      deletePerson($db);
      break;
    default:
      send_error_response('Chybný požadavek.');
      exit();
  }

  /**
   * Funkce vracející údaje o jedné osobě
   * @param PDO $db
   */
  function getSinglePerson(PDO $db){
    $query=$db->prepare('SELECT * FROM persons WHERE person_id=:id LIMIT 1;');
    $query->execute([':id'=>$_GET['id']]);

    if ($person=$query->fetch(PDO::FETCH_ASSOC)){
      //odeslání údajů jedné osoby
      $result=[
        'id'=>$person['person_id'],
        'name'=>$person['name'],
        'email'=>$person['email'],
        'phone'=>$person['phone'],
      ];

      send_json_response($result);

    }else{
      //osoba nebyla nalezena
      send_error_response('Person not found!', 404);
    }
  }

  /**
   * Funkce vracející seznam osob
   * @param PDO $db
   */
  function getPersons(PDO $db){
    //TODO při velkém počtu záznamů by tu bylo vhodné doplnit offset a limit - zvládli byste to dodělat?
    $query=$db->prepare('SELECT * FROM persons ORDER BY name;');
    $query->execute();
    $persons=$query->fetchAll(PDO::FETCH_ASSOC);

    $result=[];
    if (!empty($persons)){
      foreach ($persons as $person){
        $result[$person['person_id']]=[
          'id'=>$person['person_id'],
          'name'=>$person['name'],
          'email'=>$person['email'],
          'phone'=>$person['phone'],
        ];
      }
    }

    send_json_response($result);
  }

  /**
   * Funkce vytvářející novou osobu
   * @param PDO $db
   */
  function createPerson(PDO $db){
    //nejprve musíme data zkontrolovat!
    $errors=[];
    $personData=get_json_request_body();
    if ($personData){
      #region kontroly
      $personData['name']=trim(@$personData['name']);
      if (empty($personData['name'])){
        $errors[]='Musíte zadat jméno osoby.';
      }

      $personData['email']=trim(@$personData['email']);
      if (!filter_var($personData['email'],FILTER_VALIDATE_EMAIL)){
        $errors[]='Pokud je zadán e-mail, musí být platný.';
      }

      $personData['phone']=trim(@$personData['phone']);
      #endregion kontroly
    }else{
      $errors[]='Musíte zadat data osoby ve formátu JSON.';
    }

    if (empty($errors)){
      //uložení dat do DB
      $query=$db->prepare('INSERT INTO persons (name, phone, email) VALUES (:name, :phone, :email);');
      $query->execute([
        ':name'=>$personData['name'],
        ':phone'=>$personData['phone'],
        ':email'=>$personData['email']
      ]);

      //odeslání údajů o vytvořené osobě
      $id=$db->lastInsertId();
      $personQuery=$db->prepare('SELECT * FROM persons WHERE person_id=:id LIMIT 1;');
      $personQuery->execute([':id'=>$id]);

      $person=$personQuery->fetch(PDO::FETCH_ASSOC);
      $result=[
        'id'=>$person['person_id'],
        'name'=>$person['name'],
        'email'=>$person['email'],
        'phone'=>$person['phone'],
      ];
      send_json_response($result, 201);

    }else{
      //odeslání chyby
      send_error_response($errors, 400);
    }
  }

  /**
   * Funkce aktualizující existující osobu
   * @param PDO $db
   */
  function updatePerson(PDO $db){
    //nejprve musíme data zkontrolovat!
    $errors=[];

    $existingPersonQuery=$db->prepare('SELECT * FROM persons WHERE person_id=:id LIMIT 1;');
    $existingPersonQuery->execute([':id'=>$_GET['id']]);
    $existingPerson=$existingPersonQuery->fetch(PDO::FETCH_ASSOC);
    if (!$existingPerson){
      send_error_response('Person not found!', 404);
      return;
    }

    $personData=get_json_request_body();
    if ($personData){
      #region kontroly
      $personData['name']=trim(@$personData['name']);
      if (empty($personData['name'])){
        $errors[]='Musíte zadat jméno osoby.';
      }

      $personData['email']=trim(@$personData['email']);
      if (!filter_var($personData['email'],FILTER_VALIDATE_EMAIL)){
        $errors[]='Pokud je zadán e-mail, musí být platný.';
      }

      $personData['phone']=trim(@$personData['phone']);
      #endregion kontroly
    }else{
      $errors[]='Musíte zadat data osoby ve formátu JSON.';
    }

    //uložení dat
    if (empty($errors)){
      //uložení dat do DB
      $query=$db->prepare('UPDATE persons SET name=:name, phone=:phone, email=:email WHERE person_id=:id LIMIT 1;');
      $query->execute([
        ':name'=>$personData['name'],
        ':phone'=>$personData['phone'],
        ':email'=>$personData['email'],
        ':id'=>$existingPerson['person_id']
      ]);

      //odeslání údajů o uložené osobě
      $personQuery=$db->prepare('SELECT * FROM persons WHERE person_id=:id LIMIT 1;');
      $personQuery->execute([':id'=>$existingPerson['person_id']]);

      $person=$personQuery->fetch(PDO::FETCH_ASSOC);
      $result=[
        'id'=>$person['person_id'],
        'name'=>$person['name'],
        'email'=>$person['email'],
        'phone'=>$person['phone'],
      ];
      send_json_response($result, 200);

    }else{
      //odeslání chyby
      send_error_response($errors, 400);
    }
  }

  /**
   * Funkce pro smazání osoby
   * @param PDO $db
   */
  function deletePerson(PDO $db){
    //kontrola existence dané osoby
    $existingPersonQuery=$db->prepare('SELECT * FROM persons WHERE person_id=:id LIMIT 1;');
    $existingPersonQuery->execute([':id'=>$_GET['id']]);
    $existingPerson=$existingPersonQuery->fetch(PDO::FETCH_ASSOC);
    if (!$existingPerson){
      send_error_response('Person not found!', 404);
      return;
    }

    //smazání osoby
    $deleteQuery=$db->prepare('DELETE FROM persons WHERE person_id=:id LIMIT 1;');
    $deleteQuery->execute([':id'=>$_GET['id']]);

    //odeslání potvrzení pro uživatele
    send_json_response(['status'=>'ok', 'message'=>'Person deleted.']);
  }