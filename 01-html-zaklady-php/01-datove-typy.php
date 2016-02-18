<h1>Booleans</h1>

<?php

// booleans

// true, TRUE, True, booleans jsou case insensitive
// http://php.net/manual/en/language.types.boolean.php

var_dump((bool) true);    // bool(true)
var_dump((bool) TRue);    // bool(true)
var_dump((bool) "TRUE");    // bool(true)
var_dump((bool) "1");       // bool(true)
var_dump((bool) "false");   // bool(true)  // !!! pozor !!!
var_dump((bool) "FALSE");   // bool(true) // !!! pozor !!!

var_dump((bool) 1);         // bool(true)
var_dump((bool) -2);        // bool(true)
var_dump((bool) "foo");     // bool(true)
var_dump((bool) 2.3e5);     // bool(true)
var_dump((bool) array(12)); // bool(true)

var_dump((bool) 0);     // bool(false), integer
var_dump((bool) 0.0);     // bool(false), float

var_dump((bool) false);   // bool(false)
var_dump((bool) FALSE);   // bool(false)
var_dump((bool) "0");       // bool(false) // !!! pozor, string, ale bere ho jako false, protoze je 0 !!!
var_dump((bool) "0.0");       // bool(true) // !!! pozor, string !!!

var_dump((bool) "");        // bool(false)
var_dump((bool) array());   // bool(false)
var_dump((bool) " ");        // bool(true) !!! pozor, mezera je prazdny znak!

?>


<h1>Integers</h1>

	
<?php

//integers


$a = 1234; // decimal number
var_dump($a);

$a = -123; // a negative number
var_dump($a);

$a = 0123; // octal number (equivalent to 83 decimal)
var_dump($a);

$a = 0x1A; // hexadecimal number (equivalent to 26 decimal)
var_dump($a);

$a = 0b11111111; // binary number (equivalent to 255 decimal)
var_dump($a);



//integer overflow to float

//32-bit system

$large_number = 2147483647;
var_dump($large_number);						// int(2147483647)

$large_number = 2147483648;
var_dump($large_number);            // float(2147483648)

$million = 1000000;
$large_number =  50000 * $million;
var_dump($large_number);            // float(50000000000)


//integer division

var_dump(21/7);         // int(3)

var_dump(25/7);         // float(3.5714285714286)

var_dump((int) (25/7)); // int(3)

var_dump(round(25/7));  // float(4) 


?>


<h1>Floats aka doubles aka real numbers</h1>


<?php

//floats

$a = 1.234;

$b = 1.2e3; 

$c = 7E-10;

// pozor na ztratu presnosti pri konverzi na binarni cisla !!!
// http://www.exploringbinary.com/why-0-point-1-does-not-exist-in-floating-point/
$d = (0.1+0.7)*10; //7.9999999999999991118
var_dump(floor($d));

// BC Math Functions
// http://php.net/manual/en/ref.bc.php
// pozor, cisla se zadavaji jako string!

bcscale(4); //pozor, musime nastavit presnost, default 0 
$e = bcmul(bcadd('0.1', '0.7'), '10');
var_dump(floor($e));


// porovnavani cisel

var_dump((0.1+0.7)*10 == 8);  // bool(false)

// http://php.net/manual/en/function.bccomp.php
// shoda, pokud vraci int 0
var_dump(bccomp($e, '8'));


?>


<h1>Strings</h1>
	
	
<?php

// jednoduche uvozovky ''

echo 'this is a simple string';

echo 'You can also have embedded newlines in 
strings this way as it is
okay to do';

// backslash \'
// Outputs: Arnold once said: "I'll be back"
echo 'Arnold once said: "I\'ll be back"';

// backslash \\
// Outputs: You deleted C:\*.*?
echo 'You deleted C:\\*.*?';

// Outputs: You deleted C:\*.*?
echo 'You deleted C:\*.*?';

// Outputs: This will not expand: \n a newline
echo 'This will not expand: \n a newline';

// Outputs: Variables do not $expand $either
echo 'Variables do not $expand $either';
?>


<?php

//dvojite uvozovky
/* vyhodnocuji se promenne a tyto specialni znaky
\n	linefeed (LF or 0x0A (10) in ASCII)
\r	carriage return (CR or 0x0D (13) in ASCII)
\t	horizontal tab (HT or 0x09 (9) in ASCII)
\v	vertical tab (VT or 0x0B (11) in ASCII) (since PHP 5.2.5)
\e	escape (ESC or 0x1B (27) in ASCII) (since PHP 5.4.0)
\f	form feed (FF or 0x0C (12) in ASCII) (since PHP 5.2.5)
\\	backslash
\$	dollar sign
\"
*/

$a = "ahoj";

echo "Pozdrav: $a";
	
//newline
echo '<pre>Jednoduche uvozovky: Prvni radek\nDruhy radek</pre>'; //nevyhodnoti se \n
echo "<pre>Dvojite uvozovky: Prvni radek\nDruhy radek</pre>"; //vyhodnoti se \n

?>


<?php

// string conversion to numbers

$foo = 1 + "10.5";                // $foo is float (11.5)
$foo = 1 + "-1.3e3";              // $foo is float (-1299)
$foo = 1 + "bob-1.3e3";           // $foo is integer (1)
$foo = 1 + "bob3";                // $foo is integer (1)
$foo = 1 + "10 Small Pigs";       // $foo is integer (11)
$foo = 4 + "10.2 Little Piggies"; // $foo is float (14.2)
$foo = "10.0 pigs " + 1;          // $foo is float (11)
$foo = "10.0 pigs " + 1.0;        // $foo is float (11)
  
?>





