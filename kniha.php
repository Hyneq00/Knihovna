
<?php
require "assetss/database.php";
require "assetss/funkce_kniha.php";

$database = new Database();
$connection = $database->connectiondb();

if ( is_numeric($_GET["id"]) and isset($_GET["id"]) ){
    $book = Books::getBook($connection,$_GET["id"]);
} else {
    $book = null;
}

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
<section>
    <?php if ($book === null ): ?>
                <p> Kniha nenalezena </p>
    <?php  else: ?>
        <h1>Kniha</h1>
        <h3>Název: <?=htmlspecialchars($book["title"]) ?> </h3>
        <h3>Autor: <?=htmlspecialchars($book["author"])?></h3>
        <h3>Rok vydání: <?=htmlspecialchars($book["year_of_publication"])?></h3>
        <h3>Žánr: <?=htmlspecialchars($book["genre"])?></h3>
    <?php endif ?>
</section>




</body>
</html>
