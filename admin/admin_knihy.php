<?php
require "../assetss/database.php";
require "../assetss/authorization.php";

$database = new Database();
$connection = $database->connectiondb();

session_start();

if (!Authorization::isLoggedIn() ) {
    die("Nepovolený přístup");
}

$sql = "SELECT * FROM kniha";
$stmt = $connection->prepare($sql);

$stmt->execute();
$book = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
<?php require "../assetss/admin_header.php" ?>
<h1>Seznam všech knih</h1><br>
<?php if (empty($book)):?>
    <p>Nenalezeno</p>
<?php else: ?><ul>
    <?php foreach($book as $one_book): ?>
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
        <a href="admin_kniha.php?id=<?= $one_book["id"]?>">Info</a>
    <?php endforeach; ?>
    </ul>

<?php endif;?>

</body>
</html>