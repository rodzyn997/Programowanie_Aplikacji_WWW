
<?
 error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
 /* po tym komentarzu będzie kod do dynamicznego ładowania stron */
 include('cfg.php');

?>

<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Bartosz Radzanowski" />
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>

    <title>Żółwie wodne</title>
</head>

<body onload="startClock()">

<table>
    <tr>

        <td class="menu"><span> <a href="index.php"> Strona Główna </a> </td>
        <td class="menu"><a href="index.php?idp=zdj"> Galeria </a> </td>
        <td class="menu"> <a href="index.php?idp=onas"> O nas </a> </td>
        <td class="menu"><a href="index.php?idp=kontakt"> Kontakt </a> </td>
        <td class="menu"><a href="index.php?idp=info"> Nasze Produkty </a> </td>
        <td class="menu"><a href="koszyk.php"> Koszyk </a> </td>



    </tr>
</table>
<div class="poz" id="zegarek"></div>
<div class="poz"id="data"></div>

<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	
	if($_GET['idp'] == '') $strona = 'html/glowna.html';
	if($_GET['idp'] == 'kontakt') $strona = 'html/kontakt.html';
	if($_GET['idp'] == 'onas') $strona = 'html/onas.html';
	if($_GET['idp'] == 'zdj') $strona = 'html/zdj.html';
	if($_GET['idp'] == 'info') $strona = 'html/info.html';
	if($_GET['idp'] == 'jquery') $strona = 'html/jquery.html';
    if($_GET['idp'] == 'skrypty') $strona = 'html/skrypty.html';
    if($_GET['idp'] == 'filmy') $strona = 'html/filmy.html';
    if($_GET['idp'] == 'cfg') $strona = 'cfg.php';
    if($_GET['idp'] == 'koszyk') $strona = 'koszyk.php';

	if (file_exists($strona)) {
		include($strona);
	}
	else {
		echo 'Strona '.$strona.' nie istnieje. <br/><br/>';
	}
?>

</body>
</html>