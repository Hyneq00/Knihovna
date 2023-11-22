
<?php
require "../assetss/database.php";
require "../assetss/funkce_kniha.php";
require  "../assetss/authorization.php";

$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedInUser() ) {
    die("Nepovolený přístup");
}
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
    <link rel="stylesheet" type = "text/css" href="../css/header.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>
<body>
<?php require "../assetss/users_header.php";?>
<section>
    <?php if ($book === null ): ?>
        <p> Kniha nenalezena </p>
    <?php  else: ?>
        <h1>Kniha</h1>
        <h3>Název: <?=htmlspecialchars($book["title"])?></h3>
        <h3>Autor: <?=htmlspecialchars($book["author"])?></h3>
        <h3>Rok vydání: <?=htmlspecialchars($book["year_of_publication"])?></h3>
        <h3>Žánr: <?=htmlspecialchars($book["genre"])?></h3>
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
    <br>
    <?php if($book["avaliable"] === "true"): ?>
        <h3>Dostupnost:</h3>  <div id="colorSquare" style="width: 50px; height: 50px;background-color: green;"></div>
    <?php elseif ($book["avaliable"] === "false"): ?>
        <h3>Dostupnost:</h3> <div id="colorSquare" style="width: 50px; height: 50px;background-color: red;"></div>
    <?php endif ?>
    <br>
</section>




</body>
</html>