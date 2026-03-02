<pre>
<?php

//deklarace pole

$array = array(
    "foo" => "bar",
    "bar" => "foo",
);

// od PHP 5.4
$array = [
    "foo" => "bar",
    "bar" => "foo",
];

// key: integer nebo string, val: jakykoli typ

// indexed array
// automaicky prirazeny klice 0-3
$array = array("foo", "bar", "hello", "world");
var_dump($array);

//pristup k prvkum pole

// pristup k auto-klicum
// pozor, pole se cisluji od 0 !!!
var_dump($array[1]); // bar

//pres klic
$array = array("foo"=>"bar", "one"=>"two");
var_dump($array["foo"]); // bar


//pridavani prvku do pole
$array = array("foo"=>"bar", "one"=>"two");
$array["x"] = "dalsi prvek"; //"x" => "dalsi prvek"
$array[] = "jiny prvek"; // 0 => "jiny prvek"
var_dump($array);

?>

</pre>