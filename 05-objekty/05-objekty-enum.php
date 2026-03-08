<?php
enum Role: string {
  case ADMIN = 'admin';
  case USER = 'user';
  case GUEST = 'guest';
}

class Uzivatel {
  public function __construct(
    public readonly int $id,
    public Role $role
  ){
  }
}

$u = new Uzivatel(1, Role::USER);

//Enum::cases() – výpis všech možností
foreach (Role::cases() as $role) {
  echo $role->name . ' = ' . $role->value . PHP_EOL;
}

//Enum::from() – převod hodnoty na enum (vyhodí výjimku při neplatné hodnotě)
$roleFromDb = 'admin';
$role = Role::from($roleFromDb); // OK

$u2 = new Uzivatel(2, $role);

//Enum::tryFrom() – bezpečný převod na enum, pokud je možný (hodnota v enumu existuje)
$input = $_POST['role'] ?? '';

$role = Role::tryFrom($input);

if ($role === null){
  echo 'Neplatná role';
} else {
  $u3 = new Uzivatel(3, $role);
  echo 'Uživatel má roli: ' . $role->name;
}