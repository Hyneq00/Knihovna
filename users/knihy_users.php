<?php
require "../assetss/database.php";
require "../assetss/authorization.php";
require "../assetss/funkce_kniha.php";
$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedInUser()) {
    die("Nepovolený přístup");
}

$books = Books::allBooks($connection)


?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "../assetss/link_users.php" ?>
    <title>Document</title>
</head>
<body>
<?php require"../assetss/users_header.php" ?>

<h1>Seznam všech knih</h1><br>
<?php if (empty($books)):?>
    <p>Nenalezeno</p>
<?php else: ?>
    <ul>
    <?php foreach($books as $one_book): ?>
        <h1>Název:  <?=htmlspecialchars($one_book["title"])?></h1>
        <?php
        $imagePath = "../uploads/".$one_book["image"];
        // Kontrola, zda je soubor k dispozici
        if (file_exists($imagePath) && $imagePath !== "../uploads/" ) {
            echo '<img src="'.$imagePath.'" alt="Muj Obrazek">';
        } else {
            // Pokud chybi fotka, zobraz jinou
            echo '<img src="../uploads/001.png" alt="Alternativni Obrazek">';
        }
        ?>
        <?php if($one_book["avaliable"] === "true"): ?>
          <h1>Dostupnost:</h1>  <div id="colorSquare" style="width: 50px; height: 50px;background-color: green;"></div>
        <?php elseif ($one_book["avaliable"] === "false"): ?>
            <h1>Dostupnost:</h1> <div id="colorSquare" style="width: 50px; height: 50px;background-color: red;"></div>
        <?php endif ?>
        <a href="kniha_users.php?id=<?=$one_book["id_book"]?>">Info</a>
    <?php endforeach; ?>
    </ul>

<?php endif;?>

</body>
</html>