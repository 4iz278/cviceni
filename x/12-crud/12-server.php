<?php
# nezapomenout poslat hlavicku + kodovani!
header("Content-Type: application/json;charset=utf-8");

# nacteme data, v produkci napr. z databaze
# ted jen staticka data pro zjednoduseni
# vsimnete si 2D pole (pole poli)
echo json_encode([
	[
		'id' => 1,
		'first_name'=> "Jimmy",
		'last_name'=> "Hendrix",
		'address' => "All Along the Watchtower 1, Los Angeles, CA"
	],
	
	[
		'id' => 2,
		'first_name'=> "John",
		'last_name'=> "Frusciante",
		'address' => "Californication & Hump de Bumb Street 33, Venice Beach, CA"
	]
]);
?>