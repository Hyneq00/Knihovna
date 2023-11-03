
<?php
require "assetss/database.php";
require "assetss/funkce_kniha.php";
$connection = connectiondb();

if ( is_numeric($_GET["id"]) and isset($_GET["id"]) ){
    $book = getBook($connection,$_GET["id"]);
}
var_dump($_GET["id"]);
var_dump($book);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type = "text/css" href="css/header.css">
    <title>Document</title>
</head>
<body>
<?php require "assetss/header.php";?>

<h1>Kniha</h1>
<h3>Název: <?=htmlspecialchars($book["title"])?></h3>
<h3>Autor: <?=htmlspecialchars($book["author"])?></h3>
<h3>Rok vydání: <?=htmlspecialchars($book["year_of_publication"])?></h3>
<h3>Žánr: <?=htmlspecialchars($book["genre"])?></h3>


</body>
</html>
