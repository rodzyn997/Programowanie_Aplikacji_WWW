            <!-- zad1 --->
<?php
 $nr_indeksu = '1234567';
 $nrGrupy = 'X';
 echo 'Jan Kowalski'.$nr_indeksu.' grupa'.$nrGrupy.' <br /><br />';
 echo 'Zastosowanie metody include() <br />';

?>
            <!-- zad2-->
<?php
// a)

include 'vars.php';
echo 'A '.$color.' '.$fruit.'</br></br>'; // A green apple

//require_once 'varss.php';  //daje error
echo 'kolor: '.$color.'</br>'.'owoc: '.$fruit.'</br></br>';
?>

<?php
// b)
$a = 3;
$b = 3;
if ($a < $b)
    echo "b is bigger than a";
elseif($a > $b)
    echo "a is bigger than b";
else
    echo "liczby są rowne</br></br>";

$i = 12;
switch ($i) {
    case 0:
        echo "i equals 0";
        break;
    case 1:
        echo "i equals 1";
        break;
    case 2:
        echo "i equals 2";
        break;
    default:
        echo "liczba inna niż(0,1,2)</br></br>";
        break;
}
?>

<?php
// c)

$s = 1;
while ($s <= 10) {
    echo $s++.', ';
}
echo '</br>';
for ($i = 1; $i <= 10; $i++) {
    echo $i.', ';
}
echo '<br></br>';

?>

<form method="get">
<input type="text" name="name"/>
<input type="submit" value="submit"/>
</form>
<?php

 echo 'Hello ' .$_GET["name"] . '!';
?>
<form method="post">
    <input type="text" name="name"/>
    <input type="submit" value="submit"/>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo 'Hello ' . $_POST["name"] . '!';
}
 ?>









