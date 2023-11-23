
<?php
require "../assetss/database.php";
require "../assetss/funkce_kniha.php";

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
    <?php require "../assetss/link_main.php" ?>
    <title>Document</title>
</head>
<body>
<?php require "../assetss/header_main.php" ?>
<section>
    <?php if ($book === null ): ?>
        <p> Book was not founded. </p>
    <?php  else: ?>
        <h1>Book</h1>
        <h3>Title: <?=htmlspecialchars($book["title"])?></h3>
        <h3>Author: <?=htmlspecialchars($book["author"])?></h3>
        <h3>Year of publication: <?=htmlspecialchars($book["year_of_publication"])?></h3>
        <h3>Genre: <?=htmlspecialchars($book["genre"])?></h3>
        <?php
        $imagePath = "../uploads/".$book["image"];
        // Kontrola, zda je soubor k dispozici
        if (file_exists($imagePath) && $imagePath !== "../uploads/" ) {
            echo '<img src="'.$imagePath.'" alt="Muj Obrazek">';
        } else {
            // Pokud chybi fotka, zobraz jinou
            echo '<img src="../uploads/001.png" alt="Alternativni Obrazek">';
        }

        ?>
    <?php endif ?>
    <?php if($book["avaliable"] === "true"): ?>
        <h3>Dostupnost:</h3>  <div id="colorSquare" style="width: 50px; height: 50px;background-color: green;"></div>
    <?php elseif ($book["avaliable"] === "false"): ?>
        <h3>Dostupnost:</h3> <div id="colorSquare" style="width: 50px; height: 50px;background-color: red;"></div>
    <?php endif ?>
    <br>
</section>




</body>
</html>
